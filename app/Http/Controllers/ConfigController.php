<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserMBRequest;
use App\Http\Requests\DetailUserMBRequest;
use App\Http\Requests\UpdateUserMBRequest;
use App\Models\Config;
use App\Models\UserMB;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index()
    {
        $config     = Config::orderByDESC('id')->first();

        return response()->json([
            'config'    =>  $config
        ]);
    }

    public function indexUserMB()
    {
        return view('mb.index');
    }

    public function store(CreateUserMBRequest $request)
    {
        $data = $request->all();

        UserMB::create($data);

        return response()->json([
            'status'    => true,
            'message'   => 'Thêm mới UserMB thành công!'
        ]);
    }

    public function update(UpdateUserMBRequest $request)
    {
        $data = $request->all();
        $user = UserMB::find($data['id']);
        $user->update($data);

        return response()->json([
            'status'    => true,
            'message'   => 'Cập Nhật UserMB thành công!'
        ]);
    }

    public function status(DetailUserMBRequest $request)
    {
        $data = $request->all();
        $user = UserMB::find($data['id']);
        $user->is_active = !$user->is_active;
        $user->save();
        return response()->json([
            'status'    => true,
            'message'   => 'Cập Nhật trạng thái UserMB thành công!'
        ]);
    }

    public function destroy(DetailUserMBRequest $request)
    {
        $data = $request->all();
        $user = UserMB::find($data['id']);
        $user->delete();
        return response()->json([
            'status'    => true,
            'message'   => 'Xóa UserMB thành công!'
        ]);
    }

    public function data(Request $request)
    {
        $data = UserMB::get();

        return response()->json([
            'data'  => $data
        ]);
    }


    public function checkUserMB(Request $request)
    {
        $user = UserMB::where('user_mb', $request->username)->first();

        if($user) {
            if($user->is_active == 1) {
                return response()->json([
                    'status' => true,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tài khoản của bạn chưa được cấp quyền sử dụng, Vui lòng liên hệ Admin để được cung cấp quyền sử dụng!'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Tài khoản của bạn chưa có đăng kí trên hệ phần mềm, Vui lòng liên hệ Admin để đăng kí sử dụng!'
            ]);
        }
    }
}
