<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNoiQuyRequest;
use App\Http\Requests\DeleteNoiQuyRequest;
use App\Http\Requests\UpdateNoiQuyRequest;
use App\Models\NoiQuy;
use Illuminate\Http\Request;

class NoiQuyController extends Controller
{
    public function index()
    {
        return view('admin.page.noi_quy.index');
    }

    public function getData()
    {
        $data = NoiQuy::all();

        return response()->json([
            'data' => $data
        ]);
    }

    public function store(CreateNoiQuyRequest $request)
    {
        $data = $request->all();
        NoiQuy::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Thêm mới nội quy thành công!'
        ]);
    }

    public function update(UpdateNoiQuyRequest $request)
    {
        $data = $request->all();
        $noi_quy = NoiQuy::find($request->id);
        $noi_quy->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Cập Nhập nội quy thành công!'
        ]);
    }

    public function destroy(DeleteNoiQuyRequest $request)
    {
        $noi_quy = NoiQuy::find($request->id);
        $noi_quy->delete();
        return response()->json([
            'status' => true,
            'message' => "Đã xóa Nội Quy Thành Công!"
        ]);
    }
}
