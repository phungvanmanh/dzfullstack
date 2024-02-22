@extends('admin.share.master')
@section('content')

    <div class="row">
        <div class="card border-primary border-bottom border-3 border-0">
            <div class="card-header mt-3 mb-3">
                <div class="row">
                    <div class="col mt-2">
                        <h6>Danh Sách Nhân Sự</h6>
                    </div>
                    <div class="col text-end mb-2">
                        <button class="btn btn-primary">Thêm Mới</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-drop">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">AAAAAA</th>
                                <th class="text-center">AAAAAA</th>
                                <th class="text-center">AAAAAA</th>
                                <th class="text-center">AAAAAA</th>
                                <th class="text-center">AAAAAA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < 3; $i++)
                                <tr>
                                    <th class="text-center align-middle">#</th>
                                    <td class="text-center align-middle">AAAAAA</td>
                                    <td class="text-center align-middle">AAAAAA</td>
                                    <td class="text-center align-middle">AAAAAA</td>
                                    <td class="text-center align-middle">AAAAAA</td>
                                    <td class="text-center align-middle">
                                        <button class="btn btn-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false">Primary</button>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection
