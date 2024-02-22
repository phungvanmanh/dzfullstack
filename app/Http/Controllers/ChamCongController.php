<?php

namespace App\Http\Controllers;

use App\Models\ChamCong;
use App\Models\LichLamViec;
use App\Models\NhanVien;
use Carbon\Carbon;
use Google\Service\CloudSearch\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class ChamCongController extends Controller
{
    public function index()
    {
        return view('admin.page.cham_cong.index');
    }

    public function searchByDay(Request $request)
    {
        $nhan_vien = NhanVien::where('is_open', 1)
                            ->select('id', 'ho_va_ten', 'id_quyen')
                            ->get();
                            // dd($nhan_vien->toArray()['id_quyen']);
        $arr = [];
        foreach ($nhan_vien as $key => $value) {
            if ($value->id_quyen > 0) {
                $obj = new stdClass();
                $dem = 1;
                $tong_cong = 0;
                $tong_diem_danh_gia = 0;
                // $tong_diem = 0;
                $data = $request->all();

                $month = $request['month'];
                $year  = $request['year'];
                $day   = 1;

                $last_day  = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $ngay_dau  = $year . "-" . sprintf("%02d", $month) . "-" . sprintf("%02d", $day);
                $ngay_cuoi = $year . "-" . sprintf("%02d", $month) . "-" . sprintf("%02d", $last_day);

                $day_begin = Carbon::parse($ngay_dau);
                $day_end   = Carbon::parse($ngay_cuoi);

                $thu           = $day_begin->dayOfWeek == 0 ? 8 : $day_begin->dayOfWeek + 1;
                $weekStartDate = Carbon::parse($ngay_dau);
                // dd($weekStartDate);
                $weekEndDate   = Carbon::parse($ngay_dau)->addDays(8 - $thu);
                //chấm công
                $cham_cong = LichLamViec::whereDate('ngay_lam_viec', '>=', $weekStartDate)
                                        ->whereDate('ngay_lam_viec', '<=', $weekEndDate)
                                        ->where('id_nhan_vien', $value->id)
                                        // ->where('is_trang_thai', 1)
                                        ->select(DB::raw('count(id_nhan_vien) as cong'), DB::raw('SUM(danh_gia) as diem_danh_gia'))
                                        ->first();

                $cong               = [];
                $tuan               = [];
                $arr_danh_gia       = [];
                $date_range = array(date('Y-m-d',strtotime($weekStartDate)), date('Y-m-d',strtotime($weekEndDate)));
                $date_range_string = implode(",", $date_range); // nối chuỗi thành "2023-03-01,2023-03-05"
                array_push($tuan, $date_range_string); // đẩy chuỗi vào mảng A

                if($cham_cong){
                    array_push($cong, $cham_cong->cong);
                    $tong_cong          += $cham_cong->cong;
                    $tong_diem_danh_gia += $cham_cong->diem_danh_gia;
                } else {
                    array_push($cong, 0);
                    $tong_cong          += 0;
                    $tong_diem_danh_gia += 0;
                }
                //end Chấm Công

                //Điểm đánh giá
                $ngay_start = Carbon::parse(explode(',', $date_range_string)[0]);
                $ngay_end   = Carbon::parse(explode(',', $date_range_string)[1]);
                $cham_diem = LichLamViec::whereDate('ngay_lam_viec', '>=', $ngay_start)
                                        ->whereDate('ngay_lam_viec', '<=', $ngay_end)
                                        ->where('id_nhan_vien', $value->id)
                                        ->select(DB::raw('SUM(danh_gia) as diem_danh_gia'))
                                        ->first();


                if($cham_diem){
                    array_push($arr_danh_gia, $cham_diem->diem_danh_gia * 1);
                } else {
                    array_push($arr_danh_gia, 0 * 1);
                }
                //End đánh giá


                $obj->id                      = $value->id;
                $obj->ho_va_ten               = $value->ho_va_ten;
                $obj->cong                    = $cong;
                $obj->tong_cong               = $tong_cong;
                $obj->cham_diem               = $arr_danh_gia;
                $obj->tuan                    = $tuan;
                // $obj->diem_danh_gia           = $diem_danh_gia;
                while ($weekEndDate < $day_end) {
                    $dem++;
                    $weekEndDate = $weekEndDate->toDayDateTimeString();
                    $startDate = Carbon::parse($weekEndDate)->addDay();
                    $endDate   = Carbon::parse($weekEndDate)->addDays(7);

                    $ngay_bat_dau_tuan_cuoi = Carbon::parse($weekEndDate);
                    $diff = $ngay_bat_dau_tuan_cuoi->diff($day_end);
                    $days = $diff->days;

                    //add số lượng ngày tùy vào tuần nằm ở cuối tháng đó
                    if($days == 0) {
                        $endDate   = Carbon::parse($weekEndDate);
                    } else if($days > 0 && $days < 6) {
                        $endDate   = Carbon::parse($weekEndDate)->addDays($days);
                    }

                    //chấm công
                    $array_cong = [1,3];
                    $cham_cong = LichLamViec::whereDate('ngay_lam_viec', '>=', $startDate)
                                        ->whereDate('ngay_lam_viec', '<=', $endDate)
                                        ->where('id_nhan_vien', $value->id)
                                        ->whereIn('is_trang_thai', $array_cong)
                                        ->select(DB::raw('count(id_nhan_vien) as cong'), DB::raw('SUM(danh_gia) as diem_danh_gia'))
                                        ->first();


                    $date_range = array(date('Y-m-d',strtotime($startDate)), date('Y-m-d',strtotime($endDate)));
                    $date_range_string = implode(",", $date_range); // nối chuỗi thành "2023-03-01,2023-03-05"
                    array_push($tuan, $date_range_string); // đẩy chuỗi vào mảng A

                    if($cham_cong){
                        array_push($cong, $cham_cong->cong);
                        $tong_cong          += $cham_cong->cong;
                        $tong_diem_danh_gia += $cham_cong->diem_danh_gia;
                    } else {
                        array_push($cong, 0);
                        $tong_cong          += 0;
                        $tong_diem_danh_gia += 0;
                    }

                    //Điểm đánh giá
                    $ngay_start = Carbon::parse(explode(',', $date_range_string)[0]);
                    $ngay_end   = Carbon::parse(explode(',', $date_range_string)[1]);
                    $cham_diem = LichLamViec::whereDate('ngay_lam_viec', '>=', $ngay_start)
                                            ->whereDate('ngay_lam_viec', '<=', $ngay_end)
                                            ->where('id_nhan_vien', $value->id)
                                            ->select(DB::raw('SUM(danh_gia) as diem_danh_gia'))
                                            ->first();


                    if($cham_diem){
                        array_push($arr_danh_gia, $cham_diem->diem_danh_gia * 1);
                    } else {
                        array_push($arr_danh_gia, 0 * 1);
                    }
                    //End đánh giá

                    $obj->cong      = $cong;
                    $obj->tong_cong = $tong_cong;
                    $obj->tong_diem_danh_gia = $tong_diem_danh_gia;
                    $obj->cham_diem = $arr_danh_gia;
                    $weekEndDate    = $endDate;
                    $obj->tuan      = $tuan;
                }
                array_push($arr, $obj);
            }
        }
        // dd($arr);
        return response()->json([
            'data'  =>  $arr,
            'dem'   =>  $dem
        ]);
    }

    // Mid viết
    public function dataChamCong(Request $request)
    {
        $month = $request->month;
        $year  = $request->year;
        $nhan_vien = NhanVien::where('is_open', 1)
                            ->select('id', 'ho_va_ten', 'id_quyen')
                            ->get();

        $thang_hien_tai = 1 ."-" .$month . "-" . $year;
        $ngay_dau_thang  = Carbon::parse($thang_hien_tai)->startOfMonth();
        $ngay_cuoi_thang = Carbon::parse($thang_hien_tai)->endOfMonth();
        $data_cham_cong  = LichLamViec::whereDate('ngay_lam_viec', '>=', $ngay_dau_thang)
                                      ->whereDate('ngay_lam_viec', '<=', $ngay_cuoi_thang)
                                      ->whereIn('is_trang_thai', [1,3])
                                      ->get();
        $tuan_dau   = Carbon::parse($ngay_dau_thang)->weekOfYear;
        $tuan_cuoi  = Carbon::parse($ngay_cuoi_thang)->weekOfYear;
        $array_tuan = [];
        foreach ($nhan_vien as $key => $value) {
            $array_data_nv = [];
            $tong_danh_gia = 0;
            $tong_buoi_lam = 0;
            for($i = $tuan_dau; $i <= $tuan_cuoi; $i++ ) {
                if(!in_array($i, $array_tuan)) {
                    array_push($array_tuan, $i);
                }
                $array_info_tuan = [];
                $cong = 0;
                $diem_danh_gia = 0;
                foreach ($data_cham_cong as $key => $value_cong) {
                    $tuan_lam_viec = Carbon::parse($value_cong->ngay_lam_viec)->weekOfYear;
                    if($tuan_lam_viec == $i && $value_cong->id_nhan_vien == $value->id) {
                        $cong++;
                        $diem_danh_gia = $diem_danh_gia + $value_cong->danh_gia;
                    }
                }
                $tong_danh_gia = $tong_danh_gia + $diem_danh_gia;
                $tong_buoi_lam = $tong_buoi_lam + $cong;

                array_push($array_info_tuan, $i, $cong, $diem_danh_gia);
                array_push($array_data_nv, $array_info_tuan);
            }
            $value->cham_cong = $array_data_nv;
            $value->tong_danh_gia = $tong_danh_gia;
            $value->tong_buoi_lam = $tong_buoi_lam;
        }

        return response()->json([
            'data'  => $nhan_vien,
            'weeks' => $array_tuan,
        ]);
    }

    public function listNgayLam(Request $request)
    {
        $year  = $request->year;
        $week  = $request->week;

        $ngay_dau_thang = 1 . "-" . $request->month . "-" . $request->year;
        $ngay_dau_thang = Carbon::parse($ngay_dau_thang);

        $date = Carbon::createFromDate($year, 1, 1)->setISODate($year, $week)->startOfWeek();

        if($date->lessThan($ngay_dau_thang)) {
            $ngay_dau_tuan = $ngay_dau_thang;
        } else {
            $ngay_dau_tuan = $date;
        }
        $ngay_cuoi_tuan = Carbon::createFromDate($year, 1, 1)->setISODate($year, $week)->endOfWeek();
        $data = LichLamViec::whereDate('ngay_lam_viec', '>=', $ngay_dau_tuan)
                                ->whereDate('ngay_lam_viec', '<=', $ngay_cuoi_tuan)
                                ->where('id_nhan_vien', $request['id'])
                                ->orderByDESC('ngay_lam_viec')
                                ->get();
        return response()->json([
            'data'  =>  $data,
        ]);
    }


    public function indexCheckIn(){
        return view('admin.page.cham_cong_check_in.index');
    }
    public function checkInChamCong(Request $request){
        $ip = $request->ip();
        dd($ip);
        $admin = Auth::guard('nhanVien')->user();
        $now =Carbon::now('Asia/Ho_Chi_Minh');
        $ip = $request->ip();

        if($now->hour < 12){
            if ($now->format('H:i') > '08:15' ) {
                ChamCong::create([
                    'id_nhan_vien' => $admin->id,
                    'ghi_chu'      => $request->ghi_chu,
                    'ip_cham_cong' => $request->ip(),
                    'trang_thai'   => 0,
                    'ca'           => 0,
                ]);
            }else{
                ChamCong::create([
                    'id_nhan_vien' => $admin->id,
                    'ghi_chu'      => $request->ghi_chu,
                    'ip_cham_cong' => $request->ip(),
                    'trang_thai'   => 1,
                    'ca'           => 0,
                ]);
            }
        }
    }
}
