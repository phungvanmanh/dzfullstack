<?php

namespace App\Http\Controllers;

use App\Jobs\ShareVideoJob;
use App\Models\BuoiHoc;
use App\Models\HocVien;
use App\Models\HocVienLopHoc;
use App\Models\LichHoc;
use App\Models\LopHoc;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Yoeunes\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isNull;

class LichHocController extends Controller
{
    public function hocVienBuoiHoc($id_buoi_hoc)
    {
        $buoiHoc = BuoiHoc::find($id_buoi_hoc);
        if(!$buoiHoc) {
            return response()->json([
                'status'    => 0
            ]);
        }

        $hocVien = HocVienLopHoc::where('id_lop_hoc', $buoiHoc->id_lop_hoc)
                                ->where('is_hoc_vien', 1)
                                ->get();

        foreach($hocVien as $k => $v) {
            $check = LichHoc::where('id_hoc_vien', $v->id_hoc_vien)
                            ->where('id_buoi_hoc', $id_buoi_hoc)
                            ->first();
            if(!$check) {
                LichHoc::create([
                    'id_buoi_hoc'   => $id_buoi_hoc,
                    'id_hoc_vien'   => $v->id_hoc_vien,
                    'tinh_trang'    => 0,
                ]);
            }
        }

        return response()->json([
            'status' => 1
        ]);

    }

    public function index($id_buoi_hoc)
    {
        $buoiHoc = BuoiHoc::find($id_buoi_hoc);
        if(!$buoiHoc) {
            Toastr::error("Thông tin không chính xác!");
            return redirect('/admin');
        }
        $hocVien = HocVienLopHoc::where('id_lop_hoc', $buoiHoc->id_lop_hoc)
                                ->where('is_hoc_vien', 1)
                                ->get();
        foreach($hocVien as $k => $v) {
            $check = LichHoc::where('id_hoc_vien', $v->id_hoc_vien)
                            ->where('id_buoi_hoc', $id_buoi_hoc)
                            ->first();

            if(!$check) {
                LichHoc::create([
                    'id_buoi_hoc'   => $id_buoi_hoc,
                    'id_hoc_vien'   => $v->id_hoc_vien,
                    'tinh_trang'    => 0,
                ]);
            }
        }

        return view('admin.page.lich_hoc.index');
    }

    public function getData($id_buoi_hoc)
    {
        // $data = HocVien::join('lich_hocs', 'hoc_viens.id', 'lich_hocs.id_hoc_vien')
        //                ->where('lich_hocs.id_buoi_hoc', $id_buoi_hoc)
        //                ->where('hoc_vien_lop_hocs.is_hoc_vien', 1)
        //                ->join('buoi_hocs', 'lich_hocs.id_buoi_hoc', 'buoi_hocs.id')
        //                ->join('hoc_vien_lop_hocs', 'hoc_viens.id' , 'hoc_vien_lop_hocs.id_hoc_vien')
        //                ->orderBy('hoc_viens.ten')
        //                ->select('lich_hocs.*', 'hoc_viens.ho_va_ten', 'hoc_viens.ho_lot','hoc_viens.ten','hoc_viens.email',
        //                 DB::raw("DATE_FORMAT(buoi_hocs.gio_bat_dau, '%Y-%m-%d') AS start"),
        //                 'hoc_vien_lop_hocs.is_hoc_vien'
        //                 )
        //                ->get();
        $buoiHoc = BuoiHoc::find($id_buoi_hoc);
        $data = LichHoc::where('lich_hocs.id_buoi_hoc', $id_buoi_hoc)
                       ->join('hoc_viens', 'hoc_viens.id', 'lich_hocs.id_hoc_vien')
                       ->join('hoc_vien_lop_hocs', 'hoc_viens.id' , 'hoc_vien_lop_hocs.id_hoc_vien')
                       ->where('hoc_vien_lop_hocs.is_hoc_vien', 1)
                       ->where('hoc_vien_lop_hocs.id_lop_hoc', $buoiHoc->id_lop_hoc)
                       ->join('buoi_hocs', 'lich_hocs.id_buoi_hoc', 'buoi_hocs.id')
                       ->select('lich_hocs.*', 'hoc_viens.ho_va_ten', 'hoc_viens.ho_lot','hoc_viens.ten','hoc_viens.email',
                        DB::raw("DATE_FORMAT(buoi_hocs.gio_bat_dau, '%Y-%m-%d') AS start"),
                            'hoc_vien_lop_hocs.is_hoc_vien'
                        )
                        ->orderBy('hoc_viens.ten')
                       ->get();


        $count = 0;
        foreach ($data as $key => $value) {
            if($value->tinh_trang == 1) {
                $count++;
            }
        }
        // dd($data->toArray());
        return response()->json([
            'data'  => $data,
            'count' => $count,
        ]);
    }

