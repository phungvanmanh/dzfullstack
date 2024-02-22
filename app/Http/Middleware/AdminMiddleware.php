<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yoeunes\Toastr\Facades\Toastr;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $check = Auth::guard('nhanVien')->check();
        if($check) {
            return $next($request);
        }
        Toastr::error('Bạn cần đăng nhập hệ thống trước!');

        return redirect('/admin/login');
    }
}
