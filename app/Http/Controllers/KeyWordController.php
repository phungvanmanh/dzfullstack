<?php

namespace App\Http\Controllers;

use App\Models\KeyWord;
use App\Models\ThongKeKeyWord;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KeyWordController extends Controller
{
    public function getData()
    {
        $data = KeyWord::all();
        return response()->json([
            'status' => true,
            'data'  => $data
        ]);
    }

    public function getDataRandom(Request $request)
    {
        $number = $request->number;
        $keyword = KeyWord::where('from', '<=', $number)
                          ->where('to', '>=', $number)
                          ->first();

        if($keyword) {
            return response()->json([
                'status'    => true,
                'data'      => $keyword,
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Keyword không tồn tại',
            ]);
        }
    }

    public function updateCountKey(Request $request)
    {
        $data = $request->all();
        $thong_ke = ThongKeKeyWord::where('id_keyword', $data['id'])
                                  ->whereDate('ngay_thong_ke', Carbon::today())
                                  ->first();

        if($thong_ke) {
            $thong_ke->so_lan_click = $thong_ke->so_lan_click + 1;
            $thong_ke->save();
        } else {
            ThongKeKeyWord::create([
                'ngay_thong_ke'     => Carbon::today(),
                'id_keyword'        => $data['id'],
                'so_lan_click'      => 1,
                'key_word'          => $data['keyword']
            ]);
        }
        return response()->json([
            'status'    => true,
        ]);
    }
}
