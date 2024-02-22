<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDanhGiaRenLuyenRequest;
use App\Models\Account;
use App\Models\DanhGiaRenLuyen;
use App\Models\DanhSachQuyen;
use Illuminate\Http\Request;

class DanhGiaRenLuyenController extends Controller
{
    public function quyDoiDiem($diem)
    {
        $arr = [['Xuất sắc', 10], ['Giỏi', 10], ['Khá', 10], ['Trung bình', 5], ['Yếu', 0]];
        if($diem >= 3.6) {
            return $arr[0];
        }
        if($diem >= 3.2) {
            return $arr[1];
        }
        if($diem >= 2.5) {
            return $arr[2];
        }
        if($diem >= 2) {
            return $arr[3];
        }
        return $arr[4];
    }

    public function checkBeforeRun(Request $request)
    {
        // Dữ liệu chưa cần lấy điểm của từng sinh viên
        $data = json_decode($request->data);
        foreach($data as $key => $value) {
            $giangVien = Account::where('username', $value->username)->first();
            $check     =  DanhGiaRenLuyen::where('id_giang_vien', $giangVien->id)
                                         ->where('ma_sinh_vien', $value->ma_sinh_vien)
                                         ->where('id_sinh_vien', $value->id_sinh_vien)
                                         ->where('id_ky_hoc', $value->id_ky_hoc)
                                         ->first();
            if($check) {
                unset($data[$key]);
            }
        }
        $data = array_values($data);
        return response()->json([
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $data = json_decode($request->data);
        $giangVien = Account::where('username', $request->username)->first();
        foreach($data as $key => $value) {
            if($giangVien) {
                $check      =  DanhGiaRenLuyen::where('id_giang_vien', $giangVien->id)->where('ma_sinh_vien', $value->ma_sinh_vien)->where('id_ky_hoc', $value->id_ky_hoc)->first();
                if(!$check) {
                    $name = $value->ho_va_ten;
                    $splitName = explode(' ', $name, 2);
                    $first_name = $splitName[0];
                    $last_name = !empty($splitName[1]) ? $splitName[1] : '';
                    DanhGiaRenLuyen::create([
                        'ma_sinh_vien'      =>      $value->ma_sinh_vien,
                        'ho_va_ten'         =>      $value->ho_va_ten,
                        'ho_lot'            =>      $first_name,
                        'ten_sinh_vien'     =>      $last_name,
                        'dien_thoai'        =>      $value->so_dien_thoai,
                        'dia_chi'           =>      $value->dia_chi,
                        'email'             =>      $value->email,
                        'nganh_hoc'         =>      $value->so_dien_thoai,
                        'id_sinh_vien'      =>      $value->id_sinh_vien,
                        'ky_hoc'            =>      $value->ky_hoc,
                        'id_ky_hoc'         =>      $value->id_ky_hoc,
                        'diem_tich_luy'     =>      $value->diem_tich_luy,
                        'xep_loai'          =>      $this->quyDoiDiem($value->diem_tich_luy)[0],
                        'diem_quy_doi'      =>      $this->quyDoiDiem($value->diem_tich_luy)[1],
                        'id_giang_vien'     =>      $giangVien->id,
                        'id_danh_gia'     =>        $value->id_danh_gia,
                    ]);
                }
            }
        }

        $data = DanhGiaRenLuyen::where('id_giang_vien', $giangVien->id)->where('id_ky_hoc', $request->id_hoc_ki)->get();

        return response()->json([
            'status'  => true,
            'mess'    => 'Thành Công!',
            'data'    => $data,
        ]);
    }

    public function updateDanhGiaRenLuyen(Request $request)
    {
        $danhGia = DanhGiaRenLuyen::find($request->id);
        if($danhGia) {
            $danhGia->is_done = $request->is_done;
            $danhGia->save();

            $account = Account::find($danhGia->id_giang_vien);
            if($account) {
                $account->count_use = $account->count_use + 1;
                $account->save();
            }
        }
    }
}
