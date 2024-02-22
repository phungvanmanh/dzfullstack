@extends('admin.share.master')
@section('content')
<div class="row" id="app">
    <div class="card">
        <div class="card-header">
            <div class="row text-end">
                <div class="col-md-12">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#supportModal">Thêm Mới</button>
                </div>
            </div>
            <div class="modal fade" id="supportModal" tabindex="-1" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Thêm Mới Key</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col mt-2">
                                    <label class="form-label">KeyWord</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col mt-2">
                                    <label class="form-label">From</label>
                                    <input type="number" class="form-control">
                                </div>
                                <div class="col mt-2">
                                    <label class="form-label">To</label>
                                    <input type="number" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info">Thêm</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Tên Key</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(value,index) in list_key">
                            <th class="text-center align-middle">@{{ index + 1 }}</th>
                            <td class="align-middle text-center">@{{ value.code }}</td>
                            <td class="align-middle">@{{ value.keyword }}</td>
                            <td class="text-center align-middle">@{{ value.from }}</td>
                            <td class="text-center align-middle">@{{ value.to }}</td>
                            <td class="text-center align-middle text-nowrap">
                                <button class="btn btn-primary">Cập Nhập</button>
                                <button class="btn btn-danger">Xóa</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        new Vue({
            el      :   '#app',
            data    :   {
                list_key : [],
            },
            created()   {
                this.loadKey();
            },
            methods :   {
                loadKey() {
                    axios
                        .get('/api/key-word/data')
                        .then((res) => {
                            if(res.data.status) {
                                this.list_key = res.data.data;
                            }
                        });
                }
            },
        });
    </script>
@endsection
