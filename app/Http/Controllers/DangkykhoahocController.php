<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\DangKyKhoaHoc\DangkyKhoaHocRequest;
use App\Jobs\DangKyKhoaHoc;
use App\Models\HocVien;
use App\Models\KhoaHoc;
use App\Models\LopHoc;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yoeunes\Toastr\Facades\Toastr;
use Illuminate\Support\Str;
use Ramsey\Uuid\Builder\FallbackBuilder;

class DangkykhoahocController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $lopDangKy = LopHoc::where('is_mo_dang_ky', 1)
                            ->where('is_done', '!=', 1)
                            ->get();
        return view('admin.page.hoc_vien.dang_ki_khoa_hoc', compact('lopDangKy'));
    }

    public function getData()
    {
        $data = HocVien::all();

        return response()->json([
            'data'  => $data,
        ]);
    }

    public function split_name($name) {
        $parts = explode(" ", $name);
        if(count($parts) > 1) {
            $lastname = array_pop($parts);
            $firstname = implode(" ", $parts);
        }
        else
        {
            $firstname = $name;
            $lastname = " ";
        }

        return array($firstname, $lastname);
    }

    public function RegisAction(DangkyKhoaHocRequest $request)
    {

        $student = HocVien::where('email',$request->email)->first();

        if($student){
            $ArrayLopDangKy =explode(',',$student->id_lop_dang_ky);
            $checkLopDangKy = in_array($request->id_lop_dang_ky, $ArrayLopDangKy );
            if($checkLopDangKy){
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Bạn đã ký khóa học này, vui lòng kiểm tra email!',
                ]);
            } else {
                $student->id_lop_dang_ky = $student->id_lop_dang_ky.','.$request->id_lop_dang_ky;
                $student->ip_dang_ki = $student->ip_dang_ki . ',' . $request->ip();
                $student->save();

                $khoaHoc = LopHoc::find($request->id_lop_dang_ky);
                $dataMail['email']      = $request->email;
                $dataMail['ho_va_ten']  = $request->ho_va_ten;
                $dataMail['ten_lop_hoc']   = $khoaHoc->ten_lop_hoc;
                DangKyKhoaHoc::dispatch($dataMail);
                return response()->json([
                    'status'    => 1,
                    'message'   => 'Bạn đã đăng ký khóa học thành công!!',
                ]);
            }

        }else{
            $data = $request->all();
            // dd($data);
            $array_name = $this->split_name($data['ho_va_ten']);
            $data['ho_lot']      = $array_name[0];
            $data['ten']         = $array_name[1];
            $data['uuid']        = Str::uuid();
            $data['password']    = bcrypt(123456);
            $data['ip_dang_ki']  = $request->ip();
            DB::transaction(function () use ($data){
                HocVien::create($data);
            });
            $khoaHoc = LopHoc::find($request->id_lop_dang_ky);
            $dataMail['email']      = $request->email;
            $dataMail['ho_va_ten']= $request->ho_va_ten;
            $dataMail['ten_lop_hoc']= $khoaHoc->ten_lop_hoc;
            DangKyKhoaHoc::dispatch($dataMail);


            return response()->json([
                'status' => 1,
                'message'   => 'Bạn đã đăng ký khóa học thành công!!',
            ]);
        }
    }
}
