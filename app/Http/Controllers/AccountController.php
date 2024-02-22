<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\AccountsRequet\ChangeActiveRequest;
use App\Http\Requests\Admin\AccountsRequet\CreateAccountRequest;
use App\Models\Account;
use Flasher\Laravel\Http\Request as HttpRequest;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        return view('admin.page.account.index');
    }

    public function createAccount(CreateAccountRequest $request)
    {
        Account::create($request->all());
        return response()->json([
            'status'    => 1,
            'message'   => 'Đã thêm mới Account thành công !'
        ]);
    }

    public function getData()
    {
        $data = Account::all();

        return response()->json([
            'data'    => $data,
        ]);
    }

    public function changeActive(ChangeActiveRequest $request)
    {
        $account  = Account::find($request->id);
        if($account){
            $account->is_active = !$account->is_active;
            $account->save();
            return response()->json([
                'status'    => 1,
                'message'   => 'Đã đổi trạng thái Account thành công !'
            ]);
        }else{
            return response()->json([
                'status'    => 0,
                'message'   => 'Account không tồn tại đã có lỗi hệ thống ! !'
            ]);
        }
    }

    public function deleteAccount(ChangeActiveRequest $request)
    {
        $account  = Account::find($request->id);
        if($account){
            $account->delete();
            return response()->json([
                'status'    => 1,
                'message'   => 'Đã xóa Account thành công !'
            ]);
        }else{
            return response()->json([
                'status'    => 0,
                'message'   => 'Account không tồn tại đã có lỗi hệ thống ! !'
            ]);
        }
    }
}
