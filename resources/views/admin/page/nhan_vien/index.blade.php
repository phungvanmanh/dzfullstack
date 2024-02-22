@extends('admin.share.master')
@section('content')
    <div class="row" id="app">
        <div class="card border-primary border-bottom border-3 border-0">
            <div class="card-header mt-3 mb-3">
                <div class="row">
                    <div class="col mt-2">
                        <h6>Danh Sách Nhân Viên</h6>
                    </div>
                    <div class="col text-end mb-2">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createNhanVien">Thêm
                            Mới</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-drop">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Họ Và Tên</th>
                                <th class="text-center">Gmail</th>
                                <th class="text-center">Số Điện Thoại</th>
                                <th class="text-center">Facebook</th>
                                <th class="text-center">Tài Khoản Git</th>
                                <th class="text-center">Ngày Sinh</th>
                                <th class="text-center">Ngày Bắt Đầu Làm</th>
                                <th class="text-center">Trạng Thái</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(value, index) in list" :key="index">
                                <th class="text-center align-middle">@{{ index + 1 }}</th>
                                <td class="align-middle">@{{ value.ho_va_ten }}</td>
                                <td class="align-middle">@{{ value.email }}</td>
                                <td class="text-center align-middle">@{{ value.so_dien_thoai }}</td>
                                <td class="text-center align-middle">
                                    <a v-bind:href="value.facebook" target="_blank" class="text-center">
                                        <i class="fa-brands fa-facebook fa-3x" style="padding: 10px"></i>
                                    </a>
                                </td>
                                <td class="text-center align-middle">@{{ value.git_account }}</td>
                                <td class="text-center align-middle">@{{ date_format(value.ngay_sinh) }}</td>
                                <td class="text-center align-middle">@{{ date_format(value.ngay_bat_dau_lam) }}</td>
                                <td class="align-middle text-center">
                                    <button v-on:click="changeType(value)" v-if="value.is_open == 0" class="btn btn-warning">Tắt Hoạt Động</button>
                                    <button v-on:click="changeType(value)" v-else class="btn btn-success">Hoạt Động</button>
                                </td>
                                <td class="text-center align-middle">
                                    <button v-on:click="edit = Object.assign({}, value)" data-bs-toggle="modal" data-bs-target="#editNhanVien"
                                        class="btn btn-primary" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false"><i style="padding-left: 4px"
                                            class="fa-solid fa-pen"></i></button>
                                    <button v-on:click="destroy = value" data-bs-toggle="modal"
                                        data-bs-target="#deleteNhanVien" class="btn btn-danger" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false"><i style="padding-left: 4px"
                                            class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="modal fade" id="createNhanVien" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tạo Mới Nhân Viên</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="resetNhanVien">
                                    <div class="row">
                                        <div class="col">
                                            <label class="form-label">Họ Và Tên</label>
                                            <input v-model="add.ho_va_ten" type="text" class="form-control">
                                        </div>
                                        <div class="col">
                                            <label class="form-label">Tên Gợi Nhớ</label>
                                            <input v-model="add.ten_goi_nho" type="text" class="form-control">
                                        </div>
                                        <div class="col">
                                            <label class="form-label">Email</label>
                                            <input v-model="add.email" type="email" class="form-control" v-on:blur="checkEmail()">
                                            {{-- <small class="text-danger" name="message_email"><i></i></small> --}}
                                        </div>
                                        <div class="col">
                                            <label class="form-label">Mật Khẩu</label>
                                            <input v-model="add.password" type="password" class="form-control">
                                        </div>
                                        <div class="col">
                                            <label class="form-label">Tài Khoản Git</label>
                                            <input v-model="add.git_account" type="text" class="form-control">
                                        </div>
                                    </div>
                                </form>
                                    <div class="row mt-3">
                                        <div class="col">
                                            <label class="form-label">Facebook</label>
                                            <input v-model="add.facebook" type="text" class="form-control">
                                        </div>
                                        <div class="col">
                                            <label class="form-label">Số Điện Thoại</label>
                                            <input v-model="add.so_dien_thoai" type="tel" class="form-control">
                                        </div>
                                        <div class="col">
                                            <label class="form-label">Ngày Sinh</label>
                                            <input v-model="add.ngay_sinh" type="date" class="form-control">
                                        </div>
                                        <div class="col">
                                            <label class="form-label">Ngày Bắt Đầu Làm</label>
                                            <input v-model="add.ngay_bat_dau_lam" type="date" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button v-on:click="createNhanVien()" type="button" class="btn btn-primary">Tạo Mới
                                        Nhân Viên</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="editNhanVien" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Cập Nhật Nhân Viên</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <input type="hidden" v-model="edit.id">
                                        <div class="col">
                                            <label class="form-label">Họ Và Tên</label>
                                            <input v-model="edit.ho_va_ten" type="text" class="form-control">
                                        </div>
                                        <div class="col">
                                            <label class="form-label">Tên Gợi Nhớ</label>
                                            <input v-model="edit.ten_goi_nho" type="text" class="form-control">
                                        </div>
                                        <div class="col">
                                            <label class="form-label">Email</label>
                                            <input v-model="edit.email" type="email" class="form-control">
                                        </div>
                                        {{-- <div class="col">
                                            <label class="form-label">Mật Khẩu</label>
                                            <input id="password" type="password" class="form-control">
                                        </div> --}}
                                        <div class="col">
                                            <label class="form-label">Tài Khoản Git</label>
                                            <input v-model="edit.git_account" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col">
                                            <label class="form-label">Facebook</label>
                                            <input v-model="edit.facebook" type="text" class="form-control">
                                        </div>
                                        <div class="col">
                                            <label class="form-label">Số Điện Thoại</label>
                                            <input v-model="edit.so_dien_thoai" type="tel" class="form-control">
                                        </div>
                                        <div class="col">
                                            <label class="form-label">Ngày Sinh</label>
                                            <input v-model="edit.ngay_sinh" type="date" class="form-control">
                                        </div>
                                        <div class="col">
                                            <label class="form-label">Ngày Bắt Đầu Làm</label>
                                            <input v-model="edit.ngay_bat_dau_lam" type="date" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button v-on:click="updateNhanVien()" type="button" class="btn btn-primary">Cập Nhật
                                        Nhân Viên</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="deleteNhanVien" tabindex="-1" aria-hidden="true"
                        style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Xoá Nhân Viên</b></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Ban chắc chắn là sẽ xoá nhân viên <b class="text-danger">@{{ destroy.ho_va_ten }}</b>
                                    này!<br>
                                    <b>Lưu ý: Hành động này không thể khôi phục!</b>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button v-on:click="deleteNhanVien()" type="button" class="btn btn-primary">Xoá Nhân
                                        Viên</button>
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
                add: {},
                list: [],
                destroy: {},
                edit: {},
                message_email: '',
            },
            created() {
                this.loadData();
            },
            methods: {
                date_format(now) {
                    return moment(now).format('DD/MM/yyyy');
                },
                number_format(number, decimals = 2, dec_point = ",", thousands_sep = ".") {
                    var n = number,
                        c = isNaN((decimals = Math.abs(decimals))) ? 2 : decimals;
                    var d = dec_point == undefined ? "," : dec_point;
                    var t = thousands_sep == undefined ? "." : thousands_sep,
                        s = n < 0 ? "-" : "";
                    var i = parseInt((n = Math.abs(+n || 0).toFixed(c))) + "",
                        j = (j = i.length) > 3 ? j % 3 : 0;

                    return (s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (
                        c ? d +
                        Math.abs(n - i)
                        .toFixed(c)
                        .slice(2) :
                        ""));
                },
                createNhanVien() {
                    axios
                        .post('/admin/nhan-vien/create', this.add)
                        .then((res) => {
                            displaySuccess(res);
                            this.loadData();
                            $('#resetNhanVien').trigger('reset');
                            $('#createNhanVien').modal('hide');

                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
                },
                loadData() {
                    axios
                        .get('/admin/nhan-vien/data')
                        .then((res) => {
                            this.list = res.data.data;
                        });
                },
                deleteNhanVien() {
                    axios
                        .post('/admin/nhan-vien/delete', this.destroy)
                        .then((res) => {
                            displaySuccess(res);
                            this.loadData();
                            $('#deleteNhanVien').modal('hide');
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
                },
                updateNhanVien() {
                    this.edit.password = $('#password').val();
                    axios
                        .post('/admin/nhan-vien/update', this.edit)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success("Cập Nhật Nhân Viên Thành Công!");
                            }
                            this.loadData();
                            $('#editNhanVien').modal('hide');
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
                },
                changeType(x){
                    axios
                        .post('/admin/nhan-vien/change-status', x)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success("Thay Đổi Trạng Thái Thành Công!");
                            }
                            this.loadData();
                            // $('#editNhanVien').modal('hide');
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
                },
            }
        });
    </script>
@endsection
