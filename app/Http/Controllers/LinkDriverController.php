<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLinkDriverRequets;
use App\Http\Requests\DeleteDriverRequets;
use App\Http\Requests\UpdateLinkDriverRequets;
use App\Models\LinkDriver;
use Illuminate\Http\Request;
use Illuminate\Support\Js;

class LinkDriverController extends Controller
{
    public function index() {
        return view('admin.page.link_driver.index');
    }

    public function getData()
    {
        $data = LinkDriver::get();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function store(CreateLinkDriverRequets $request)
    {
        $data = $request->all();
        LinkDriver::create($data);

        return response()->json([
            'status' => true,
            'message' => "Thêm mới Link Driver Chức Năng Thành Công!"
        ]);
    }

    public function update(UpdateLinkDriverRequets $request)
    {
        $data = $request->all();
        $link_driver = LinkDriver::find($request->id);
        $link_driver->update($data);

        return response()->json([
            'status' => true,
            'message' => "Thêm mới Link Driver Chức Năng Thành Công!"
        ]);
    }

    public function destroy(DeleteDriverRequets $request)
    {
        $link_driver = LinkDriver::find($request->id);
        $link_driver->delete();
        return response()->json([
            'status' => true,
            'message' => "Đã xóa Link Driver Chức Năng Thành Công!"
        ]);
    }
}