    public function getDataChuaLamBT($id_buoi_hoc) {
        $data = HocVien::leftjoin('lich_hocs', 'hoc_viens.id', 'lich_hocs.id_hoc_vien')
                        ->where('lich_hocs.id_buoi_hoc', $id_buoi_hoc)
                        ->where('hoc_vien_lop_hocs.is_hoc_vien', 1)
                        ->whereRaw('lich_hocs.danh_gia_bai_tap is null')
                        ->join('buoi_hocs', 'lich_hocs.id_buoi_hoc', 'buoi_hocs.id')
                        ->join('hoc_vien_lop_hocs', 'hoc_viens.id' , 'hoc_vien_lop_hocs.id_hoc_vien')
                        ->orderBy('hoc_viens.ten')
                        ->select('lich_hocs.*', 'hoc_viens.ho_va_ten','hoc_viens.ho_lot','hoc_viens.ten', DB::raw("DATE_FORMAT(buoi_hocs.gio_bat_dau, '%Y-%m-%d') AS start"),'hoc_vien_lop_hocs.is_hoc_vien')
                        ->get();
        return response()->json([
            'data'  => $data,
        ]);
    }

    public function getDataTheoThang(Request $request) {
        // dd($request->all());
        $list_buoi_hoc = BuoiHoc::where('id_lop_hoc' , $request->id_lop_hoc)
                                ->where('thu_tu_buoi_khoa_hoc', '>=', $request->buoi_bat_dau)
                                ->where('thu_tu_buoi_khoa_hoc', '<=', $request->buoi_ket_thuc)
                                ->orderBy('gio_bat_dau')
                                ->select('id')
                                ->get();
        $array_lich_hoc     = [];
        $array_id_buoi_hoc  = [];
        $list_hoc_vien = HocVienLopHoc::where('id_lop_hoc', $request->id_lop_hoc)
                                      ->where('hoc_vien_lop_hocs.is_hoc_vien', 1)
                                      ->join('hoc_viens', 'hoc_viens.id', 'hoc_vien_lop_hocs.id_hoc_vien')
                                      ->orderBy('hoc_viens.ten')
                                      ->select('hoc_vien_lop_hocs.*', 'hoc_viens.ho_va_ten','hoc_viens.ten')
                                      ->get();

        $list_buoi_hoc_hoc_vien = LichHoc::whereIn('id_buoi_hoc', $list_buoi_hoc->toArray())
                                        ->orderBy('id_buoi_hoc')
                                        ->get();

        foreach ($list_buoi_hoc as $key => $value) {
            array_push($array_id_buoi_hoc, $value->id);
        }
        foreach ($list_buoi_hoc_hoc_vien as $key => $value) {
            array_push($array_lich_hoc, $value->id_buoi_hoc);
        }
        $clear_id_buoi_trung = array_values(array_unique($array_lich_hoc));
        $common_elements = array_intersect($array_id_buoi_hoc, $array_lich_hoc);
        $so_buoi_hoc = count($common_elements);

        return response()->json([
            'list_buoi_hoc'          => $array_id_buoi_hoc,
            'list_hoc_vien'          => $list_hoc_vien,
            'list_buoi_hoc_hoc_vien' => $list_buoi_hoc_hoc_vien,
            'so_buoi_hoc'            => $so_buoi_hoc,
            'list_id_buoi_hoc'       => $clear_id_buoi_trung,
        ]);
    }

    public function getDataDiHoc($id_buoi_hoc) {

        $data = HocVien::leftjoin('lich_hocs', 'hoc_viens.id', 'lich_hocs.id_hoc_vien')
                        ->where('lich_hocs.id_buoi_hoc', $id_buoi_hoc)
                        ->where('lich_hocs.tinh_trang', 1)
                        ->join('buoi_hocs', 'lich_hocs.id_buoi_hoc', 'buoi_hocs.id')
                        ->join('hoc_vien_lop_hocs', 'hoc_viens.id' , 'hoc_vien_lop_hocs.id_hoc_vien')
                        ->select('lich_hocs.*', 'hoc_viens.ho_va_ten', 'hoc_viens.ho_lot', 'hoc_viens.ten', DB::raw("DATE_FORMAT(buoi_hocs.gio_bat_dau, '%Y-%m-%d') AS start"),'hoc_vien_lop_hocs.is_hoc_vien')
                        ->orderBy('hoc_viens.ten')
                        ->get();
        // dd($data->toArray());
        return response()->json([
            'data'  => $data,
        ]);

    }

