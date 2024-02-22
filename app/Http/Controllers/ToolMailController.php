<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchKeyWordRequest;
use App\Http\Requests\ToolsMail\CreateMailRequest;
use App\Http\Requests\ToolsMail\UpdateMailRequest;
use App\Models\MailTools;
use App\Models\Proxy;
use App\Models\ThongKeKeyWord;
use Carbon\Carbon;
use Exception;
use Google\Service\CloudSearch\Card;
use Google\Service\CloudSourceRepositories\Repo;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ToolMailController extends Controller
{
    public function index()
    {
        return view('admin.page.tools.index');
    }

    public function indexProxy()
    {
        return view('admin.page.tools.index_proxy');
    }

    public function createMail(CreateMailRequest $request)
    {
        $data = $request->all();
        $data['id_nhan_vien'] = Auth::guard('nhanVien')->user()->id;
        MailTools::create($data);

        return response()->json([
            'status'  => true,
            'message' => "Ðã tạo mail thành công!"
        ]);
    }

    public function doiTrangThai(Request $request)
    {
        $mail = MailTools::find($request->id);
        if($request->check == 1){
            if($mail->is_die == 1){
                $mail->is_die = 0;
            }else{
                $mail->is_die = 1;
            }
        }else{
            if($mail->is_review == 0){
                $mail->is_review = 1;
            }else if($mail->is_review == 1){
                $mail->is_review = 2;
            }else{
                $mail->is_review = 0;
            }
        }
        $mail->save();
        return response()->json([
            'status'  => true,
            'message' => "Ðã đổi trạng thái thành công!"
        ]);
    }

    public function chonNguoiTao(Request $request)
    {
        if($request->id == 0){
            $data = MailTools::join('nhan_viens', 'nhan_viens.id', 'mail_tools.id_nhan_vien')
                            ->select('mail_tools.*', 'nhan_viens.ho_va_ten')
                            ->get();
        }else{
            $data = MailTools::join('nhan_viens', 'nhan_viens.id', 'mail_tools.id_nhan_vien')
                            ->where('nhan_viens.id', $request->id)
                            ->select('mail_tools.*', 'nhan_viens.ho_va_ten')
                            ->get();
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function createMail_Python(Request $request)
    {
        $data = $request->all();
        $data['id_nhan_vien']   = 1;
        MailTools::create($data);

        return response()->json([
            'status'  => true,
            'message' => "Ðã tạo mail thành công!"
        ]);
    }

    public function getMail($id)
    {
        if($id == 0){
            $data = MailTools::join('nhan_viens', 'nhan_viens.id', 'mail_tools.id_nhan_vien')
                        ->select('mail_tools.*', 'nhan_viens.ho_va_ten')
                        ->get();

            foreach ($data as $key => $value) {
                if($value->cookies) {
                    $value->cookies = json_decode($value->cookies);
                }
            }
        }else{
            $data = MailTools::join('nhan_viens', 'nhan_viens.id', 'mail_tools.id_nhan_vien')
                                ->where('nhan_viens.id', $id)
                                ->select('mail_tools.*', 'nhan_viens.ho_va_ten')
                                ->get();
            foreach ($data as $key => $value) {
                if($value->cookies) {
                    $value->cookies = json_decode($value->cookies);
                }
            }
        }

        return response()->json([
            "data" => $data
        ]);
    }
    public function update(UpdateMailRequest $request)
     {
        $data = $request->all();
        if(isset($data['ngay_farm'])){
            if($data['ngay_farm'] == Carbon::now()->format('Y-m-d')){
                $data['count_farm'] = $data['count_farm'] + 1;
            }else{
                return response()->json([
                    'status'  => false,
                    'message'=> 'Ngày farm chỉ được chọn ngày hiện tại!'
                ]);
            }
        }
        DB::transaction(function () use ($data) {
            MailTools::find($data['id'])->update($data);
        });

        return response()->json([
            'status'  => true,
            'message'=> 'Ðã cập nhật thành công!'
        ]);
    }
    public function destroy(Request $request)
    {
        $data = $request->all();

        DB::transaction(function () use ($data) {
            MailTools::find($data['id'])->delete();
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Ðã xoá thành công!',
        ]);
    }

    public function updateCookie(Request $request)
    {
        $mail = MailTools::find($request->user_id);
        $array = [];
        if($mail->cookies) {
            $array = json_decode($mail->cookies);
        }
        foreach ($request->cookie as $key => $value) {
            array_push($array, (object)$value);
        }
        $cookie = json_encode($array);
        $mail->update([
            'cookies' => $cookie
        ]);

        return response()->json([
            'status' => true
        ]);
    }

    public function countFarmUpdate(Request $request)
    {
        $id = $request->id;
        $mail = MailTools::find($id);
        $mail->update([
            'count_farm' => $mail->count_farm + 1,
        ]);
    }

    public function createProxy(Request $request)
    {
        $data = $request->all();
        Proxy::create($data);
        return response()->json([
            'status'    => true,
            'message'   => 'Thêm Proxy Thành Công!',
        ]);
    }

    public function statusProxy(Request $request)
    {
        $proxy = Proxy::find($request->id);
        if($proxy) {
            $proxy->update([
                'status'        => !$proxy->status,
                'id_nguoi_dung' => $proxy->status != 1 ? 0 : Auth::guard('nhanVien')->user()->id,
            ]);

            return response()->json([
                'status'    => true,
                'message'   => 'Đổi Status Thành Công!',
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Không tìm thấy Proxy',
            ]);
        }

    }

    public function dataProxy()
    {
        $data = Proxy::leftjoin('nhan_viens', 'nhan_viens.id', 'proxies.id_nguoi_dung')
                     ->select('proxies.*', 'nhan_viens.ho_va_ten')
                     ->get();

        return response()->json([
            'status' => true,
            'data'   => $data
        ]);
    }

    public function destroyProxy(Request $request)
    {
        $proxy = Proxy::find($request->id);
        if($proxy) {
            $proxy->delete();
            return response()->json([
                'status'    => true,
                'message'   => 'Đã xóa Proxy Thành Công!',
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Không tìm thấy Proxy',
            ]);
        }
    }

    public function changeIpProxy(Request $request)
    {
        $proxy = Proxy::find($request->id);
        if($proxy) {
            if($proxy->status == 0) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Ip đang hoạt động. Không thể đổi!',
                ]);
            } else {
                $client =  new Client();
                try {
                    $link   = "https://proxyxoay.net/api/rotating-proxy/change-key-ip/" . $proxy->key;
                    $response = $client->get($link);
                    $data = json_decode($response->getBody(), true);

                    return response()->json([
                        'status' => true,
                        'message' => "Đổi IP thành công !"
                    ]);
                } catch (Exception $e){
                    $errorMessage = $e->getMessage();
                    $jsonStart = strpos($errorMessage, '{');
                    $jsonString = substr($errorMessage, $jsonStart);
                    $jsonData = json_decode($jsonString, true);
                    return response()->json([
                        'status' => false,
                        'message' => $jsonData['message']
                    ]);
                }
            }
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Không tìm thấy Proxy',
            ]);
        }
    }

    public function giaHanProxy(Request $request)
    {
        $proxy = Proxy::find($request->id);
        if($proxy) {
            $client =  new Client();
                try {
                    $link   = "https://proxyxoay.net/api/rotating-proxy/renew-key";
                    $response = $client->post($link, [
                        'headers' => [
                            "Authorization" => "Bearer 2062|ZKXtlaOBiLqP0TgejtEaQE4ZFfDuknP7nX5WmZF0"
                        ],
                        'form_params' => [
                            "api_key" => $proxy->key
                        ]
                    ]);
                    $data = json_decode($response->getBody(), true);
                    return response()->json([
                        'status' => true,
                        'message' => "Gia Hạn Key thành công !"
                    ]);
                } catch (Exception $e){
                    $errorMessage = $e->getMessage();
                    $jsonStart = strpos($errorMessage, '{');
                    $jsonString = substr($errorMessage, $jsonStart);
                    $jsonData = json_decode($jsonString, true);
                    return response()->json([
                        'status' => false,
                        'message' => $jsonData['message']
                    ]);
                }
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Không tìm thấy Proxy',
            ]);
        }
    }

    public function danhSachKeyWord()
    {
        return view('admin.page.thong_ke_key.index');
    }

    public function indexChart()
    {
        return view('admin.page.thong_ke_key.chart');
    }

    public function dataChart()
    {
        $day_begin = Carbon::today()->startOfWeek();
        $day_end   = Carbon::today()->endOfWeek();
        $data = ThongKeKeyWord::whereDate('ngay_thong_ke', '>=', $day_begin)
                              ->whereDate('ngay_thong_ke', '<=', $day_end)
                              ->join('key_words', 'key_words.id', 'thong_ke_key_words.id_keyword')
                              ->select('key_words.code',
                              'key_words.keyword',
                                DB::raw('SUM(thong_ke_key_words.so_lan_click) as tong_click')
                              )
                              ->groupBy('key_words.code', 'key_words.keyword')
                              ->get();

        $array_ten      = [];
        $array_so_lieu  = [];
        $array_key      = [];
        foreach ($data as $key => $value) {
            array_push($array_so_lieu, $value->tong_click);
            array_push($array_ten, $value->code);
            array_push($array_key, $value->keyword);
        }

        return response()->json([
            'labels' => $array_ten,
            'datas'  => $array_so_lieu,
            'dataKey'  => $array_key,
        ]);
    }

    public function searchKeywork(SearchKeyWordRequest $request) {
        $data = $request->all();
        $day_begin = Carbon::parse($data['begin']);
        $day_end = Carbon::parse($data['end']);
        $data = ThongKeKeyWord::whereDate('ngay_thong_ke', '>=', $day_begin)
                              ->whereDate('ngay_thong_ke', '<=', $day_end)
                              ->join('key_words', 'key_words.id', 'thong_ke_key_words.id_keyword')
                              ->select('key_words.code',
                              'key_words.keyword',
                                DB::raw('SUM(thong_ke_key_words.so_lan_click) as tong_click')
                              )
                              ->groupBy('key_words.code', 'key_words.keyword')
                              ->get();

        $array_ten      = [];
        $array_so_lieu  = [];
        $array_key      = [];
        foreach ($data as $key => $value) {
            array_push($array_so_lieu, $value->tong_click);
            array_push($array_ten, $value->code);
            array_push($array_key, $value->keyword);
        }
        // DD();
        return response()->json([
            'labels' => $array_ten,
            'datas'  => $array_so_lieu,
            'dataKey'  => $array_key,
        ]);
    }
}
