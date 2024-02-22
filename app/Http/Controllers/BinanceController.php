<?php

namespace App\Http\Controllers;

use App\Models\Binance;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BinanceController extends Controller
{
    public function index()
    {
        return view('binance.index');
    }

    public function getData()
    {
        set_time_limit(480);
        $client = new Client();

        try {
            $response   = $client->get(env('URL_BINA') . '/get-data');
            $data_ele   = json_decode($response->getBody(), true);
            $data       = [];
            foreach ($data_ele['data'] as $key => $value) {
                if($value['name'] == "ETHUSDT") {
                    $data['PredictedRateETHUSDT']   = rtrim($value['predicterdRate'], "%");
                    $data['PriceETHUSDT']           = $value['price'];
                }
                if($value['name'] == "ETHUSD") {
                    $data['PredictedRateETHUSD']   = rtrim($value['predicterdRate'], "%");
                    $data['PriceETHUSD']           = $value['price'];
                }
                if($value['name'] == "BINETH") {
                    if($value['predicterdRate']) {
                        $data['BINETHUSDT']   = rtrim($value['predicterdRate'], "%");
                    }
                    if($value['price']) {
                        $chuoiKhongDauPhay = str_replace(',', '', $value['price']);
                        $soThapPhan = floatval($chuoiKhongDauPhay);
                        $data['PriceBINETHUSDT']   = $soThapPhan;
                    }
                }
            }
            $data['time'] = $data_ele['time'];
            Binance::create($data);
            return response()->json([
                'status'    => true,
                'message'   => 'Lấy dữ liệu thành công!'
            ]);

        } catch (Exception $e) {
            Log::info($e);
            return response()->json([
                'status'    => false,
                'message'   => 'Đã có lỗi xảy ra, vui lòng khởi động lại chương trình!'
            ]);
        }
    }

    public function getDataNew()
    {
        set_time_limit(480);
        $client = new Client();
        try {
            DB::table('binances')->delete();

            DB::table('binances')->truncate();

            $response   = $client->get(env('URL_BINA') . '/get-data-all');
            $data_ele   = json_decode($response->getBody(), true);
            return response()->json($data_ele);
        } catch (Exception $e) {
            Log::info($e);
            return response()->json([
                'status'    => false,
                'message'   => 'Đã có lỗi xảy ra, vui lòng khởi động lại chương trình!'
            ]);
        }
    }

    public function dataBinance()
    {
        $data = Binance::select('binances.*', DB::raw('DATE_FORMAT(time, "%d/%m/%Y %H:%i:%s") as time_convert'))
                       ->orderByDESC('time')
                    //    ->take(20)
                       ->get();
        return response()->json([
            'data' => $data
        ]);
    }

    public function createDataBinance(Request $request)
    {
        Log::info($request->all());

        $data = $request->data;


        DB::table('binances')->insert($data);

        return response()->json([
            'status'    => true,
            'message'   => 'Success'
        ]);
    }

    public function resetData()
    {
        DB::table('binances')->delete();

        DB::table('binances')->truncate();

        return response()->json([
            'status'    => true,
            'message'   => 'Success'
        ]);
    }
}