    public function getDataVangPhep($id_buoi_hoc) {
        $data = HocVien::leftjoin('lich_hocs', 'hoc_viens.id', 'lich_hocs.id_hoc_vien')
                        ->where('lich_hocs.id_buoi_hoc', $id_buoi_hoc)
                        ->where('lich_hocs.tinh_trang', 2)
                        ->join('buoi_hocs', 'lich_hocs.id_buoi_hoc', 'buoi_hocs.id')
                        ->join('hoc_vien_lop_hocs', 'hoc_viens.id' , 'hoc_vien_lop_hocs.id_hoc_vien')
                        ->select('lich_hocs.*', 'hoc_viens.ho_va_ten', 'hoc_viens.ho_lot', 'hoc_viens.ten', DB::raw("DATE_FORMAT(buoi_hocs.gio_bat_dau, '%Y-%m-%d') AS start"),'hoc_vien_lop_hocs.is_hoc_vien')
                        ->get();

        return response()->json([
            'data'  => $data,
        ]);

    }

    public function getDataVangKhong($id_buoi_hoc) {
        $data = HocVien::leftjoin('lich_hocs', 'hoc_viens.id', 'lich_hocs.id_hoc_vien')
                        ->where('lich_hocs.id_buoi_hoc', $id_buoi_hoc)
                        ->where('lich_hocs.tinh_trang', 3)
                        ->join('buoi_hocs', 'lich_hocs.id_buoi_hoc', 'buoi_hocs.id')
                        ->join('hoc_vien_lop_hocs', 'hoc_viens.id' , 'hoc_vien_lop_hocs.id_hoc_vien')
                        ->select('lich_hocs.*', 'hoc_viens.ho_va_ten', 'hoc_viens.ho_lot', 'hoc_viens.ten', DB::raw("DATE_FORMAT(buoi_hocs.gio_bat_dau, '%Y-%m-%d') AS start"),'hoc_vien_lop_hocs.is_hoc_vien')
                        ->get();

        return response()->json([
            'data'  => $data,
        ]);

    }


    public function diemDanh(Request $request)
    {
        // dd($request->all());
        $data = $request->all();
        DB::transaction(function () use ($data){
            LichHoc::find($data['id'])->update($data);
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã cập nhật lịch học thành công!',
        ]);
    }

    public function updateNhanVienDanhGia(Request $request)
    {
        $data = $request->all();

        DB::transaction(function () use ($data){
            LichHoc::find($data['id'])->update($data);
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã cập nhật lịch học thành công!',
        ]);
    }

    public function updatehocVienDanhGia(Request $request)
    {
        $data = $request->all();

        DB::transaction(function () use ($data){
            LichHoc::find($data['id'])->update($data);
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã cập nhật lịch học thành công!',
        ]);
    }

    public function updateLyDoVang(Request $request) {
        $data = $request->all();
        DB::transaction(function () use ($data){
            LichHoc::find($data['id'])->update($data);
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã cập nhật lịch học thành công!',
        ]);
    }

    public function updateShareVideo(Request $request)
    {
        $data = $request->all();
        $data['is_share'] = !$data['is_share'];

        DB::transaction(function () use ($data){
            LichHoc::find($data['id'])->update($data);
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã cập nhật thành công!',
        ]);
    }

    public function shareVideo(Request $request)
    {
        $data = $request->all();
        if(count($data) > 0) {
            $buoiHoc = BuoiHoc::find($data[0]['id_buoi_hoc']);
            $lopHoc  = LopHoc::find($buoiHoc->id_lop_hoc);
            if($buoiHoc && $buoiHoc->link_video) {
                $dir = $lopHoc->link_driver_lop_hoc;
                $recursive = false;
                $listFileName = Storage::disk('google')->listContents($dir, $recursive);
                // $service      = Storage::disk('google')->getAdapter()->getService();
                $fileshare    = '';
                foreach($listFileName as $value) {
                    if($value['type'] == 'file' && $value['extraMetadata']['filename'] == $buoiHoc->link_video) {
                        $fileshare = $value['extraMetadata']['id'];
                    }
                }

                if(strlen($fileshare) < 5) {
                    return response()->json([
                        'status'    => 0,
                        'message'   => 'Buổi học không tồn tại hoặc video không có!',
                    ]);
                }

                ShareVideoJob::dispatch($fileshare, $data);

                return response()->json([
                    'status'    => 1,
                    'message'   => 'Đã share video thành công!',
                ]);

            } else {
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Buổi học không tồn tại hoặc video không có!',
                ]);
            }
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Học viên phải lớn hơn 1 thì mới share!',
            ]);
        }
    }

    // public function destroy(Request $request)
    // {
    //     $data = $request->all();

    //     DB::transaction(function () use ($data){
    //         LichHoc::find($data['id'])->delete();
    //     });

    //     return response()->json([
    //         'status'    => 1,
    //         'message'   => 'Đã xoá học viên thành công!',
    //     ]);
    // }
}
