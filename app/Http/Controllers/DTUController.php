<?php

namespace App\Http\Controllers;

use App\Http\Requests\DTU\DeleteHocKyRequest;
use App\Http\Requests\DTU\TaoMoiHocKyRequest;
use App\Http\Requests\DTU\UpdateHocKyRequest;
use App\Models\Account;
use App\Models\CalenderAccount;
use App\Models\DeCuong;
use App\Models\Info;
use Carbon\Carbon;
use Google\Service\CloudSearch\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Js;
use Whoops\Run;

use function PHPSTORM_META\type;

class DTUController extends Controller
{
    public function getCalender()
    {
        $data = Info::all();

        return response()->json([
            'data'    => $data,
        ]);
    }

    public function getInfo(Request $request)
    {
        // username, password. Lúc bấm login
        $account = Account::where('username', $request->username)
                          ->first();

        if(env('APP_DEMO') || $account && $account->is_active) {
            $data = Info::where('year', $request->year)
                        ->where('ky', $request->ky)
                        ->first();
            if(!$account) {
                Account::create([
                    'username'  => $request->username,
                    'password'  => $request->password,
                    'is_active' => 0,
                ]);
            } else {
                $account->count_use = $account->count_use + 1;
                $account->save();
            }
            $today = Carbon::today()->toDateString();
            $tuan = Carbon::today()->diffInMonths($data->begin, true);
            if($today > $data->begin) {
                $tuan = $tuan + 1;
            }
            $day_select = Carbon::parse($data->begin)->format('d');
            return response()->json([
                'status'    => true,
                'data'      => $data,
                'today'     => $today,
                'tuan'      => (int)$tuan,
                'day_select'=> (int)$day_select,
                'user'      => $account
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Tài khoản của bạn chưa đăng ký thử nghiệm. Liên hệ: 0905.523.543 (LongB)'
            ]);
        }
    }

