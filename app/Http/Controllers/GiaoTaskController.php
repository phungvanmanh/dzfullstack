<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeStatusDeleteGiaoTaskRequest;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\upDateTaskRequest;
use App\Models\GiaoTask;
use App\Models\NhanVien;
use Carbon\Carbon;
use Google\Service\Batch\Task;
use Google\Service\CloudSearch\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GiaoTaskController extends Controller
{

    public function index()
    {
        $nhanVien = NhanVien::where('is_open', 1)->get();
        return view('admin.page.giao_task.index',compact('nhanVien'));
    }

    public function store(CreateTaskRequest $request)
    {
        $data = $request->all();
        DB::transaction(function () use($data){
            $list_nguoi_nhan   = NhanVien::whereIn('id', $data['list_nhan'])
                                         ->select(
                                            DB::raw("GROUP_CONCAT(DISTINCT ho_va_ten) as list_name")
                                         )
                                         ->first()->list_name;

            $data['list_nhan'] = implode(",",$data['list_nhan']);
            $array_ngay        = [];
            for($i = 0; $i < $data['so_lan_lap']; $i++) {
                $ngay_nhan_task = Carbon::parse($data['thoi_gian_nhan']);
                $deadline       = Carbon::parse($data['deadline']);

                $ngay_nhan_task = $ngay_nhan_task->addDays($data['so_ngay_lap'] * $i);
                $deadline       = $deadline->addDays($data['so_ngay_lap'] * $i);
                $array_detail   = [$ngay_nhan_task->format("H:i:s d/m/Y"), $deadline->format("H:i:s d/m/Y")];
                array_push($array_ngay, $array_detail);
                GiaoTask::create([
                    'id_giao'           => $data['id_giao'],
                    'list_nhan'         => $data['list_nhan'],
                    'tieu_de'           => $data['tieu_de'],
                    'thoi_gian_nhan'    => $ngay_nhan_task->addDays($data['so_ngay_lap'] * $i),
                    'deadline'          => $deadline->addDays($data['so_ngay_lap'] * $i),
                    'noi_dung'          => isset($data['noi_dung']) ? isset($data['noi_dung']) : null
                ]);
            }
            $nguoi_giao = NhanVien::find($data['id_giao'])->ho_va_ten;
            $message = $nguoi_giao . " đã tạo task " . $data['tieu_de'] . " và nội dung ". (isset($data['noi_dung']) ? isset($data['noi_dung']) : null)  . ", giao cho các nhân viên <b>". $list_nguoi_nhan ."</b> . Có thông tin thời gian như sau : \n";
            foreach ($array_ngay as $key => $value) {
                $message .= "<b>Lần " . $key + 1 . "</b>: Ngày nhận :<b>" . $value[0] . "</b> -> Deadline : <b>" . $value[1] . "</b> \n";
            }

            $this->sendTelegram($message);
        });

        return response()->json([
            'status' => 1,
            'message'   =>'Đã thêm mới thành công'
        ]);
    }


    public function getData()
    {
        // $sql = 'SELECT giao_tasks.*, a.ho_va_ten as nhan, b.ho_va_ten as giao
        // FROM giao_tasks JOIN nhan_viens as a ON giao_tasks.id_nv_nhan_task = a.id JOIN nhan_viens as b ON giao_tasks.id_nguoi_giao_task = b.id ';

        $data = GiaoTask::join('nhan_viens as a', function ($join) {
                            $join->whereRaw('FIND_IN_SET(a.id, giao_tasks.list_nhan) > 0')
                                  ->where('a.is_open', 1);
                        })
                        ->join('nhan_viens as b', 'b.id', 'giao_tasks.id_giao')
                        ->select('giao_tasks.id', 'b.ho_va_ten as nguoi_giao',
                                'giao_tasks.id_giao',
                                'giao_tasks.tieu_de',
                                DB::raw("DATE_FORMAT(giao_tasks.thoi_gian_nhan, '%d/%m/%Y %H:%i:%s') as thoi_gian_nhan_task"),
                                DB::raw("DATE_FORMAT(giao_tasks.deadline, '%d/%m/%Y %H:%i:%s') as deadline_task"),
                                'giao_tasks.tinh_trang',
                                'giao_tasks.noi_dung',
                                'giao_tasks.list_nhan',
                                'giao_tasks.thoi_gian_nhan',
                                'giao_tasks.deadline'
                        )
                        ->selectRaw('GROUP_CONCAT(DISTINCT a.ho_va_ten ORDER BY a.id ASC) as list_name_nhan')
                        ->groupBy('giao_tasks.id',
                                'b.ho_va_ten',
                                'giao_tasks.id_giao',
                                'giao_tasks.tieu_de',
                                'giao_tasks.thoi_gian_nhan',
                                'giao_tasks.deadline',
                                'giao_tasks.tinh_trang',
                                'giao_tasks.noi_dung',
                                'giao_tasks.list_nhan',
                                'giao_tasks.thoi_gian_nhan',
                                'giao_tasks.deadline'
                                )
                        ->orderBy("deadline")
                        ->get();

        return response()->json([
            'data'   => $data,
        ]);
    }

    public function sendTelegram($message)
    {
        $link_tele = "https://api.telegram.org/bot". env('TELEGRAM_BOT_TOKEN') ."/sendmessage?chat_id=". env('ID_CHAT') ."&text=" . $message . "&parse_mode=html";
        $response = Http::get($link_tele);
        if ($response->successful()) {
            $data = $response->body();
            return $data;
        } else {
            $statusCode = $response->status();
            // Xử lý lỗi nếu có
            return "Yêu cầu không thành công. Mã trạng thái: " . $statusCode;
        }
    }

    public function getLinkAVTNguoiNhanTask($file, $name, $id)
    {
        $root_path = public_path();
        $file_extention = $file->getClientOriginalExtension();
        $file_name = Str::slug($name) .  Str::slug(Carbon::now()->toDateTimeString()) . '.' . $file_extention;
        $link = '/anh-hoan-thanh-task/' .  Str::slug($name) . '-' . $id . '/';

        $path = $root_path . '/' . $link;
        $file->move($path, $file_name);

        return $link . $file_name;
    }

    public function update(upDateTaskRequest $request)
    {
        $data = $request->all();

        DB::transaction(function () use ($data){
            $user = Auth::guard('nhanVien')->user();
            $list_nguoi_nhan   = NhanVien::whereIn('id', $data['list_nhan'])
                                            ->select(
                                            DB::raw("GROUP_CONCAT(DISTINCT ho_va_ten) as list_name")
                                            )
                                            ->first()->list_name;
            $data['list_nhan']      = implode(",",$data['list_nhan']);
            $data['thoi_gian_nhan'] = Carbon::parse($data['thoi_gian_nhan']);
            $data['deadline']       = Carbon::parse($data['deadline']);
            $task = GiaoTask::find($data['id']);
            $task->update($data);
            $message = $user->ho_va_ten . " đã cập nhập task " . $task->tieu_de . " và nội dung " . $task->noi_dung . " có ngày nhận <b>" . Carbon::parse($task->thoi_gian_nhan)->format("H:i:s d/m/Y") . "</b> và Deadline: <b>" .  Carbon::parse($task->deadline)->format("H:i:s d/m/Y") . "</b> giao cho nhân viên <b>" . $list_nguoi_nhan . "</b>";
            $message = $this->sendTelegram($message);
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã cập nhật tasks thành công!',
        ]);
    }


    public function destroy(ChangeStatusDeleteGiaoTaskRequest $request)
    {
        $data = $request->all();

        DB::transaction(function () use ($data){
            GiaoTask::find($data['id'])->delete();
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã xoá task thành công!',
        ]);
    }

    public function changeStatus(ChangeStatusDeleteGiaoTaskRequest $request)
    {
        $data = $request->all();
        DB::transaction(function () use ($data){
            $user = Auth::guard('nhanVien')->user();
            $array = ["Chưa hoàn thành", "Đã hoàn thành"];
            $task = GiaoTask::find($data['id']);
            $task->tinh_trang = !$task->tinh_trang;
            $task->save();
            $message = $user->ho_va_ten . " đã thay đổi trạng thái task " . $task->tieu_de . " có ngày nhận " . Carbon::parse($task->thoi_gian_nhan)->format("H:i:s d/m/Y") . " và Deadline: " .  Carbon::parse($task->deadline)->format("H:i:s d/m/Y") . " thành " . $array[$task->tinh_trang] . "!";
            $this->sendTelegram($message);
        });

        return response()->json([
            'status'    => 1,
            'message'   => 'Đã cập nhật trạng thái Task thành công!',
        ]);

    }

    public function SearchGiaoTask(Request $request){
        if($request->loai==1){
            $data = GiaoTask::join('nhan_viens as a', function ($join) {
                $join->whereRaw('FIND_IN_SET(a.id, giao_tasks.list_nhan) > 0')
                      ->where('a.is_open', 1);
            })
            ->join('nhan_viens as b', 'b.id', 'giao_tasks.id_giao')
            ->whereDate('giao_tasks.thoi_gian_nhan' , '>=', $request->begin)
            ->whereDate('giao_tasks.thoi_gian_nhan' , '<=', $request->end)
            ->select('giao_tasks.id', 'b.ho_va_ten as nguoi_giao',
                    'giao_tasks.id_giao',
                    'giao_tasks.tieu_de',
                    DB::raw("DATE_FORMAT(giao_tasks.thoi_gian_nhan, '%d/%m/%Y %H:%i:%s') as thoi_gian_nhan_task"),
                    DB::raw("DATE_FORMAT(giao_tasks.deadline, '%d/%m/%Y %H:%i:%s') as deadline_task"),
                    'giao_tasks.tinh_trang',
                    'giao_tasks.noi_dung',
                    'giao_tasks.list_nhan',
                    'giao_tasks.thoi_gian_nhan',
                    'giao_tasks.deadline'
            )
            ->selectRaw('GROUP_CONCAT(DISTINCT a.ho_va_ten ORDER BY a.id ASC) as list_name_nhan')
            ->groupBy('giao_tasks.id',
                    'b.ho_va_ten',
                    'giao_tasks.id_giao',
                    'giao_tasks.tieu_de',
                    'giao_tasks.thoi_gian_nhan',
                    'giao_tasks.deadline',
                    'giao_tasks.tinh_trang',
                    'giao_tasks.noi_dung',
                    'giao_tasks.list_nhan',
                    'giao_tasks.thoi_gian_nhan',
                    'giao_tasks.deadline'
                    )
            ->orderBy("deadline")
            ->get();
            // dd($data->toArray());
            return response()->json([
                'status'    => 1,
                'data'   => $data,
            ]);
        }else{
            $data = GiaoTask::join('nhan_viens as a', function ($join) {
                $join->whereRaw('FIND_IN_SET(a.id, giao_tasks.list_nhan) > 0')
                      ->where('a.is_open', 1);
            })
            ->join('nhan_viens as b', 'b.id', 'giao_tasks.id_giao')
            ->whereDate('giao_tasks.deadline' , '>=', $request->begin)
            ->whereDate('giao_tasks.deadline' , '<=', $request->end)
            ->select('giao_tasks.id', 'b.ho_va_ten as nguoi_giao',
                    'giao_tasks.id_giao',
                    'giao_tasks.tieu_de',
                    DB::raw("DATE_FORMAT(giao_tasks.thoi_gian_nhan, '%d/%m/%Y %H:%i:%s') as thoi_gian_nhan_task"),
                    DB::raw("DATE_FORMAT(giao_tasks.deadline, '%d/%m/%Y %H:%i:%s') as deadline_task"),
                    'giao_tasks.tinh_trang',
                    'giao_tasks.noi_dung',
                    'giao_tasks.list_nhan',
                    'giao_tasks.thoi_gian_nhan',
                    'giao_tasks.deadline'
            )
            ->selectRaw('GROUP_CONCAT(DISTINCT a.ho_va_ten ORDER BY a.id ASC) as list_name_nhan')
            ->groupBy('giao_tasks.id',
                    'b.ho_va_ten',
                    'giao_tasks.id_giao',
                    'giao_tasks.tieu_de',
                    'giao_tasks.thoi_gian_nhan',
                    'giao_tasks.deadline',
                    'giao_tasks.tinh_trang',
                    'giao_tasks.noi_dung',
                    'giao_tasks.list_nhan',
                    'giao_tasks.thoi_gian_nhan',
                    'giao_tasks.deadline'
                    )
            ->orderBy("deadline")
            ->get();
            return response()->json([
                'status'    => 1,
                'data'   => $data,
            ]);
        }
    }
}
