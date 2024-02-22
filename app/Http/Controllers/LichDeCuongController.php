<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaoLichDeCuongRequest;
use App\Models\LichDeCuong;
use Illuminate\Http\Request;

class LichDeCuongController extends Controller
{
    public function apiLichTrinh()
    {
        // Tham số postman
        $maMonHoc           = 'CS403';
        $loaiMonHoc         = '1'; // LEC => 0 là LAB
        $danhSachLich       = ['22/02/2023', '01/03/2023', '08/03/2023', '15/03/2023', '22/03/2023'];
        $danhSachDaTao      = ['22/02/2023', '08/03/2023'];
        // Tham số postman

        $soBuoiLichTrinh    = count($danhSachLich);
        $lichCanXuLy        = array_diff($danhSachLich, $danhSachDaTao);

        $check              = 0;
        $lichTrinhDB        = LichDeCuong::where('ma_mon_hoc', $maMonHoc)
                                         ->where('loai_mon', $loaiMonHoc)
                                         ->where('so_buoi_de_cuong', $soBuoiLichTrinh)
                                         ->get();
        if(count($lichTrinhDB) == 0) {
            $lichTrinhDB    = LichDeCuong::where('ma_mon_hoc', $maMonHoc)
                                         ->where('loai_mon', $loaiMonHoc)
                                         ->where('so_buoi_de_cuong', '>' ,$soBuoiLichTrinh)
                                         ->get();
            if(count($lichTrinhDB) > 0) {
                $check  = 1;
            }
        } else {
            $check  = 1;
        }

        if($check) {
            foreach($lichCanXuLy as $value) {
                $key = array_search($value, $danhSachLich) + 1;
                foreach($lichTrinhDB as $k => $v) {
                    if($v->buoi_thu == $key) {
                        $v->ngay_nhap = $value;
                        break;
                    }
                }
            }

            foreach($lichTrinhDB as $k => $v) {
                if(!isset($v->ngay_nhap)) {
                    $lichTrinhDB->forget($k);
                }
            }

            return response()->json([
                'status'    => true,
                'data'      => $lichTrinhDB,
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Lịch trình không tồn tại trên hệ thống!',
            ]);
        }
    }

    public function viewTaoLichDeCuong()
    {
        return view('dtu.tao_lich_de_cuong');
    }

    public function actionTaoLichDeCuong(TaoLichDeCuongRequest $request)
    {
        // dd($request->all());
        $array = $request->array_buoi;
        // dd($array);

        foreach ($array as $key => $value) {
            LichDeCuong::create([
                'ma_mon_hoc'            => $request->ma_mon_hoc,
                'loai_mon'              => $request->loai_mon,
                'buoi_thu'              => $value['buoi'],
                'so_buoi_de_cuong'      => $request->so_buoi_de_cuong,
                'tieu_de'               => $value['tieu_de'],
                'noi_dung'              => $value['noi_dung'],
            ]);
        }
        return response()->json([
            'status'    => true,
            'messages'  => 'Đã tạo lịch thành công'
        ]);
    }
}
