@extends('admin.share.master')
@section('content')
    <div id="app" class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <b>Thông Tin Proxy</b>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-12 ">
                                <label class="form-label">Ip/Host</label>
                                <input v-model="add.ip" type="text" class="form-control" placeholder="Nhập đầy đủ họ tên">
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="form-label">Port</label>
                                <input v-model="add.port" type="email" class="form-control" placeholder="Nhập email tạo">
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="form-label">UserName</label>
                                <input v-model="add.username" type="text" class="form-control" placeholder="Nhập password của mail">
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="form-label">Password</label>
                                <input v-model="add.password" type="text" class="form-control">
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="form-label">Key</label>
                                <input v-model="add.key" type="text" class="form-control">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" v-on:click="addMail" type="button">Nhập Proxy</button>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-drop">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Ip</th>
                                    <th class="text-center">Port</th>
                                    <th class="text-center">User</th>
                                    <th class="text-center">Password</th>
                                    <th class="text-center">Người Đang Dùng</th>
                                    <th class="text-center">Trạng Thái</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(value, index) in list" :key="index">
                                    <th class="text-center align-middle">@{{ index + 1 }}</th>
                                    <td class="align-middle">@{{ value.ip }}</td>
                                    <td class="align-middle">@{{ value.port }}</td>
                                    <td class="align-middle">@{{ value.username }}</td>
                                    <td class="align-middle">@{{ value.password }}</td>
                                    <td class="text-center align-middle">@{{ value.ho_va_ten }}</td>
                                    <td class="text-center align-middle">
                                        <button v-if="value.status == 0" v-on:click="doiTrangThai(value)" class="btn btn-primary">Đang Dùng</button>
                                        <button v-else v-on:click="doiTrangThai(value)" class="btn btn-success">Chưa Dùng</button>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button class="btn btn-warning" v-on:click="doiIP(value)">Đổi IP</button>
                                        <button class="btn btn-info" v-on:click="giaHanKey(value)">Gia Hạn</button>
                                        <button class="btn btn-danger" v-on:click="del = value" data-bs-toggle="modal" data-bs-target="#deleteTools" >Xóa</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="modal fade" id="deleteTools" tabindex="-1" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Xóa Mail</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Ban chắc chắn xoá Proxy <b class="text-danger">@{{ del.ip }}</b>
                                        này!<br>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                                        <button v-on:click="xoaProxy()" type="button" class="btn btn-primary">Xóa</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        new Vue({
        el      :  '#app',
        data    :  {
            add       : {},
            list      : [],
            list_nv   : [],
            edit      : {},
            del       : {},
        },
        created() {
            this.loadData();
            this.loadNhanVien();
        },
        methods :   {
            date_format(now) {
                    return moment(now).format('DD/MM/yyyy');
            },
            addMail() {
                axios
                    .post('/api/proxy/create', this.add)
                    .then((res) => {
                        displaySuccess(res);
                        this.loadData();
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },
            loadData() {
                axios
                    .get('/api/proxy/data')
                    .then((res) => {
                        this.list = res.data.data;
                    });
            },

            doiTrangThai(value)
            {
                axios
                    .post('/admin/proxy/status', value)
                    .then((res) => {
                        displaySuccess(res);
                        this.loadData();
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },

            xoaProxy()
            {
                axios
                    .post('/api/proxy/delete', this.del)
                    .then((res) => {
                        displaySuccess(res);
                        this.loadData();
                        $("#deleteTools").modal("hide");
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },

            doiIP(value)
            {
                toastr.warning("Đang xử lý yêu cầu!")
                axios
                    .post('/api/proxy/doi-ip', value)
                    .then((res) => {
                        displaySuccess(res);
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },

            giaHanKey(value)
            {
                toastr.warning("Đang xử lý yêu cầu!")
                axios
                    .post('/api/proxy/gia-han', value)
                    .then((res) => {
                        displaySuccess(res);
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            }
        },
    });
    </script>
@endsection
