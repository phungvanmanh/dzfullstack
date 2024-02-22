<?php

namespace App\Http\Controllers;

use App\Models\LichSupport;
use App\Models\NhanVien;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LichSupportController extends Controller
{
    public function lichLamViecTuan() {
        return view('admin.page.lich_support_tuan.index');
    }

    public function viewDangKyLichSupport()
    {
        return view('admin.page.dang_ky_support.index');
    }

    public function getDataNV()
    {
        $data = NhanVien::where('id_quyen','>', 0)
                        ->select('ten_goi_nho')
                        ->get();
        return response()->json([
            'data'  => $data,
        ]);
    }

    public function dataDangKyLichSupport($type)
    {
        $type = 7 * $type;

        $now  = Carbon::today()->addDays($type);
        $thu  = $now->dayOfWeek == 0 ? 8 : $now->dayOfWeek + 1;
        $weekStartDate = Carbon::today()->addDays(9 + $type - $thu);
        $weekEndDate   = Carbon::today()->addDays(15 + $type - $thu);

        $days = [];
        $data = [];


        $lichLamViecAll  = LichSupport::whereDate('ngay_lam_viec', '>=', $weekStartDate)
                                      ->whereDate('ngay_lam_viec', '<=', $weekEndDate)
                                      ->get();

        $index = 0;
        for ($i = $weekStartDate; $i <= $weekEndDate; $i->addDay()) {
            for ($j = 0; $j < 4; $j++) {
                $data[$i->format('d/m/Y')][$j] = 0;
                $id = 0;
                $str   = [];
                $ids   = [];
                $arr_nv_di_lam = [];
                $arr_is_trang_thai = [];
                foreach ($lichLamViecAll as $key => $value) {

                    if ($value->ngay_lam_viec == $i->format('Y-m-d') && $j == $value->buoi_lam_viec) {
                        $nhanVien = NhanVien::find($value->id_nhan_vien);
                        $arr_info = [];

                        if ($nhanVien &&  strlen($nhanVien->ten_goi_nho) > 0) {
                            array_push($arr_info, $nhanVien->ten_goi_nho, $value['is_trang_thai']);
                            array_push($arr_nv_di_lam, $nhanVien->ten_goi_nho);

                            $array = array($value->id, $value['is_trang_thai']);

                            array_push($arr_is_trang_thai, $arr_info);
                            array_push($ids, $array);
                        }
                    }
                }
                array_push($str, $arr_is_trang_thai);

                array_push($str,$arr_nv_di_lam);
                $info = collect([
                    'id'            => $id,
                    'list'          => $str,
                    'ids'           => $ids,
                ]);
                $data[$i->format('d/m/Y')][$j] = $info;
            }
            $index++;
        }

        $weekStartDate = Carbon::today()->addDays(9 + $type - $thu);
        array_push($days, $weekStartDate->format('Y-m-d'));
        // dd($thu);

        for ($i = 1; $i < 7; $i++) {
            array_push($days, $weekStartDate->addDay()->format('Y-m-d'));
        }
        // dd($data);
        return response()->json([
            'days'  => $days,
            'data'  => $data,
        ]);
    }

    public function dataDangKyLichLamViec($type)
    {
        $type = 7 * $type;
        $user = Auth::guard('nhanVien')->user();

        $now  = Carbon::today()->addDays($type);
        $thu  = $now->dayOfWeek == 0 ? 8 : $now->dayOfWeek + 1;
        $weekStartDate = Carbon::today()->addDays(9 + $type - $thu);
        $weekEndDate   = Carbon::today()->addDays(15 + $type - $thu);

        $days = [];
        $data = [];

        $lichLamViecUser = LichSupport::where('id_nhan_vien', $user->id)
                                      ->whereDate('ngay_lam_viec', '>=', $weekStartDate)
                                      ->whereDate('ngay_lam_viec', '<=', $weekEndDate)
                                      ->get();

        $lichLamViecAll  = LichSupport::whereDate('ngay_lam_viec', '>=', $weekStartDate)
            ->whereDate('ngay_lam_viec', '<=', $weekEndDate)
            ->get();

        $index = 0;
        for ($i = $weekStartDate; $i <= $weekEndDate; $i->addDay()) {
            for ($j = 0; $j < 4; $j++) {
                $data[$i->format('d/m/Y')][$j] = 0;
                $id = 0;
                $str   = [];
                $ids   = [];
                foreach ($lichLamViecUser as $key => $value) {
                    if ($value->ngay_lam_viec == $i->format('Y-m-d') && $j == $value->buoi_lam_viec) {
                        // dd($value);
                        $id  = $value->id;
                        break;
                    }
                }
                $arr_nv_di_lam = [];
                $arr_is_trang_thai = [];
                foreach ($lichLamViecAll as $key => $value) {

                    if ($value->ngay_lam_viec == $i->format('Y-m-d') && $j == $value->buoi_lam_viec) {
                        $nhanVien = NhanVien::find($value->id_nhan_vien);
                        $arr_info = [];

                        if ($nhanVien &&  strlen($nhanVien->ten_goi_nho) > 0) {
                            array_push($arr_info, $nhanVien->ten_goi_nho, $value['is_trang_thai']);
                            array_push($arr_nv_di_lam, $nhanVien->ten_goi_nho);

                            $array = array($value->id, $value['is_trang_thai']);

                            array_push($arr_is_trang_thai, $arr_info);
                            array_push($ids, $array);
                        }
                    }
                }
                array_push($str, $arr_is_trang_thai);

                array_push($str,$arr_nv_di_lam);
                $info = collect([
                    'id'            => $id,
                    'list'          => $str,
                    'ids'           => $ids,
                ]);
                $data[$i->format('d/m/Y')][$j] = $info;
            }
            $index++;
        }

        $weekStartDate = Carbon::today()->addDays(9 + $type - $thu);
        array_push($days, $weekStartDate->format('Y-m-d'));
        // dd($thu);

        for ($i = 1; $i < 7; $i++) {
            array_push($days, $weekStartDate->addDay()->format('Y-m-d'));
        }
        // dd($data);
        return response()->json([
            'days'  => $days,
            'data'  => $data,
        ]);
    }

    public function storeDangKyLichLamViec(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $user = Auth::guard('nhanVien')->user();
        // $user = auth('sanctum')->user();
        $data['ngay_lam_viec'] = Carbon::createFromFormat('d/m/Y', $request->ngay_lam_viec)->format('Y-m-d');
        $data['id_nhan_vien']  = $user->id;

        // $now = Carbon::today()->addDays(2);
        $now = Carbon::today();

        if ($now->greaterThan(Carbon::parse($data['ngay_lam_viec']))) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Không được thêm lịch support cũ!',
            ]);
        }
        $check_buoi_lam_sp = LichSupport::where('ngay_lam_viec', $data['ngay_lam_viec'])
                                        ->where('buoi_lam_viec', $data['buoi_lam_viec'])
                                        ->where('id_nhan_vien', $user->id)
                                        ->first();

        $thu = date('N', strtotime($data['ngay_lam_viec']));
        DB::transaction(function () use ($data,$check_buoi_lam_sp,$thu) {
        if($thu != 7) {
            if($data['buoi_lam_viec'] != 2 && $check_buoi_lam_sp == null) {
                LichSupport::create($data);
            }
        } else {
            if($check_buoi_lam_sp == null) {
                LichSupport::create($data);
            }
        }
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã thêm mới lịch support',
        ]);
    }

    public function updateDangKyLichLamViec(Request $request)
    {
        // dd($request->toArray());
        $user = Auth::guard('nhanVien')->user();
        // $user = auth('sanctum')->user();
        $data = $request->all();
        // dd($data['is_trang_thai']);
        $res = DB::transaction(function () use ($data, $user) {
            $lichSupport = LichSupport::find($data['id']);
            // dd($lichSupport);

            if ($user->id_quyen != 0) {
                // $now = Carbon::today()->addDays(3);
                $now = Carbon::today();
                if ($now->greaterThan(Carbon::parse($lichSupport->ngay_lam_viec))) {
                    return false;
                }
            }
            $lichSupport->delete();

            return true;
        });

        if ($res) {
            return response()->json([
                'status'    => 1,
                'message'   => 'Đã cập nhật lịch làm việc',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Không thể cập nhật trước 3 ngày!',
            ]);
        }
    }
}
