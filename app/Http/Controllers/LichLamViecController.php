<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\LichLamViec\CreateLichLamViecRequest;
use App\Http\Requests\Admin\LichLamViec\UpdateBuoiLamViecRequest;
use App\Http\Requests\Admin\LichLamViec\UpdateLichLamViecRequest;
use App\Models\LichLamViec;
use App\Models\LichSupport;
use App\Models\NhanVien;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LichLamViecController extends Controller
{
    public function index()
    {
        return view('admin.page.lich_lam_viec.index');
    }

    public function viewDangKyLichLamViec()
    {
        return view('admin.page.lich_lam_viec.dang_ky');
    }

    public function dataDangKyLichLamViec($type)
    {
        $type = 7 * $type;
        $user = Auth::guard('nhanVien')->user();
        // $user = auth('sanctum')->user();
        $now  = Carbon::today()->addDays($type);
        $thu  = $now->dayOfWeek == 0 ? 8 : $now->dayOfWeek + 1;
        $weekStartDate = Carbon::today()->addDays(9 + $type - $thu);
        $weekEndDate   = Carbon::today()->addDays(15 + $type - $thu);

        $days = [];
        $data = [];

        $lichLamViecUser = LichLamViec::where('id_nhan_vien', $user->id)
            ->whereDate('ngay_lam_viec', '>=', $weekStartDate)
            ->whereDate('ngay_lam_viec', '<=', $weekEndDate)
            ->get();

        $lichLamViecAll  = LichLamViec::whereDate('ngay_lam_viec', '>=', $weekStartDate)
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
                            // $str_id   = implode(",", $array);
                            // dd($str_id);
                            array_push($arr_is_trang_thai, $arr_info);
                            array_push($ids, $array);
                            // array_push($ids, $str_id);
                        } else {
                            array_push($str, '/assets/images/avatars/avatar-1.png');
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

    public function dataDangKyLichLamViecVue($type)
    {
        $type = 7 * $type;
        // $user = Auth::guard('nhanVien')->user();
        $user = auth('sanctum')->user();
        $now  = Carbon::today()->addDays($type);
        $thu  = $now->dayOfWeek == 0 ? 8 : $now->dayOfWeek + 1;
        $weekStartDate = Carbon::today()->addDays(9 + $type - $thu);
        $weekEndDate   = Carbon::today()->addDays(15 + $type - $thu);

        $days = [];
        $data = [];

        $lichLamViecUser = LichLamViec::where('id_nhan_vien', $user->id)
            ->whereDate('ngay_lam_viec', '>=', $weekStartDate)
            ->whereDate('ngay_lam_viec', '<=', $weekEndDate)
            ->get();

        $lichLamViecAll  = LichLamViec::whereDate('ngay_lam_viec', '>=', $weekStartDate)
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
                            // $str_id   = implode(",", $array);
                            // dd($str_id);
                            array_push($arr_is_trang_thai, $arr_info);
                            array_push($ids, $array);
                            // array_push($ids, $str_id);
                        } else {
                            array_push($str, '/assets/images/avatars/avatar-1.png');
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

    public function storeDangKyLichLamViec(CreateLichLamViecRequest $request)
    {
        $data = $request->all();
        // dd($data);
        $user = Auth::guard('nhanVien')->user();
        // $user = auth('sanctum')->user();
        $data['ngay_lam_viec'] = Carbon::createFromFormat('d/m/Y', $request->ngay_lam_viec)->format('Y-m-d');
        $data['id_nhan_vien']  = $user->id;

        // $now = Carbon::today()->addDays(2);
        $now = Carbon::today();
        // dd(date("N"));
        $thu = date('N', strtotime($data['ngay_lam_viec']));

        if ($now->greaterThan(Carbon::parse($data['ngay_lam_viec']))) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Không được thêm lịch làm việc cũ!',
            ]);
        }

        $check_buoi_lam_sp = LichSupport::where('ngay_lam_viec', $data['ngay_lam_viec'])
                                        ->where('buoi_lam_viec', $data['buoi_lam_viec'])
                                        ->where('id_nhan_vien', $user->id)
                                        ->first();

        DB::transaction(function () use ($data, $check_buoi_lam_sp, $thu) {
            LichLamViec::create($data);
            // dd($check_buoi_lam_sp);
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
            'message'   => 'Đã thêm mới lịch làm việc',
        ]);
    }
    public function storeDangKyLichLamViecVue(CreateLichLamViecRequest $request)
    {
        $data = $request->all();
        // dd($data);
        // $user = Auth::guard('nhanVien')->user();
        $user = auth('sanctum')->user();
        $data['ngay_lam_viec'] = Carbon::createFromFormat('d/m/Y', $request->ngay_lam_viec)->format('Y-m-d');
        $data['id_nhan_vien']  = $user->id;

        // $now = Carbon::today()->addDays(2);
        $now = Carbon::today();

        $thu = date('N', strtotime($data['ngay_lam_viec']));

        if ($now->greaterThan(Carbon::parse($data['ngay_lam_viec']))) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Không được thêm lịch làm việc cũ!',
            ]);
        }

        $check_buoi_lam_sp = LichSupport::where('ngay_lam_viec', $data['ngay_lam_viec'])
                                        ->where('buoi_lam_viec', $data['buoi_lam_viec'])
                                        ->where('id_nhan_vien', $user->id)
                                        ->first();

        DB::transaction(function () use ($data, $check_buoi_lam_sp, $thu) {
            LichLamViec::create($data);
            // dd($check_buoi_lam_sp);
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
            'message'   => 'Đã thêm mới lịch làm việc',
        ]);
    }

    public function updateDangKyLichLamViec(UpdateLichLamViecRequest $request)
    {
        // dd($request->toArray());
        $user = Auth::guard('nhanVien')->user();
        // $user = auth('sanctum')->user();
        $data = $request->all();
        // dd($data['is_trang_thai']);
        $res = DB::transaction(function () use ($data, $user) {
            $lichLamViec = LichLamViec::find($data['id']);
            // dd($lichLamViec);
            if ($data['is_trang_thai'] == 4) {
                if ($user->id_quyen != 0) {
                    $now = Carbon::today()->addDays(2);
                    // $now = Carbon::today();
                    if ($now->greaterThan(Carbon::parse($lichLamViec->ngay_lam_viec))) {
                        return false;
                    }
                }
                $lichLamViec->delete();
            } else {
                $lichLamViec->is_trang_thai = $data['is_trang_thai'];
                $lichLamViec->save();
            }
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

    public function updateDangKyLichLamViecVue(UpdateLichLamViecRequest $request)
    {
        // dd($request->toArray());
        // $user = Auth::guard('nhanVien')->user();
        $user = auth('sanctum')->user();
        $data = $request->all();
        // dd($data['is_trang_thai']);
        $res = DB::transaction(function () use ($data, $user) {
            $lichLamViec = LichLamViec::find($data['id']);
            // dd($lichLamViec);
            if ($data['is_trang_thai'] == 4) {
                if ($user->id_quyen != 0) {
                    // $now = Carbon::today()->addDays(3);
                    $now = Carbon::today();
                    if ($now->greaterThan(Carbon::parse($lichLamViec->ngay_lam_viec))) {
                        return false;
                    }
                }
                $lichLamViec->delete();
            } else {
                $lichLamViec->is_trang_thai = $data['is_trang_thai'];
                $lichLamViec->save();
            }
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

    public function dataBuoiLamViec(Request $request)
    {
        $dataBuoiLamViec = LichLamViec::where('lich_lam_viecs.id', $request->id_buoi_lam_viec)
            ->join('nhan_viens', 'lich_lam_viecs.id_nhan_vien', 'nhan_viens.id')
            ->select('lich_lam_viecs.*', 'nhan_viens.ho_va_ten', 'nhan_viens.ten_goi_nho')
            ->first();
        return response()->json([
            'dataBuoiLamViec'   =>  $dataBuoiLamViec,
        ]);
    }

    public function updateNoiDungBuoiLamViec(UpdateBuoiLamViecRequest $request)
    {
        // dd($request->all());
        $user = Auth::guard('nhanVien')->user();

        $status = DB::transaction(function () use ($request, $user) {
            if ($user->id_quyen == 0) {
                $data                      = $request->all();
                $data['id_nguoi_danh_gia'] = $user->id;
                $data['noi_dung_buoi_danh_gia'] = $request->noi_dung_buoi_danh_gia;
                LichLamViec::find($data['id'])->update($data);
                return 1;
            } else {
                $data   = $request->except('danh_gia');
                $lichLamViec = LichLamViec::where('id', $request->id)
                    ->where('id_nhan_vien', $user->id)
                    ->whereDate('ngay_lam_viec', Carbon::today())
                    ->first();
                if ($lichLamViec) {
                    $lichLamViec->update($data);
                    return 1;
                } else {
                    return 0;
                }
            }
        });

        return response()->json([
            'status'    => $status,
            'message'   => $status == 1 ? 'Đã cập nhật nội dung buổi làm việc' : 'Chỉ được cập nhật nội dung của mình và trong ngày!',
        ]);
    }
    public function updateNoiDungBuoiLamViecVue(UpdateBuoiLamViecRequest $request)
    {
        $user = $user = auth('sanctum')->user();

        $status = DB::transaction(function () use ($request, $user) {
            if ($user->id_quyen == 0) {
                $data                      = $request->all();
                $data['id_nguoi_danh_gia'] = $user->id;
                $data['noi_dung_buoi_danh_gia'] = $request->noi_dung_buoi_danh_gia;
                LichLamViec::find($data['id'])->update($data);
                return 1;
            } else {
                $data   = $request->except('danh_gia');
                $lichLamViec = LichLamViec::where('id', $request->id)
                    ->where('id_nhan_vien', $user->id)
                    ->whereDate('ngay_lam_viec', Carbon::today())
                    ->first();
                if ($lichLamViec) {
                    $lichLamViec->update($data);
                    return 1;
                } else {
                    return 0;
                }
            }
        });

        return response()->json([
            'status'    => $status,
            'message'   => $status == 1 ? 'Đã cập nhật nội dung buổi làm việc' : 'Chỉ được cập nhật nội dung của mình và trong ngày!',
        ]);
    }
}