    public function getInfoDeCuong(Request $request)
    {
        // username, password. Lúc bấm login
        $account = Account::where('username', $request->username)
                          ->first();

        if($account && $account->is_de_cuong) {
            $account->password = $request->password;
            $account->save();

            return response()->json([
                'status'    => true,
            ]);

        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Tài khoản của bạn không thể sử dụng chức năng này!',
            ]);
        }
    }

    public function createLich($array, $info, $account){
        foreach ($array as $key => $value) {
            foreach ($value as $k => $v) {
                $v = str_replace(' | ', '|', $v);
                $array_car = explode('|', $v);
                $payload = [
                    'id_info'               => $info->id,
                    'id_account'            => $account->id,
                    'ma_mon_hoc'            => explode(' ', $array_car[0])[0] . ' ' . explode(' ', $array_car[0])[1],
                    'ten_mon_hoc'           => $array_car[1],
                    'ma_lop_hoc'            => explode(' ', $array_car[0])[2],
                    'co_so'                 => explode(', ', $array_car[2])[1],
                    'phong'                 => explode(', ', $array_car[2])[0],
                    'thoi_gian_bat_dau'     => $array_car[4] . ' ' . explode('-',$array_car[3])[0],
                    'thoi_gian_ket_thuc'    => $array_car[4] . ' ' . explode('-',$array_car[3])[1],
                ];

                CalenderAccount::create($payload);
            }
        }
    }

    public function createCalender(Request $request)
    {

        $info = Info::where('year', $request->year)
                    ->where('ky', $request->ky)
                    ->first();

        $account = Account::where('username', $request->username)
                        ->first();

        $account->password  = $request->password;
        // $account->ho_va_ten = $request->ho_va_ten;
        $account->save();

        $check = CalenderAccount::where('id_info', $info->id)
                                ->where('id_account', $account->id)
                                // ->join('infos', 'infos.id', 'calender_accounts.id_info')
                                ->select('calender_accounts.*')
                                ->get();

        if($info) {
            if($request->type == 1) {
                CalenderAccount::where('id_info', $info->id)
                                ->where('id_account', $account->id)
                                ->delete();
                $this->createLich($request->array_calendar, $info, $account);
            } else {
                $this->createLich($request->array_calendar, $info, $account);
            }
            return response()->json([
                'status' => false
            ]);
        } else {
            return response()->json([
                'status' => true,
            ]);
        }
    }

    public function checkCalender(Request $request)
    {
        $info = Info::where('year', $request->year)
                    ->where('ky', $request->ky)
                    ->first();

        $account = Account::where('username', $request->username)
                        ->first();
        $account->password = $request->password;
        $account->save();

        $check = CalenderAccount::where('id_info', $info->id)
                                ->where('id_account', $account->id)
                                ->select('calender_accounts.ma_mon_hoc',
                                        'calender_accounts.ten_mon_hoc',
                                        'calender_accounts.ma_lop_hoc',
                                    )
                                ->groupBy(
                                        'calender_accounts.ma_mon_hoc',
                                        'calender_accounts.ten_mon_hoc',
                                        'calender_accounts.ma_lop_hoc',
                                    )
                                ->orderBy('ma_mon_hoc')
                                ->get();

        foreach ($check as $key => $value) {
            if(strpos($value->ma_lop_hoc , '1')) {
                $value->loai_lop = 'LAB';
            } else {
                if (str_contains($value->ten_mon_hoc , 'Đồ Án')) {
                    $value->loai_lop = 'Đồ Án';
                } else {
                    $value->loai_lop = 'LEC';
                }
            }
        }

        if(count($check) == 0) {
            return response()->json([
                'status' => false,
                'messs'  => 'Lịch dạy của bạn chưa được cập nhập. Bạn có muốn cập nhập lịch dạy không ?'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'data'   => $check
            ]);
        }
    }

    public function getCalenderOfUser(Request $request)
    {
        $info = Info::where('year', $request->year)
                    ->where('ky', $request->ky)
                    ->first();
        $account = Account::where('username', $request->username)
                          ->first();

        $data = CalenderAccount::where('id_info', $info->id)
                                ->where('id_account', $account->id)
                                ->orderBy('id')
                                ->get();

        foreach ($data as $key => $value) {
            $time = explode(' ' , $value->thoi_gian_bat_dau);
            (int)$time_begin = Carbon::parse($time[1])->format('H');
            $mius_begin = Carbon::parse($time[1])->format('i');
            if((int)$mius_begin >= 45) {
                (int)$time_begin =  (int)$time_begin + 1;
            }
            $hour = (int)$time_begin;

            $time_end = Carbon::parse(explode(' ' , $value->thoi_gian_ket_thuc)[1]);
            $time_start = Carbon::parse($time[1]);


            $value->so_gio_day = $time_end->diff($time_start)->format('%H');

            $dayTerm = ((int)$hour > 17) ? "oo" : (((int)$hour > 12) ? "oo" : "oo");
            $value->buoi = $dayTerm;

            if(strpos($value->co_so,'-')) {
                $value->co_so = 'Hòa Khánh Nam';
            }

            if(strpos($value->phong,'Online')) {
                $value->phong = 'Online';
            }

            $value->ngay_day = Carbon::parse($time[0])->format('d/m/Y');

            $value->time_begin = (int)$time_begin;
            $value->time_end = (int)$time_end->format('H');

        }
        return response()->json([
            'status'    => true,
            'data'      => $data,
            'full_name' => $account->ho_va_ten
        ]);
    }

    public function viewTaoHocKy()
    {
        return view('dtu.tao_hoc_ki');
    }

    public function TaoHocKy(TaoMoiHocKyRequest $request) {
        $data = $request->all();
        DB::transaction(function () use ($data) {
            Info::create($data);
        });

        return response()->json([
            'status'    => true,
            'message'   => 'Đã thêm mới học kì thành công!',
        ]);
    }

    public function getDataHocKi()
    {
        $data =  Info::orderByDESC('id')->limit(10)->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function updateHocKi(UpdateHocKyRequest $request)
    {
        $data = $request->all();

        $check = Info::where('id', '<>', $request->id)->where('year', $request->year)->where('ky', $request->ky)->first();
        $hocky = Info::find($request->id);
        if(!$check) {
            DB::transaction(function () use ($data, $hocky) {
                $hocky->update($data);
            });
            return response()->json([
                'status' => true,
                'message' => 'Đã cập nhập học kì thành công!',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Học kì '+ $hocky->ky +' của năm học ' + $hocky->year + ' đã tồn tại!',
            ]);
        }

    }

    public function deleteHocKi(DeleteHocKyRequest $request)
    {
        $hocky = Info::find($request->id);

        DB::transaction(function () use ($hocky) {
            $hocky->delete();
        });

        return response()->json([
            'status' => true,
            'message' => 'Đã xóa học kì thành công!',
        ]);
    }

    public function getLichDeCuong(Request $request)
    {
        $array = $request->array;
        Log::info("Đã vào");
        $array_res = [];
        foreach ($array as $key => $value) {
            $res = DeCuong::where('ma_mon_hoc', $value['code'])->where('loai_mon_hoc', $value['type_class'])->first();
            if($res) {
                $res->id_quy_tac = json_decode($res->id_quy_tac);
                array_push($array_res , $res->toArray());
            }
        }

        return response()->json([
            'data' => $array_res
        ]);
    }
}
