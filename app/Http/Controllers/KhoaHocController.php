<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\KhoaHoc\CreateKhoaHocRequest;
use App\Http\Requests\Admin\KhoaHoc\DeleteKhoaHocRequest;
use App\Http\Requests\Admin\KhoaHoc\StatusKhoaHocRequest;
use App\Http\Requests\Admin\KhoaHoc\UpdateKhoaHocRequest;
use App\Models\KhoaHoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KhoaHocController extends Controller
{
    public function index()
    {
        return view('admin.page.khoa_hoc.index');
    }

    public function store(CreateKhoaHocRequest $request)
    {
        $data = $request->all();
        DB::transaction(function () use ($data){
            KhoaHoc::create($data);
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã thêm mới khoá học thành công!',
        ]);
    }

    public function update(UpdateKhoaHocRequest $request)
    {
        $data = $request->all();

        DB::transaction(function () use ($data){
            KhoaHoc::find($data['id'])->update($data);
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã cập nhật khoá học thành công!',
        ]);

    }

    public function getData()
    {
        $data = KhoaHoc::all();
        return response()->json([
            'data'  => $data,
        ]);
    }

    public function destroy(DeleteKhoaHocRequest $request)
    {
        $data = $request->all();

        DB::transaction(function () use ($data){
            KhoaHoc::find($data['id'])->delete();
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã xoá khoá học thành công!',
        ]);
    }

}
