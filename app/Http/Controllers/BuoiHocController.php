<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\BuoiHoc\ThemMoiBuoiHocRequest;
use App\Models\BuoiHoc;
use App\Models\HocVienLopHoc;
use App\Models\KhoaHoc;
use App\Models\LichHoc;
use App\Models\LopHoc;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Contracts\Service\Attribute\Required;
use Yoeunes\Toastr\Facades\Toastr;

class BuoiHocController extends Controller
{
    public function index($id_lop_hoc)
    {
        $buoiHoc = BuoiHoc::where('id_lop_hoc', $id_lop_hoc)->get();

        if(count($buoiHoc) > 0) {
            $lopHoc = LopHoc::find($id_lop_hoc);
            $tenLopHoc = $lopHoc->ten_lop_hoc;
            $so_thang_hoc = $lopHoc['so_thang_hoc'];
            $so_buoi_hoc = $lopHoc['so_buoi_trong_thang'];
            $id_lop_hoc = $id_lop_hoc;
            return view('admin.page.buoi_hoc.index', compact('tenLopHoc','so_thang_hoc','id_lop_hoc','so_buoi_hoc'));
        } else {
            Toastr::error('Lớp học không tồn tại!');
            return redirect()->back();
        }
    }

    public function getData($id_lop_hoc)
    {
        $list = BuoiHoc::where('id_lop_hoc', $id_lop_hoc)
                        ->join('nhan_viens', 'buoi_hocs.id_nhan_vien_day', 'nhan_viens.id')
                        ->join('lop_hocs', 'lop_hocs.id', 'buoi_hocs.id_lop_hoc')
                        ->select('buoi_hocs.*', 'nhan_viens.ho_va_ten', 'lop_hocs.so_thang_hoc', 'lop_hocs.so_buoi_trong_thang',
                                    DB::raw("DATE_FORMAT(buoi_hocs.gio_bat_dau, '%d-%m-%Y %H:%i:%s') AS bat_dau"),
                                    DB::raw("DATE_FORMAT(buoi_hocs.gio_ket_thuc, '%d-%m-%Y %H:%i:%s') AS ket_thuc"),
                                    DB::raw("DATE_FORMAT(buoi_hocs.gio_bat_dau, '%Y-%m-%d') AS start"),
                                    DB::raw("DATE_FORMAT(buoi_hocs.gio_ket_thuc, '%d-%m-%Y') AS end"),
                        )
                        ->orderBy('buoi_hocs.thu_tu_buoi_khoa_hoc')
                        ->get();
        $data_thang_hoc = BuoiHoc::where('id_lop_hoc', $id_lop_hoc)
                                ->join('lop_hocs', 'lop_hocs.id', 'buoi_hocs.id_lop_hoc')
                                ->select('buoi_hocs.id_lop_hoc', 'lop_hocs.ten_lop_hoc', 'lop_hocs.so_thang_hoc', 'lop_hocs.so_buoi_trong_thang')
                                ->first();
        $list_thang = [];
        array_push($list_thang, $data_thang_hoc);
        if(count($list) > 0) {
            return response()->json([
                'list'  => $list,
                'data_thang_hoc' => $list_thang
            ]);
        } else {
            Toastr::error('Lớp học không tồn tại!');
            return redirect('/');
        }
    }

    public function getDataBuoiHoc($id_buoi_hoc)
    {
        $data = BuoiHoc::find($id_buoi_hoc);
        if($data){
            return response()->json([
                'data'  =>  $data,
            ]);
        } else {
            Toastr::error('Buổi học không tồn tại!');
            return redirect()->back();
        }
    }

    public function store(ThemMoiBuoiHocRequest $request)
    {
        DB::transaction(function () use ($request){
            $buoiHocCuoi = BuoiHoc::where('id_lop_hoc', $request->id_lop_hoc)
                            ->orderByDESC('thu_tu_buoi_khoa_hoc')
                            ->first();

            $data = $request->all();
            $data['thu_tu_buoi_khoa_hoc'] = $buoiHocCuoi->thu_tu_buoi_khoa_hoc + 1;
            BuoiHoc::create($data);
        });

        return response()->json([
            'status'    =>  1,
            'message'   =>  'Đã thêm mới buổi học thành công!',
        ]);
    }

    public function update(Request $request)
    {
        DB::transaction(function () use ($request){
            $data = $request->all();
            $buoiHoc = BuoiHoc::find($data['id_buoi_hoc']);

            $buoiHoc->update($data);
        });

        return response()->json([
            'status'    =>  1,
            'message'   =>  'Đã cập nhật buổi học thành công!',
        ]);
    }

    public function delete($id_buoi_hoc)
    {
        $buoiHoc = BuoiHoc::find($id_buoi_hoc);
        if($buoiHoc) {
            $buoiHoc->delete();
            return response()->json([
                'status'    =>  1,
                'message'   =>  'Đã xóa buổi học thành công!',
            ]);
        } else {
            Toastr::error('Buổi học không tồn tại!');
        }
    }

    public function view() {
        // $lopHoc = LopHoc::where('id',$id_lop_hoc)->first();
        return view('admin.page.tong_ket_thang.index');
    }

    public function getDataTheoKhoa(Request $request) {
        $data = LopHoc::where('id', $request->id_lop_hoc)->first();
        return response()->json([
            'data'   => $data,
        ]);
    }
}
