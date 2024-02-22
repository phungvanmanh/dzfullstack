<?php

namespace App\Http\Controllers;

use App\Models\DeCuong;
use App\Models\LichDeCuong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeCuongContoller extends Controller
{
    public function index()
    {
        return view('admin.page.de_cuong.index');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $clo = '[';
        foreach($data['clo'] as $value) {
            if(preg_match("/^(?=.*[a-zA-Z])[a-zA-Z0-9]+$/", $value['name'])){
                $clo .= "'" . $value['name'] . "'" . '|';
            } else {
                $clo .= $value['name'] . '|';
            }
            // dd($value['name']);
        }
        $clo .= ']';
        $cont = '[';
        foreach($data['cont'] as $value) {
                $cont .= $value['name'] . ',';
            // dd($value['name']);
        }
        $cont .= ']';
        // dd($clo,$cont);
        DB::transaction(function () use ($data,$clo,$cont) {
            DeCuong::create([
                'CLO'   =>  $clo,
                'CONT'  =>  $cont,
                'id_quy_tac' => $data['quytac'],
                'ma_mon_hoc' => $data['decuong']['ma_mon_hoc'],
                'ten_mon_hoc' => $data['decuong']['ten_mon_hoc'],
                'loai_mon_hoc' => $data['decuong']['loai_mon_hoc'],
                'quy_tac' => $data['decuong']['quy_tac'],
            ]);
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã thêm mới thành công!',
        ]);
    }

    public function getData()
    {
        $data = DeCuong::get();
        return response()->json([
            'data'   =>  $data,
        ]);
    }

    public function destroy(Request $request){
        $data = $request->all();
       // dd($data);
        DB::transaction(function () use ($data) {
            DeCuong::find($data['id'])->delete();
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã xoá đề cương thành công!',
        ]);
    }

    public function getlichTrinh(Request $request)
    {
        $data = LichDeCuong::where('ma_mon_hoc', $request->ma_mon_hoc)->get();

        return response()->json(['data' => $data]);
    }
    public function update(Request $request){

    }

    public function kiemTraQuyTac(Request $request)
    {
        $deCuong = DeCuong::where('ma_mon_hoc', $request->ma_mon_hoc)->first();
        if($deCuong) {
            $quyTac     = $request->danh_sach;
            $deCuong->id_quy_tac = str_replace("'", '"', $deCuong->id_quy_tac);
            $dataQuyTac = json_decode($deCuong->id_quy_tac);
            // dd($dataQuyTac, $request->danh_sach ,$deCuong->toArray());
            foreach($dataQuyTac as $k => $v) {
                if($v->math != $quyTac[$k]) {
                    return response()->json([
                        'status'              => 2,
                        'message'             => 'Sai quy tắc!',
                        'ten_giang_vien'      => $request->ten_giang_vien,
                        'ma_lop_hoc'          => $request->ma_lop_hoc,
                    ]);
                }
            }
            return response()->json([
                'status'              => 1,
                'message'             => 'Đúng quy tắc',
                'ten_giang_vien'      => $request->ten_giang_vien,
                'ma_lop_hoc'          => $request->ma_lop_hoc,
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Đề cương không tồn tại!',
            ]);
        }
    }
}
