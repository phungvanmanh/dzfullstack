<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\NhanVien\ChangePasswordRequest;
use App\Http\Requests\Admin\NhanVien\CreateNhanVienRequest;
use App\Http\Requests\Admin\NhanVien\DeleteNhanVienRequest;
use App\Http\Requests\Admin\NhanVien\UpdateNhanVienRequest;
use App\Http\Requests\Admin\NhanVien\UpdateProfileRequest;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NhanVienController extends Controller
{

    public function index()
    {
        return view('admin.page.nhan_vien.index');
    }

    public function store(CreateNhanVienRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        DB::transaction(function () use ($data) {
            NhanVien::create($data);
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã thêm mới nhân viên thành công!',
        ]);
    }

    public function getData()
    {
        $data = NhanVien::all();

        return response()->json([
            'data'  => $data,
        ]);
    }

    public function destroy(DeleteNhanVienRequest $request)
    {
        $data = $request->all();

        DB::transaction(function () use ($data) {
            NhanVien::find($data['id'])->delete();
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã xoá nhân viên thành công!',
        ]);
    }

    public function update(UpdateNhanVienRequest $request)
     {
        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        DB::transaction(function () use ($data) {
            NhanVien::find($data['id'])->update($data);
        });

        return response()->json([
            'status'  => true,
            'message'=> 'Thay Đổi Trạng Thái Thành Công!'
        ]);
    }

    public function changeStatus(Request $request){
        $nhanVien = NhanVien::find($request->id);
        // dd($nhanVien);
        if($nhanVien) {
            $nhanVien->is_open = !$nhanVien->is_open;
            $nhanVien->save();
            return response()->json([
                'status' => true,
                'message'=> 'Thay Đổi Trạng Thái Thành Công!'
            ]);
        }
        return response()->json([
            'status' => false,
            'message'=> 'Đã có lỗi sự cố!'
        ]);
    }

    public function viewThongTinCaNhan()
    {
        return view('admin.page.nhan_vien.profile');
    }

    public function updateThongTinCaNhan(UpdateProfileRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        DB::transaction(function () use ($data) {
            NhanVien::find($data['id'])->update($data);
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã cập nhật Profile thành công!',
        ]);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $data = $request->all();
        DB::transaction(function () use ($data) {
            $nhanVien = NhanVien::find($data['id']);
            $nhanVien->password = bcrypt($data['password']);
            $nhanVien->save();
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã cập nhật mật khẩu thành công!',
        ]);
    }

    public function getDataNV()
    {
        $data = NhanVien::where('id_quyen','>', 0)
                        ->where('is_open', 1)
                        ->get();
        return response()->json([
            'data'  => $data,
        ]);
    }
}
