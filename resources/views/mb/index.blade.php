@extends('admin.share.master')
@section('content')
<div class="row" id="app">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                Thêm Mới User MB
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">User Name</label>
                    <input type="text" v-model="add.user_mb" class="form-control">
                </div>
                <hr>
                <div class="mb-3 text-end">
                    <button class="btn btn-primary" v-on:click="themMoi()">Thêm Mới</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                Danh Sách User MB
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center align-middle">
                                <th>#</th>
                                <th>Username</th>
                                <th>Trạng Thái</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="align-middle text-nowrap" v-for="(value, index) in list_user">
                                <th class="text-center">@{{ index + 1 }}</th>
                                <td>@{{ value.user_mb }}</td>
                                <td class="text-center">
                                    <button v-if="value.is_active == 0" class="btn btn-danger" v-on:click="changStatus(value)">Khóa Kích Hoạt</button>
                                    <button v-else class="btn btn-success" v-on:click="changStatus(value)">Đang Kích Hoạt</button>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal" v-on:click="detail = Object.assign({}, value)">Cập Nhật</button>
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" v-on:click="detail = Object.assign({}, value)">Xóa</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">User Name</label>
                            <input type="text" v-model="detail.user_mb" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" v-on:click="update()">Save changes</button>
                    </div>
                  </div>
                </div>
            </div>


            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" role="alert">
                            Bạn có chắc chắn muốn xóa User <b>@{{ detail.user_mb }}</b> không!
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" v-on:click="destroy()">Xác Nhận</button>
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
        el          : "#app",
        data        : {
            add         : {},
            detail      : {},
            list_user   : [],
        },
        created() {
            this.loadData();
        },
        methods: {
            themMoi() {
                axios
                    .post('/admin/config/create', this.add)
                    .then((res) => {
                        displaySuccess(res);
                        this.loadData();
                        this.add = {};
                    })
                    .catch((error) => {
                        displayErrors(error);
                    })
            },

            update() {
                axios
                    .post('/admin/config/update', this.detail)
                    .then((res) => {
                        displaySuccess(res);
                        this.loadData();
                        $("#updateModal").modal('hide');
                    })
                    .catch((error) => {
                        displayErrors(error);
                    })
            },

            destroy() {
                axios
                    .post('/admin/config/delete', this.detail)
                    .then((res) => {
                        displaySuccess(res);
                        this.loadData();
                        $("#deleteModal").modal('hide');
                    })
                    .catch((error) => {
                        displayErrors(error);
                    });
            },

            loadData() {
                axios
                    .post('/admin/config/data')
                    .then((res) => {
                        this.list_user = res.data.data;
                    })
                    .catch((error) => {
                        displayErrors(error);
                    })
            },

            changStatus(value) {
                axios
                    .post('/admin/config/status', value)
                    .then((res) => {
                        displaySuccess(res);
                        this.loadData();
                    })
                    .catch((error) => {
                        displayErrors(error);
                    })
            },
        },
    })
</script>
@endsection
