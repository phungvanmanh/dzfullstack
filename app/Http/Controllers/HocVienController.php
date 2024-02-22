<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\HocVienLopHoc\HocVienLopHocRequest;
use App\Http\Requests\HocVien\DonXinPhep\UpdateHocVienDanhGiaRequest;
use App\Http\Requests\HocVien\DonXinPhep\UpdateHocVienXinVangRequest;
use App\Http\Requests\HocVien\QuenMatKhaulRequest;
use App\Http\Requests\HocVien\QuenMatKhaumailRequest;
use App\Jobs\SendmailForgotPassJob;
use App\Mail\SendMailForgotPassword;
use App\Models\BuoiHoc;
use App\Models\HocPhi;
use App\Models\HocVien;
use App\Models\HocVienLopHoc;
use App\Models\LichHoc;
use App\Models\LopHoc;
use App\Models\NhanVien;
use Carbon\Carbon;
use Google\Service\CloudSourceRepositories\Repo;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yoeunes\Toastr\Facades\Toastr;
use Illuminate\Support\Str;

class HocVienController extends Controller
{
    public function infoHocVien(Request $request)
    {
        $user = auth('sanctum')->user();

        return response()->json([
            'user'  => $user
        ], 200);
    }

    public function index()
    {
        $lopDangKy = LopHoc::where('is_mo_dang_ky', 1)->get();
        $nhanVien = NhanVien::get();
        return view('admin.page.hoc_vien.hoc_vien_da_dang_ky',compact('lopDangKy','nhanVien'));
    }

    public function viewLoginHocVien()
    {
        return view('hocvien.login');
    }

    public function actionApiLoginhocVien(Request $request)
    {
        $data['email']      = $request->email;
        $data['password']   = $request->password;
        $check = Auth::guard('hocVien')->attempt($data);
        // dd($check);
        if ($check) {
            $user = Auth::guard('hocVien')->user();
            // $tokenResult = $user->createToken('authToken')->plainTextToken;
            // return response()->json([
            //     'status'    => true,
            //     'token'     => $tokenResult,
            //     'token_type' => 'Bearer',
            // ]);
        }
        return response()->json([
            'status'    => false,
        ]);
    }


    public function actionLoginhocVien(Request $request)
    {
        // dd($request->toArray());
        $data['email']      = $request->email;
        $data['password']   = $request->password;
        $check = Auth::guard('hocVien')->attempt($data);
        // dd($check);
        if ($check) {
            Toastr::success("Bạn đã đăng nhập thành công!");
            return redirect('/hocVien/don-xin-phep/index');
            // return redirect('/login');
        }
        Toastr::error("Email hoặc mật khẩu không chính xác");
        return redirect()->back();
    }

    public function viewThongTinCaNhanHocVien()
    {
        return view('hocvien.page.hoc_vien.profile_hoc_vien');
    }

    public function getLinkAVT($file, $name, $id)
    {
        $root_path = public_path();
        $file_extention = $file->getClientOriginalExtension();
        $file_name = Str::slug($name) .  Str::slug(Carbon::now()->toDateTimeString()) . '.' . $file_extention;
        $link = '/anh-dai-dien/' .  Str::slug($name) . '-' . $id . '/';

        $path = $root_path . '/' . $link;
        $file->move($path, $file_name);

        return $link . $file_name;
    }

    public function checkForder($name, $id)
    {
        $link = public_path() .  '/anh-dai-dien/' .  Str::slug($name) . '-' . $id . '/';
        if (is_dir($link)) {
            return $link;
        } else {
            return null;
        }
    }

    public function updateThongTinCaNhanHocVien(Request $request)
    {
        $data = $request->all();
        $hocVien = HocVien::find($data['id']);
        if ($data['anh_dai_dien'] != null) {
            $check = $this->checkForder($hocVien->ho_va_ten, $data['id']);
            if ($check) {
                $file = new Filesystem;
                $file->cleanDirectory($check);
            }

            $data['anh_dai_dien']  = $this->getLinkAVT($data['anh_dai_dien'], $data['ho_va_ten'], $data['id']);
        } else {
            $data['anh_dai_dien'] = $hocVien->anh_dai_dien;
        }
        DB::transaction(function () use ($data, $hocVien) {
            $hocVien->update($data);
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã cập nhật Profile thành công!',
        ]);
    }


