<?php

namespace App\Http\Controllers;

use App\Jobs\JobSendMailOLPWISE;
use App\Models\BuoiHoc;
use App\Models\LopHoc;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function ai(Request $request)
    {
        $result = OpenAI::completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => $request->question,
            'max_tokens' => 600,
            'temperature' => 0
        ]);

        echo $result['choices'][0]['text'];
    }

    public function test($question)
    {


        return redirect('/admin/lich-lam-viec/dang-ky');
        // return view('mail.forgot_password');
    }

    public function index(Request $request)
    {
        $ipServer = $_SERVER['SERVER_NAME'];
        $os = PHP_OS;
        dd($ipServer, $os);
        $host = 'localhost'; // hoặc 127.0.0.1 nếu bạn đang chạy trên máy tính cá nhân
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        dd($ipAddress);

        dd($first_name, $last_name);

        $str = 'hôm nay đi chơi vui quá trời nè, tớ rất là vui|b|c';
        dd(explode('|', $str));
        $dir = '/khoa_11/video';
        $recursive = false;
        $listFileName = Storage::disk('google')->listContents($dir, $recursive);
        $service      = Storage::disk('google')->getAdapter()->getService();

        // $parameters['fields'] = "permissions(*)";
        // $permissions = $service->permissions->listPermissions('14pqT9gdGvZfKHWlbmPU-4sZPBXdhg3PvX7DY8BK20hI', $parameters);

        // foreach ($permissions->getPermissions() as $permission){
        //     dd($permission['emailAddress']);
        // }


        foreach($listFileName as $value) {
            if($value['type'] == 'file') {
                dd($value);
            }
            // if($value['type'] == 'file' && $value['extraMetadata']['id'] == '14pqT9gdGvZfKHWlbmPU-4sZPBXdhg3PvX7DY8BK20hI') {
            //     $parameters['fields'] = "permissions(*)";
            //     // $permissions = $service->permissions->listPermissions($value['extraMetadata']['id'], $parameters);
            //     $permission = new \Google_Service_Drive_Permission(array(
            //         'type' => 'user',
            //         'role' => 'reader',
            //         'emailAddress' => 'thanhtruong23111999@gmail.com',
            //     ));

            //     $service->permissions->create(
            //         $value['extraMetadata']['id'], $permission
            //     );

            //     dd('Done');

            //     dd($value['extraMetadata']['id']);
            //     dd($value);
            //     dd($value['extraMetadata']['filename']);
            //     dd($value['extraMetadata']['id']);
            // }
        }

        dd($listFileName);
        return view('admin.page.vcard.index');
    }

    public function lichLamViecTuan()
    {
        return view('admin.page.lich_support_tuan.index');
    }

    public function testMail(Request $request)
    {
        Log::info('done');
        $data = $request->all();
        // $data = [
        //     'name' => 'Võ Đình Quốc Huy test 2',
        //     'email' => 'vodinhhuy1511@gmail.com',
        //     'so_dien_thoai' => '0889470271',
        //     'doi_tuong' => 'Cao đẳng, Đại học',
        //     'school' => 'THPT Nguyễn Trãi',
        //     'dia_chi' => 'Huyện Hoàng Sa',
        // ];

        JobSendMailOLPWISE::dispatch($data);

        return response()->json([
            'status' => true,
            'messsage' => "Đã post thành công !",
            'data' => $data ,
        ]);
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

    public function themMoiBuoiHoc()
    {

        $ngay_cuoi_cung = BuoiHoc::where('id_lop_hoc', 8)
                                 ->orderByDESC('gio_bat_dau')
                                 ->first();

        try {
            DB::transaction(function () use($ngay_cuoi_cung) {
                $lop_hoc        = LopHoc::find($ngay_cuoi_cung->id_lop_hoc);
                $array_thu      = explode(',', $lop_hoc->thu_trong_tuan);
                $ngay_hoc       = Carbon::parse($ngay_cuoi_cung->gio_bat_dau)->addDay();

                $dem_ngay       = $ngay_cuoi_cung->thu_tu_buoi_khoa_hoc;

                $gio_bat_dau    = Carbon::parse( $ngay_cuoi_cung->gio_bat_dau)->toTimeString();
                $gio_ket_thuc   = Carbon::parse( $ngay_cuoi_cung->gio_ket_thuc)->toTimeString();
                while($dem_ngay <= 46) {
                    $check_ngay = $ngay_hoc->dayOfWeek + 1 ;
                    if(in_array($check_ngay, $array_thu)) {
                        $ngay_gio_bat_dau  = $ngay_hoc->format("Y-m-d") . " " . $gio_bat_dau;
                        $ngay_gio_ket_thuc = $ngay_hoc->format("Y-m-d") . " " . $gio_ket_thuc;
                        $data_buoi         = [
                            'id_lop_hoc'                => $lop_hoc->id,
                            'thu_tu_buoi_khoa_hoc'      => $dem_ngay,
                            'gio_bat_dau'               => Carbon::parse($ngay_gio_bat_dau)->toDateTimeString(),
                            'gio_ket_thuc'              => Carbon::parse($ngay_gio_ket_thuc)->toDateTimeString(),
                            'id_nhan_vien_day'          => $lop_hoc->id_nhan_vien_day,
                        ];
                        if($this->checkBuoiTrung($data_buoi) == false) {
                            $mess = "Buổi học ngày " . $ngay_hoc->format("d/m/Y") . " vào lúc " . $gio_bat_dau . " đã có lớp học!";
                            dd($mess);
                        }
                        BuoiHoc::create($data_buoi);
                        $dem_ngay = $dem_ngay + 1;
                    }
                    $ngay_hoc =  $ngay_hoc->addDay();
                }
            });
        } catch (Exception $e){
            dd($e);
        }

    }
}


