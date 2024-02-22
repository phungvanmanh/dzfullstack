@extends('admin.share.master')
@section('content')
<div class="row" id="app">
    <div class="col-md-12">
        <div class="card border-primary border-bottom border-3 border-0">
            <div class="card-header">
                <h5>Quản Lý Học Kì</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <form id="formThemMoiHocKi">
                            <div class="row">
                                <div class="col-md-12 mt-1">
                                    <label class="form-label">Năm Học</label>
                                    <input name="year" type="text" class="form-control" placeholder="VD: 2022-2023">
                                </div>
                                <div class="col-md-12 mt-1">
                                    <label class="form-label" >Học Kì</label>
                                    <select name="ky" class="form-control" >
                                        <option value="">Chọn học kì</option>
                                        <option v-bind:value="1">Học kì 1</option>
                                        <option v-bind:value="2">Học kì 2</option>
                                        <option v-bind:value="3">Học kì Hè</option>
                                    </select>
                                </div>
                                <div class="col-md-12 mt-1">
                                    <label class="form-label">Ngày Bắt Đầu</label>
                                    <input name="begin" type="date" class="form-control">
                                </div>
                                <div class="col-md-12 mt-1">
                                    <label class="form-label">Ngày Kết Thúc</label>
                                    <input name="end" type="date" class="form-control">
                                </div>
                                <div class="col-md-12 mt-3 text-end">
                                    <button type="button" v-on:click="createHocKi($event)" class="btn btn-primary">Thêm Mới</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-primary text-center">
                                    <th>#</th>
                                    <th>Năm Học</th>
                                    <th>Học Kì</th>
                                    <th>Ngày Bắt Đầu</th>
                                    <th>Ngày Kết Thúc</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    <tr class="text-center" v-for="(value, index) in list">
                                        <th class="align-middle">@{{ index + 1 }}</th>
                                        <td class="align-middle">@{{ value.year}}</td>
                                        <td class="align-middle">Học Kì @{{ value.ky}}</td>
                                        <td class="align-middle">@{{ date_format(value.begin)}}</td>
                                        <td class="align-middle">@{{ date_format(value.end)}}</td>
                                        <td>
                                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editHocKi" v-on:click="edit = Object.assign({}, value)">Edit</button>
                                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteHocKi"  v-on:click="edit = Object.assign({}, value)">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        {{-- Xóa --}}
                        <div class="modal fade" id="deleteHocKi" tabindex="-1" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Xoá Học Kì</b></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-wrap">
                                        <p class="text-danger">Bạn có chắc chắn là sẽ học kì học này?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" v-on:click="deleteHocKi()">Xoá</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- edit --}}
                        <div class="modal fade" id="editHocKi" tabindex="-1" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Chỉnh Sửa Học Kì</b></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-wrap">
                                        <div class="col-md-12 mt-1">
                                            <label class="form-label">Năm Học</label>
                                            <input name="year" type="text" class="form-control" v-model="edit.year" placeholder="VD: 2022-2023">
                                        </div>
                                        <div class="col-md-12 mt-1">
                                            <label class="form-label" >Học Kì</label>
                                            <select name="ky" class="form-control" v-model="edit.ky">
                                                <option value="">Chọn học kì</option>
                                                <option v-bind:value="1">Học kì 1</option>
                                                <option v-bind:value="2">Học kì 2</option>
                                                <option v-bind:value="3">Học kì Hè</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 mt-1">
                                            <label class="form-label">Ngày Bắt Đầu</label>
                                            <input name="begin" type="date" class="form-control" v-model="edit.begin">
                                        </div>
                                        <div class="col-md-12 mt-1">
                                            <label class="form-label">Ngày Kết Thúc</label>
                                            <input name="end" type="date" class="form-control" v-model="edit.end">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-danger" v-on:click="updateHocKi()" data-bs-dismiss="modal">Cập Nhập</button>
                                    </div>
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
        el: '#app',
        data: {
            list    : [],
            edit    : {},
        },
        created() {
            this.loadTableHocKi();
        },
        methods: {
            //so sánh 2 chuỗi với nhau
            isToday(date) {
                return new Date(date).toDateString() === new Date().toDateString();
            },

            date_format(now) {
                return moment(now).format('DD/MM/yyyy');
            },

            createHocKi(){
                const payload = window.getFormData($("#formThemMoiHocKi"));
                axios
                    .post('/dtu/tao-hoc-ky', payload)
                    .then((res) => {
                        if (res.data.status) {
                            displaySuccess(res);
                            $('#formThemMoiHocKi').trigger("reset");
                            this.loadTableHocKi();
                        }
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },

            updateHocKi(){
                axios
                    .post('/dtu/update-hoc-ky', this.edit)
                    .then((res) => {
                        if (res.data.status) {
                            displaySuccess(res);
                            this.loadTableHocKi();
                        }
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },

            deleteHocKi(){
                axios
                    .post('/dtu/delete-hoc-ky', this.edit)
                    .then((res) => {
                        if (res.data.status) {
                            displaySuccess(res);
                            this.loadTableHocKi();
                        }
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },

            loadTableHocKi()
            {
                axios
                    .get('/dtu/data-hoc-ky')
                    .then((res) => {
                        this.list = res.data.data;
                    });
            }
        }
    });
</script>
@endsection