    public function changePasswordHocVien(Request $request)
    {
        $data = $request->all();
        DB::transaction(function () use ($data) {
            $hocVien = HocVien::find($data['id']);
            $hocVien->password = bcrypt($data['password']);
            $hocVien->save();
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã cập nhật mật khẩu thành công!',
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->all();
        $data = HocVien::where(function ($query) use ($search) {
                            $query->where('hoc_viens.ho_va_ten', 'like', '%' . $search['search'] . '%')
                                ->orWhere('hoc_viens.email', 'like', '%' . $search['search'] . '%')
                                ->orWhere('hoc_viens.so_dien_thoai', 'like', '%' . $search['search'] . '%')
                                ->orWhere('hoc_viens.nguoi_gioi_thieu', 'like', '%' . $search['search'] . '%');
                        })
                        ->select(
                            'hoc_viens.*',
                        )
                        ->paginate(15);
        // Mid Viết
        foreach ($data as $key => $value) {
            $array_id_lop = explode(',' , $value->id_lop_dang_ky);

            $lop_khoa = LopHoc::whereIn('lop_hocs.id', $array_id_lop)
                                ->join('khoa_hocs', 'khoa_hocs.id', 'lop_hocs.id_khoa_hoc')
                                ->select(
                                    DB::raw('group_concat(DISTINCT lop_hocs.ten_lop_hoc) AS list_lop'),
                                    DB::raw('group_concat(DISTINCT khoa_hocs.ten_khoa_hoc) AS list_khoa'),
                                )
                                ->first();

            $value->list_khoa = $lop_khoa->list_khoa;
            $value->list_lop = $lop_khoa->list_lop;
            $value->ip_dang_ki = explode(',', $value->ip_dang_ki);
        }
        // Mid Viết
        $nhanVien = NhanVien::all();
        $response = [
            'pagination' => [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'from' => $data->firstItem(),
                'to' => $data->lastItem()
            ],
            'data' => $data,
            'data_nhanvien' => $nhanVien
        ];

        return response()->json([
            'data'           => $response,
        ]);
    }

    public function getData()
    {
        $data = HocVien::orderBy('hoc_viens.ten')
                        ->select(
                            'hoc_viens.*',
                        )
                        ->paginate(15);

        // Mid Viết
        foreach ($data as $key => $value) {
            $array_id_lop = explode(',' , $value->id_lop_dang_ky);

            $lop_khoa = LopHoc::whereIn('lop_hocs.id', $array_id_lop)
                                ->join('khoa_hocs', 'khoa_hocs.id', 'lop_hocs.id_khoa_hoc')
                                ->select(
                                    DB::raw('group_concat(DISTINCT lop_hocs.ten_lop_hoc) AS list_lop'),
                                    DB::raw('group_concat(DISTINCT khoa_hocs.ten_khoa_hoc) AS list_khoa'),
                                )
                                ->first();

            $value->list_khoa = $lop_khoa->list_khoa;
            $value->list_lop = $lop_khoa->list_lop;
            $value->ip_dang_ki = explode(',', $value->ip_dang_ki);
        }
        // Mid Viết

        $nhanVien = NhanVien::all();
        $response = [
            'pagination' => [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'from' => $data->firstItem(),
                'to' => $data->lastItem()
            ],
            'data' => $data,
            'data_nhanvien' => $nhanVien,
        ];
        return response()->json([
            'data'           => $response,
        ]);
    }

    public function update(Request $request)
    {
        $hocvien = HocVien::where('id', $request->id)->first();

        if ($hocvien) {
            $hocvien->ho_va_ten         = $request->ho_va_ten;
            $hocvien->ten               = $request->ten;
            $hocvien->email             = $request->email;
            $hocvien->name_zalo         = $request->name_zalo;
            $hocvien->facebook          = $request->facebook;
            $hocvien->so_dien_thoai     = $request->so_dien_thoai;
            $hocvien->nguoi_gioi_thieu  = $request->nguoi_gioi_thieu;
            $hocvien->id_lop_dang_ky    = $request->id_lop_dang_ky;
            $hocvien->id                = $request->id;
            $hocvien->update();
        }

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã cập nhật học viên thành công!',
        ]);
    }

    public function destroy(Request $request)
    {
        $data = $request->all();

        DB::transaction(function () use ($data) {
            HocVien::find($data['id'])->delete();
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã xoá học viên thành công!',
        ]);
    }

    public function thongTinHocVienTheoId($id)
    {
        $data = HocVien::find($id);

        return response()->json([
            'data'  => $data
        ]);
    }

    public function showInfoByUUID($uuid)
    {
        $hocVien = HocVien::where('uuid', $uuid)->first();
        if ($hocVien) {
            return view('admin.page.vcard.index', compact('hocVien'));
        } else {
            return redirect('/');
        }
    }

