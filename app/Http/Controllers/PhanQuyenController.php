<?php

namespace App\Http\Controllers;

use App\Models\PhanQuyen;
use Illuminate\Http\Request;

class PhanQuyenController extends Controller
{
    public function index()
    {
        return view('admin.page.phan_quyen.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show(PhanQuyen $phanQuyen)
    {
        //
    }

    public function edit(PhanQuyen $phanQuyen)
    {
        //
    }

    public function update(Request $request, PhanQuyen $phanQuyen)
    {
        //
    }

    public function destroy(PhanQuyen $phanQuyen)
    {
        //
    }
}
