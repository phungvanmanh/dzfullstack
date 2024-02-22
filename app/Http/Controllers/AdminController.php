<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\LoginRequest;
use App\Models\NhanVien;
use Google\Service\MyBusinessAccountManagement\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yoeunes\Toastr\Facades\Toastr;

class AdminController extends Controller
{

    public function test()
    {
        return view('admin.page.test');
    }

    public function viewLogin()
    {
        $check_dn = Auth::guard('nhanVien')->check();
        if($check_dn){
            return redirect('/admin/lich-lam-viec/dang-ky');
        }
        return view('admin.login');
    }

    public function actionLogin(Request $request)
    {

        $data['email']      = $request->email;
        $data['password']   = $request->password;
        $check = Auth::guard('nhanVien')->attempt($data);
        if($check) {
            $nhan_vien = NhanVien::where('email', $request->email)
                           ->where('is_open', 1)
                           ->first();
            if($nhan_vien) {
                Toastr::success("Bạn đã đăng nhập thành công!");
                return redirect('/admin/lich-lam-viec/dang-ky');
            } else {
                Toastr::error("Tài khoản đã bị khóa");
                Auth::guard('nhanVien')->logout();
                return redirect()->back();
            }
        } else {
            Toastr::error("Email hoặc mật khẩu không chính xác");
            return redirect()->back();
        }

    }

    // VUE BEGIN
    public function actionLoginVue(LoginRequest $request)
    {

        $data['email']      = $request->email;
        $data['password']   = $request->password;
        $check = Auth::guard('nhanVien')->attempt($data);
        if($check) {
            $user = Auth::guard('nhanVien')->user();
            // $user = $request->user();
            $token = $user->createToken('MyApp')->plainTextToken;

            return response()->json([
                'status'  => 1,
                'message' => "Đăng Nhập Thành Công!",
                'token'   => $token
            ]);
        }
        return response()->json([
            'status'  => 0,
            'message' => "Email hoặc mật khẩu không chính xác!"
        ]);
    }

    public function checkLoginVue(Request $request)
    {
        $user = auth('sanctum')->user();

        return response()->json([
            'user'  => $user
        ], 200);
    }

    // VUE END

    public function logout()
    {
        Auth::guard('nhanVien')->logout();
        Toastr::success("Bạn đã đăng xuất thành công!");
        return redirect('/admin/login');
    }

    public function logoutVue()
    {
        Auth::guard('nhanVien')->logout();
        return response()->json([
            'status'    => 1,
            'message'   => "Đã đăng xuất thành công!"
        ]);
    }
}