    public function addToClass(HocVienLopHocRequest $request)
    {
        $data = $request->all();
        $hocVien = HocVien::find($data['id_hoc_vien']);
        $hocVien->is_hoc_vien = 1;
        $hocVien->save();

        // //nếu như học viên có mà bị xóa ra lúc add lại thì ta xóa trước
        // $hocVienLopHoc = HocVienLopHoc::where('id_hoc_vien', $data['id_hoc_vien'])->first();
        // $hocVienLopHoc->delete();


        $value['id_hoc_vien'] = $data['id_hoc_vien'];
        $value['id_lop_hoc'] = $data['id_lop_hoc'];
        $value['is_hoc_vien'] = 1;
        $hoc_vien_da_vao_lop = HocVienLopHoc::where('id_hoc_vien', $data['id_hoc_vien'])
                                            ->where('id_lop_hoc', $data['id_lop_hoc'])
                                            ->first();
        // dd($hoc_vien_da_vao_lop);
        if ($hoc_vien_da_vao_lop) {
            return response()->json([
                'status'    =>  false,
                'message'   => 'Học viên đã tồn tại !',
            ]);
        } else {
            HocVienLopHoc::create($value);
            $array_id_lop = explode(',' , $hocVien->id_lop_dang_ky);

            $lop_dang_hoc = HocVienLopHoc::where('id_hoc_vien', $hocVien->id)
                                         ->whereIn('id_lop_hoc', $array_id_lop)
                                         ->count();

            if($lop_dang_hoc == count($array_id_lop)) {
                $hocVien->is_cho_lop = 0;
                $hocVien->save();
            }

            return response()->json([
                'status'    =>  true,
                'message'   => 'Đã thêm học viên vào lớp thành công!',
            ]);
        }
    }

    public function logout()
    {
        Auth::guard('hocVien')->logout();
        Toastr::success("Bạn đã đăng xuất thành công!");
        return redirect('/login');
    }

    public function viewDonXinPhep()
    {
        return view('hocvien.page.don_xin_phep.index');
    }

    public function getLopDangHoc()
    {
        $hocVien =  Auth::guard('hocVien')->user();

        $lopDangHoc = HocVienLopHoc::where('id_hoc_vien', $hocVien->id)
                                   ->where('is_hoc_vien', 1)
                                   ->join('lop_hocs', 'hoc_vien_lop_hocs.id_lop_hoc', 'lop_hocs.id')
                                   ->select('lop_hocs.*')
                                   ->where('lop_hocs.is_done', 0)
                                   ->get();
        return response()->json([
            'data'  => $lopDangHoc
        ]);
    }

    public function getBuoiHoc($id)
    {
        $now = Carbon::now();
        $danhSachBuoiHoc = BuoiHoc::where('id_lop_hoc', $id)
                                  ->leftjoin('lich_hocs', 'buoi_hocs.id', 'lich_hocs.id_buoi_hoc')
                                  ->select('buoi_hocs.*', 'lich_hocs.tinh_trang', 'lich_hocs.ly_do_vang','lich_hocs.noi_dung_danh_gia','lich_hocs.hoc_vien_danh_gia_buoi_hoc')
                                  ->where('buoi_hocs.gio_bat_dau', '>=' , $now)
                                  ->orderBy('buoi_hocs.thu_tu_buoi_khoa_hoc')
                                  ->get();
        return response()->json([
            'data'  => $danhSachBuoiHoc
        ]);
    }

    public function getLinkAnhMinhChung($file, $name, $id)
    {
        $root_path = public_path();
        $file_extention = $file->getClientOriginalExtension();
        $file_name = Str::slug($name) .  Str::slug(Carbon::now()->toDateTimeString()) . '.' . $file_extention;
        $link = '/anh-minh-chung/' .  Str::slug($name) . '-' . $id . '/';
        // dd($link);
        $path = $root_path . '/' . $link;
        $file->move($path, $file_name);
        return $link . $file_name;
    }


