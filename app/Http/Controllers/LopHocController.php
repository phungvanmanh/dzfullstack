<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\BuoiHoc\DoiBuoiHocRequest;
use App\Http\Requests\Admin\LopHoc\CreateLopHocRequest;
use App\Http\Requests\Admin\LopHoc\DeleteLopHocRequest;
use App\Http\Requests\Admin\LopHoc\UpdateLopHocRequest;
use App\Http\Requests\StatusLopHocRequest;
use App\Models\BuoiHoc;
use App\Models\HocVien;
use App\Models\HocVienLopHoc;
use App\Models\KhoaHoc;
use App\Models\LichHoc;
use App\Models\LopHoc;
use Carbon\Carbon;
use Exception;
use Google\Service\CloudSearch\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LopHocController extends Controller
{

    public function index()
    {
        return view('admin.page.lop_hoc.index');
    }

    public function checkBuoiTrung($data)
    {
        $data['gio_bat_dau']  = Carbon::parse($data['gio_bat_dau']);
        $data['gio_ket_thuc'] = Carbon::parse($data['gio_ket_thuc']);
        $buoi_hoc = BuoiHoc::whereDate('gio_bat_dau', $data['gio_bat_dau'])
                            ->where(function($query) use($data) {
                                $query->where(function($query_1) use($data) {
                                    $query_1->whereTime('gio_bat_dau', "<=", $data['gio_bat_dau'])
                                            ->whereTime('gio_ket_thuc', ">=", $data['gio_bat_dau']);
                                })->orWhere(function($query_1) use($data) {
                                    $query_1->whereTime('gio_bat_dau', "<=", $data['gio_ket_thuc'])
                                            ->whereTime('gio_ket_thuc', ">=", $data['gio_ket_thuc']);
                                })->orWhere(function($query_1) use($data) {
                                    $query_1->whereTime('gio_bat_dau', ">=", $data['gio_bat_dau'])
                                            ->whereTime('gio_ket_thuc', "<=", $data['gio_ket_thuc']);
                                });
                            })
                            ->first();
        if($buoi_hoc) {
            return false;
        }
        return true;
    }
    // Mid Viết
    public function store_v2(CreateLopHocRequest $request)
    {
        $data = $request->all();
        $slug_lop   = Str::slug($data['ten_lop_hoc']);
            $list_lop   = LopHoc::where('id_khoa_hoc', $data['id_khoa_hoc'])->select('ten_lop_hoc')->get();
            foreach ($list_lop as $value) {
                if($slug_lop === Str::slug($value->ten_lop_hoc)) {
                    return response()->json([
                        'status'    => 0,
                        'message'   => 'Tên lớp đã tồn tại!',
                    ]);
                }
        }
        try {
            DB::transaction(function () use ($data) {
                // 1: Thứ 2, 2: Thứ 3, .... , 6: Thứ 7, 0: Chủ Nhật
                // Tìm khóa
                $khoa_hoc   = KhoaHoc::find($data['id_khoa_hoc']);

                $array_thu  = explode(',', $data['thu_trong_tuan']);
                $tong_buoi_hoc = $khoa_hoc->so_thang_hoc * $khoa_hoc->so_buoi_trong_thang;
                $dem_ngay   = 1;
                $data['so_thang_hoc'] = $khoa_hoc->so_thang_hoc;
                $lopHoc     = LopHoc::create($data);
                $ngay_hoc   = Carbon::parse($data['ngay_bat_dau_hoc']);

                while($dem_ngay <= $tong_buoi_hoc) {
                    $check_ngay = $ngay_hoc->dayOfWeek + 1 ;
                    if(in_array($check_ngay, $array_thu)) {
                        $ngay_gio_bat_dau  = $ngay_hoc->format("Y-m-d") . " " . $data['gio_bat_dau'];
                        $ngay_gio_ket_thuc = $ngay_hoc->format("Y-m-d") . " " . $data['gio_ket_thuc'];
                        $data_buoi         = [
                            'id_lop_hoc'                => $lopHoc->id,
                            'thu_tu_buoi_khoa_hoc'      => $dem_ngay,
                            'gio_bat_dau'               => Carbon::parse($ngay_gio_bat_dau)->toDateTimeString(),
                            'gio_ket_thuc'              => Carbon::parse($ngay_gio_ket_thuc)->toDateTimeString(),
                            'id_nhan_vien_day'          => $lopHoc->id_nhan_vien_day,
                        ];
                        if($this->checkBuoiTrung($data_buoi) == false) {
                            $mess = "Buổi học ngày " . $ngay_hoc->format("d/m/Y") . " vào lúc " . $data['gio_bat_dau'] . " đã có lớp học!";
                            throw new Exception($mess);
                        }
                        BuoiHoc::create($data_buoi);
                        $dem_ngay = $dem_ngay + 1;
                    }
                    $ngay_hoc =  $ngay_hoc->addDay();
                }
            });

            return response()->json([
                'status'    => 1,
                'message'   => 'Đã thêm mới khoá học thành công!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'     => 0,
                'message'    => $e->getMessage(),
            ]);
        }
    }

    public function store(CreateLopHocRequest $request)
    {
        $data = $request->all();
        $dataKhoaHoc = KhoaHoc::where('id', $request->id_khoa_hoc)->first();
        $data['so_buoi_trong_thang']    = $dataKhoaHoc->so_buoi_trong_thang;
        $data['hoc_phi_theo_thang']     = $dataKhoaHoc->hoc_phi_theo_thang;
        $data['so_thang_hoc']           = $dataKhoaHoc->so_thang_hoc;
        // DB::transaction(function () use ($data){

        //Tính số buổi học 1 tuần
        $cac_thu_trong_tuan = explode(',', $data['thu_trong_tuan']);
        $so_buoi_trong_tuan = count($cac_thu_trong_tuan);

        // Tính tổng số tuần học
        $khoaHoc = KhoaHoc::find($request->id_khoa_hoc);
        $so_buoi_khoa = $khoaHoc->so_buoi_trong_thang * $khoaHoc->so_thang_hoc;
        $so_tuan_hoc = $so_buoi_khoa / $so_buoi_trong_tuan;

        //Ngày bắt đầu học là thứ mấy
        $thu_cua_ngay_bd = date('N', strtotime($data['ngay_bat_dau_hoc'])) + 1;
        if(!in_array($thu_cua_ngay_bd, $cac_thu_trong_tuan)){
            return response()->json([
                'status'    => 0,
                'message'   => 'Ngày bắt đầu không trùng với thứ trong tuần!',
            ]);
        }

        $lopHoc = LopHoc::create($data);

        //Tính ngày bắt đầu theo các thứ của lớp học.
        $dem = 1;
        $list_ngay = [$data['ngay_bat_dau_hoc']];
        $ngay_hoc = Carbon::parse($data['ngay_bat_dau_hoc']);
        while ($dem < $so_buoi_trong_tuan) {
            $ngay_hoc->addDay();
            $thu_cua_ngay_hoc = date('N', strtotime($ngay_hoc)) + 1;

            if(in_array($thu_cua_ngay_hoc, $cac_thu_trong_tuan)){
                array_push($list_ngay, $ngay_hoc->format('Y-m-d'));
                $dem++;
            }
        }

        //Thêm mới tất cả các ngày theo ngày bắt đầu và theo thứ trong tuần
        $dem = 1;
        for ($i = 0; $i < $so_buoi_trong_tuan; $i++) {
            $ngay_hoc = $list_ngay[$i];
            $dem = $i + 1;
            for ($j=1; $j <= $so_tuan_hoc ; $j++) {
                $gio_bat_dau = $ngay_hoc . ' ' . $request->gio_bat_dau.':00';
                $gio_ket_thuc = $ngay_hoc . ' ' . $request->gio_ket_thuc.':00';
                // dd($gio_bat_dau, $gio_ket_thuc);
                $data['id_lop_hoc'] = $lopHoc->id;
                $data['thu_tu_buoi_khoa_hoc'] = $dem;
                $data['gio_bat_dau'] = Carbon::parse($gio_bat_dau)->format('Y-m-d H:i:s');
                $data['gio_ket_thuc'] = Carbon::parse($gio_ket_thuc)->format('Y-m-d H:i:s');
                $data['id_nhan_vien_day'] = $lopHoc->id_nhan_vien_day;
                BuoiHoc::create($data);

                $ngay_hoc = Carbon::parse($ngay_hoc)->addDays(7)->format('Y-m-d');
                $dem = $dem + $so_buoi_trong_tuan;
            }
        }

        // });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã thêm mới khoá học thành công!',
        ]);
    }

    public function update(UpdateLopHocRequest $request)
    {
        $data = $request->all();
        // DB::transaction(function () use ($data){
        LopHoc::find($data['id'])->update($data);
        $check  = BuoiHoc::where('id_lop_hoc',$data['id'])->first();
        if ($check) {
            BuoiHoc::where('id_lop_hoc',$data['id'])->delete();
        }

        //Tính số buổi học 1 tuần
        $cac_thu_trong_tuan = explode(',', $data['thu_trong_tuan']);
        $so_buoi_trong_tuan = count($cac_thu_trong_tuan);

        // Tính tổng số tuần học
        $khoaHoc = KhoaHoc::find($data['id_khoa_hoc']);
        $so_buoi_khoa = $khoaHoc->so_buoi_trong_thang * $khoaHoc->so_thang_hoc;
        $so_tuan_hoc = $so_buoi_khoa / $so_buoi_trong_tuan;

        //Ngày bắt đầu học là thứ mấy
        $thu_cua_ngay_bd = date('N', strtotime($data['ngay_bat_dau_hoc'])) + 1;
        if(!in_array($thu_cua_ngay_bd, $cac_thu_trong_tuan)){
            return response()->json([
                'status'    => 0,
                'message'   => 'Ngày bắt đầu không trùng với thứ trong tuần!',
            ]);
        }

        //Tính ngày bắt đầu theo các thứ của lớp học.
        $dem = 1;
        $list_ngay = [$data['ngay_bat_dau_hoc']];
        $ngay_hoc = Carbon::parse($data['ngay_bat_dau_hoc']);
        // dd($list_ngay);
        while ($dem < $so_buoi_trong_tuan) {
            $ngay_hoc->addDay();
            $thu_cua_ngay_hoc = date('N', strtotime($ngay_hoc)) + 1;

            if(in_array($thu_cua_ngay_hoc, $cac_thu_trong_tuan)){
                array_push($list_ngay, $ngay_hoc->format('Y-m-d'));
                $dem++;
            }
        }

        //Thêm mới tất cả các ngày theo ngày bắt đầu và theo thứ trong tuần
        $dem = 1;
        for ($i = 0; $i < $so_buoi_trong_tuan; $i++) {
            $ngay_hoc = $list_ngay[$i];
            $dem = $i + 1;
            for ($j=1; $j <= $so_tuan_hoc ; $j++) {
                $gio_bat_dau = $ngay_hoc . ' ' . $request->gio_bat_dau;
                $gio_ket_thuc = $ngay_hoc . ' ' . $request->gio_ket_thuc;

                $data1['id_lop_hoc'] = $data['id'];
                $data1['thu_tu_buoi_khoa_hoc'] = $dem;
                $data1['gio_bat_dau'] = Carbon::parse($gio_bat_dau)->format('Y-m-d H:i:s');
                $data1['gio_ket_thuc'] = Carbon::parse($gio_ket_thuc)->format('Y-m-d H:i:s');
                $data1['id_nhan_vien_day'] = $data['id_nhan_vien_day'];
                BuoiHoc::create($data1);

                $ngay_hoc = Carbon::parse($ngay_hoc)->addDays(7)->format('Y-m-d');
                $dem = $dem + $so_buoi_trong_tuan;
            }
        }

        // });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã cập nhật thành công!',
        ]);

    }

    public function getData()
    {
        $data = LopHoc::join('khoa_hocs', 'lop_hocs.id_khoa_hoc', 'khoa_hocs.id')
                        ->join('nhan_viens', 'lop_hocs.id_nhan_vien_day', 'nhan_viens.id')
                        ->where('lop_hocs.is_done', 0)
                        ->select('lop_hocs.*','nhan_viens.ho_va_ten as ten_giao_vien', 'khoa_hocs.ten_khoa_hoc')
                        ->get();
        foreach ($data as $key => $value) {
            $lastDay = BuoiHoc::where('id_lop_hoc' , $value->id)
                              ->orderByDESC('gio_ket_thuc')
                              ->first();

            if($lastDay) {
                $value->gio_bat_dau  =  Carbon::parse($lastDay['gio_bat_dau'])->format('H:i:s');
                $value->gio_ket_thuc =  Carbon::parse($lastDay['gio_ket_thuc'])->format('H:i:s');
                if(Carbon::parse($lastDay->gio_ket_thuc) <= Carbon::now()) {
                    $value->check_end = true;
                } else {
                    $value->check_end = false;
                }
            }

        }
        return response()->json([
            'data'  => $data,
        ]);
    }

    public function getDataTheoLop($id_lop_hoc)
    {
        $data = LopHoc::where('id', $id_lop_hoc)
                        ->select('lop_hocs.id', 'lop_hocs.so_thang_hoc')
                        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    public function destroy(DeleteLopHocRequest $request)
    {
        $data = $request->all();

        DB::transaction(function () use ($data){
            LopHoc::find($data['id'])->delete();
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã xoá khoá học thành công!',
        ]);
    }

    public function status(StatusLopHocRequest $request)
    {
        $data = $request->all();

        DB::transaction(function () use ($data){
            $check = LopHoc::find($data['id']);
            if($check) {
                $check->is_mo_dang_ky = !$check->is_mo_dang_ky;
                $check->save();
            }
            if($check) {
                $check->is_done = !$check->is_done;
                $check->save();
            }
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã đổi trạng thái lớp học thành công!',
        ]);
    }
    public function statusDone(Request $request)
    {
        $data = $request->all();

        DB::transaction(function () use ($data){
            $buoiHoc = BuoiHoc::oderByDESC('gio_ket_thuc')->first();
            $check = LopHoc::find($data['id']);
            if($check) {
                $check->is_done = !$check->is_done;
                $check->save();
            }
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã đổi trạng thái lớp học thành công!',
        ]);
    }

    public function viewLopDangDay()
    {
        return view('admin.page.lop_hoc.lop_dang_day');
    }

    public function viewLopKetThuc()
    {
        return view('admin.page.lop_hoc.lop_ket_thuc');
    }

    public function dataDanhSachLop()
    {
        $danhSachLop = LopHoc::get();
        // dd($danhSachLop->toArray());
        return response()->json([
            'danhSachLop'   =>  $danhSachLop,
        ]);
    }

    public function dataDanhSachHocVienLop($id_lop_hoc)
    {
        $data = HocVienLopHoc::where('id_lop_hoc', $id_lop_hoc)
                             ->join('hoc_viens', 'hoc_vien_lop_hocs.id_hoc_vien', 'hoc_viens.id')
                             ->join('lop_hocs', 'hoc_vien_lop_hocs.id_lop_hoc', 'lop_hocs.id')
                             ->join('khoa_hocs', 'lop_hocs.id_khoa_hoc', 'khoa_hocs.id')
                             ->where('hoc_vien_lop_hocs.is_hoc_vien', 1)
                             ->orderBy('hoc_viens.ten')
                             ->select('hoc_vien_lop_hocs.id', 'hoc_vien_lop_hocs.is_add_fb', 'hoc_vien_lop_hocs.is_add_zalo','hoc_vien_lop_hocs.is_hoc_vien',
                                      'hoc_viens.ho_va_ten', 'hoc_viens.email', 'hoc_viens.name_zalo', 'hoc_viens.so_dien_thoai','hoc_viens.facebook','hoc_viens.danh_sach_teamview',
                                      'khoa_hocs.ten_khoa_hoc','hoc_viens.id as id_hoc_vien','lop_hocs.ten_lop_hoc','hoc_viens.name_zalo'
                            )
                            ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    public function changeStatusAddFB($id)
    {
        $hocVien = HocVienLopHoc::where('id', $id)->first();
        $nhanVien =  Auth::guard('nhanVien')->user();

        if($hocVien) {
            $hocVien->is_add_fb = !$hocVien->is_add_fb;
            $hocVien->id_nhan_vien_add_facebook = $nhanVien->id;
            $hocVien->save();

            return response()->json([
                'status' => true,
                'message'=> 'Đã add Facebook thái thành công!'
            ]);
        }
    }

    public function changeStatusAddFBVue($id)
    {
        $hocVien = HocVienLopHoc::where('id', $id)->first();
        $nhanVien =  auth('sanctum')->user();

        if($hocVien) {
            $hocVien->is_add_fb = !$hocVien->is_add_fb;
            $hocVien->id_nhan_vien_add_facebook = $nhanVien->id;
            $hocVien->save();

            return response()->json([
                'status' => true,
                'message'=> 'Đã add Facebook thái thành công!'
            ]);
        }
    }

    public function changeStatusAddZalo($id)
    {
        $hocVien = HocVienLopHoc::where('id', $id)->first();
        $nhanVien = Auth::guard('nhanVien')->user();

        if($hocVien) {
            $hocVien->is_add_zalo = !$hocVien->is_add_zalo;
            $hocVien->id_nhan_vien_add_zalo = $nhanVien->id;
            $hocVien->save();

            return response()->json([
                'status' => true,
                'message'=> 'Đã add Zalo thành công!'
            ]);
        }
    }

    public function changeStatusAddZaloVue($id)
    {
        $hocVien = HocVienLopHoc::where('id', $id)->first();
        $nhanVien = auth('sanctum')->user();

        if($hocVien) {
            $hocVien->is_add_zalo = !$hocVien->is_add_zalo;
            $hocVien->id_nhan_vien_add_zalo = $nhanVien->id;
            $hocVien->save();

            return response()->json([
                'status' => true,
                'message'=> 'Đã add Zalo thành công!'
            ]);
        }
    }

    public function deleteHocVien(Request $request)
    {
        $hocVienLopHoc = HocVienLopHoc::find($request->id);
        $hocVienLopHoc->is_hoc_vien = 2;
        $check = $hocVienLopHoc->save();
        if($check){
            $hocVien = HocVien::find($request->id_hoc_vien);
            $hocVien->is_hoc_vien = 0;
            $hocVien->save();

            return response()->json([
                'status' => true,
                'message'=> 'Đã xóa học viên thành công!'
            ]);
        }

    }

    public function updateTeamViewUtraview(Request $request)
    {

        $data = $request->all();
        DB::transaction(function () use ($data){
            $hocVien = HocVien::find($data['id']);
            if($hocVien) {
                $hocVien->danh_sach_teamview = $data['danh_sach_teamview'];
                $hocVien->save();
            }
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã cập nhật TeamView/UlraView thành công!',
        ]);
    }
    public function search(Request $request)
    {
        // dd($request->all());
        $search = $request->all();
        $data = HocVienLopHoc::where('id_lop_hoc', $request->id_lop_hoc)
                             ->join('hoc_viens', 'hoc_vien_lop_hocs.id_hoc_vien', 'hoc_viens.id')
                             ->join('lop_hocs', 'hoc_vien_lop_hocs.id_lop_hoc', 'lop_hocs.id')
                             ->join('khoa_hocs', 'lop_hocs.id_khoa_hoc', 'khoa_hocs.id')
                             ->where('hoc_vien_lop_hocs.is_hoc_vien', 1)
                             ->where(function ($query) use ($search) {
                                $query->where('hoc_viens.ho_va_ten', 'like', '%' . $search['search'] . '%')
                                ->orWhere('hoc_viens.email', 'like', '%' . $search['search'] . '%')
                                ->orWhere('hoc_viens.so_dien_thoai', 'like', '%' . $search['search'] . '%');
                            })
                             ->orderBy('hoc_viens.ten')
                             ->select('hoc_vien_lop_hocs.id', 'hoc_vien_lop_hocs.is_add_fb', 'hoc_vien_lop_hocs.is_add_zalo','hoc_vien_lop_hocs.is_hoc_vien',
                                      'hoc_viens.ho_va_ten', 'hoc_viens.email', 'hoc_viens.name_zalo', 'hoc_viens.so_dien_thoai','hoc_viens.facebook','hoc_viens.danh_sach_teamview',
                                      'khoa_hocs.ten_khoa_hoc','hoc_viens.id as id_hoc_vien','lop_hocs.ten_lop_hoc','hoc_viens.name_zalo'
                            )
                            ->get();

        // dd($data->toArray());
        return response()->json([
            'data'           => $data,
        ]);
    }

    public function updateTrangThai(DeleteLopHocRequest $request)
    {
        $lopHoc = LopHoc::find($request->id);

        $lopHoc->update($request->all());

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã cập nhật thành công!',
        ]);
    }

    public function doiBuoi(DoiBuoiHocRequest $request)
    {
        $buoi_hoc = BuoiHoc::find($request->id_buoi_doi);
        $lopHoc = LopHoc::find($buoi_hoc->id_lop_hoc);
        $check = BuoiHoc::where('id_lop_hoc', $buoi_hoc->id_lop_hoc)
                        ->whereDate("gio_bat_dau", Carbon::parse($request->ngay_bat_dau_di_hoc_lai)->toDateString())
                        ->first();
        if(!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Ngày học lại không nằm trong những buổi học ',
            ]);
        }
        $list_buoi_hoc = BuoiHoc::where('id_lop_hoc', $buoi_hoc->id_lop_hoc)
                       ->whereDate('gio_bat_dau', '>=', Carbon::parse($buoi_hoc->gio_bat_dau)->toDateString())
                       ->orderBy("gio_bat_dau")
                       ->get();

        $thu_trong_tuan  = explode(',', $lopHoc->thu_trong_tuan);
        $khoang_cach_ngay = Carbon::parse($buoi_hoc->gio_bat_dau)->diffInDays(Carbon::parse($request->ngay_bat_dau_di_hoc_lai));
        if ($khoang_cach_ngay > 0) {
            $khoang_cach_ngay = $khoang_cach_ngay + 1;
        }
        foreach ($list_buoi_hoc as $value) {
            $ngay_moi       = Carbon::parse($value->gio_bat_dau)->addDays($khoang_cach_ngay);
            $ngay_moi_end   = Carbon::parse($value->gio_ket_thuc)->addDays($khoang_cach_ngay);
            $check = false;
            while($check == false) {
                $thu = Carbon::parse($ngay_moi)->dayOfWeek != 0 ? Carbon::parse($ngay_moi)->dayOfWeek + 1 : Carbon::parse($ngay_moi)->dayOfWeek;
                if(in_array($thu, $thu_trong_tuan)) {
                    $check = true;
                    break;
                } else {
                    $ngay_moi->addDays(1);
                    $ngay_moi_end->addDays(1);
                }
            }

            // Đổi thông tin lịch học học viên
            // dd($ngay_moi->toDateTimeString());
            LichHoc::where('id_buoi_hoc', $value->id)->delete();

            BuoiHoc::where('id_lop_hoc', $buoi_hoc->id_lop_hoc)
                                        ->whereDate('gio_bat_dau', $ngay_moi)
                                        ->join('lich_hocs', 'lich_hocs.id_buoi_hoc', 'buoi_hocs.id')
                                        ->select('lich_hocs.*', 'gio_bat_dau')
                                        ->update([
                                            'id_buoi_hoc' => $value->id
                                        ]);

            $value->gio_bat_dau = $ngay_moi->toDateTimeString();
            $value->gio_ket_thuc = $ngay_moi_end->toDateTimeString();
            $value->save();
        }
        return response()->json([
            'status'  => 1,
            'message' => "Dời buổi thành công!",
        ]);
    }

}
