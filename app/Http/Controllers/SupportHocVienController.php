<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\Support\LopDangDayRequest;
use App\Models\SupportHocVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupportHocVienController extends Controller
{
    public function store(LopDangDayRequest $request)
    {
        $data                   = $request->all();
        $data['id_nhan_vien']   = Auth::guard('nhanVien')->user()->id;
        SupportHocVien::create($data);

        return response()->json([
            'status'    =>  1,
            'message'   => 'Đã cập thông tin support'
        ]);
    }

    public function storeVue(LopDangDayRequest $request)
    {
        $data                   = $request->all();
        $data['id_nhan_vien']   = auth('sanctum')->user()->id;
        SupportHocVien::create($data);

        return response()->json([
            'status'    =>  1,
            'message'   => 'Đã cập thông tin support'
        ]);
    }

    public function thongTinDaSupport(Request $request)
    {
        $data = SupportHocVien::where('id_hoc_vien', $request->id_hoc_vien)
                              ->where('id_lop_hoc', $request->id_lop_hoc)
                              ->join('nhan_viens', 'nhan_viens.id', 'support_hoc_viens.id_nhan_vien')
                              ->select('support_hoc_viens.*', 'nhan_viens.ho_va_ten')
                              ->get();

        return response()->json([
            'data'  => $data
        ]);
    }
    public function destroy(Request $request)
    {
        $data = $request->all();

        DB::transaction(function () use ($data) {
            SupportHocVien::find($data['id'])->delete();
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã xoá nội dung support!',
        ]);
    }
}