    public function updateLyDoVang(UpdateHocVienXinVangRequest $request)
    {
        $data      = $request->all();
        $idhocVien =  Auth::guard('hocVien')->user();
        $check     = LichHoc::where('id_buoi_hoc', $data['id'])->where('id_hoc_vien', $idhocVien->id)->first();

        if($data['anh_minh_chung'] == "undefined") {
            if($check) {
                $check->ly_do_vang = $data['ly_do_vang'];
                $check->anh_minh_chung = null;
                $check->tinh_trang = 2;
                $check->save();
            } else {
                LichHoc::create([
                    'id_buoi_hoc'       => $data['id'],
                    'id_hoc_vien'       => $idhocVien->id,
                    'tinh_trang'        => 2,
                    'ly_do_vang'        => $data['ly_do_vang'],
                    'anh_minh_chung'    => null,
                ]);
            };
        } else {
            $data['anh_minh_chung']  = $this->getLinkAnhMinhChung($data['anh_minh_chung'], $idhocVien->ho_va_ten, $idhocVien->id);

            if($check) {
                $check->ly_do_vang = $data['ly_do_vang'];
                $check->anh_minh_chung = $data['anh_minh_chung'];
                $check->tinh_trang = 2;
                $check->save();
            } else {
                LichHoc::create([
                    'id_buoi_hoc'       => $data['id'],
                    'id_hoc_vien'       => $idhocVien->id,
                    'tinh_trang'        => 2,
                    'ly_do_vang'        => $data['ly_do_vang'],
                    'anh_minh_chung'    => $data['anh_minh_chung'],
                ]);
            };
        }

        return response()->json([
            'status'    =>  1,
            'message'   =>  'Đã gửi lý do vắng buổi học thành công!',
        ]);
    }

    public function updateHocVienDanhGia(UpdateHocVienDanhGiaRequest $request)
    {
        // dd($request->toArray());
        $data = $request->all();
        $idhocVien =  Auth::guard('hocVien')->user()->id;
        $check = LichHoc::where('id_buoi_hoc', $data['id'])->where('id_hoc_vien', $idhocVien)->first();

        if($check) {
            $check->hoc_vien_danh_gia_buoi_hoc  = $data['hoc_vien_danh_gia_buoi_hoc'];
            $check->noi_dung_danh_gia           = $data['noi_dung_danh_gia'];
            $check->save();

            return response()->json([
                'status'    =>  1,
                'message'   =>  'Đã đánh giá buổi học thành công!',
            ]);
        } else {
            return response()->json([
                'status'    =>  0,
                'message'   =>  'Buổi học chưa mở nên chưa thể đánh giá!',
            ]);
        }


    }
    //Queen mật Khẩu
    public function viewQuenMatKhau()
    {
        return view('hocvien.page.hoc_vien.quen_mat_khau');
    }

    public function actioQuenMatKhau(QuenMatKhaumailRequest $request)
    {
        $data = $request->all();
        $hocVien =  HocVien::where('email', $data['email'])->first();
        $data['full_name']= $hocVien->ho_va_ten;
        $data['hash']= $hocVien->uuid;

        SendmailForgotPassJob::dispatch($data, $data['email']);

        Toastr::success("Đã gửi thông tin, vui lòng kiểm tra email!");

        return redirect('/login');
    }
    public function viewResetPassword($hash)
    {
        return view('hocvien.page.hoc_vien.reset_password', compact('hash'));

    }
    public function actioResetPassword(Request $request)
    {
        $hocVien = HocVien::where('uuid', $request->hash)->first();
        if($hocVien){
            $hocVien->password = bcrypt($request->password);
            $hocVien->save();
            Toastr::success('Đã thay đổi mật khẩu thành công!');
            return redirect('/login');
        }else{
            Toastr::error('Đã có lỗi hệ thống!');
            return redirect('/login');
        }
    }
    public function store(Request $request)
    {
        $data = $request->all();

        DB::transaction(function () use ($data){
            HocVien::create($data);
        });
        return response()->json([
            'status' => 1,
            'message'   => 'Thêm học viên thành công',
        ]);

    }
    // BEGIN MID VIET
    public function layThongTinLopDangKi(Request $request)
    {
        $array_lop_dang_ki = explode(',', $request->list_lop);
        $danhSachLop = LopHoc::whereIn('lop_hocs.id', $array_lop_dang_ki)
                             ->where('is_done', 0)
                             ->join('khoa_hocs', 'khoa_hocs.id', 'lop_hocs.id_khoa_hoc')
                             ->select('lop_hocs.*', 'khoa_hocs.ten_khoa_hoc')
                             ->get();

        foreach ($danhSachLop as $value) {
            $check_hoc_vien_da_add =  HocVienLopHoc::where('id_hoc_vien', $request->id_hoc_vien)
                                                   ->where('id_lop_hoc', $value->id)
                                                   ->first();

            if($check_hoc_vien_da_add) {
                $value->check_add = false;
            } else {
                $value->check_add =  true;
                $value->id_hoc_vien = $request->id_hoc_vien;
            }
        }

        return response()->json([
            'data' => $danhSachLop
        ]);
    }
    // END MID VIET

}
