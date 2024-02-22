@extends('admin.share.master')
@section('content')
    <div id="app" class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <b>Thông Tin Mail</b>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-12 ">
                                <label class="form-label">Họ Và Tên</label>
                                <input v-model="add.full_name" type="text" class="form-control" placeholder="Nhập đầy đủ họ tên">
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="form-label">Email</label>
                                <input v-model="add.email" type="email" class="form-control" placeholder="Nhập email tạo">
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="form-label">Email Khôi Phục</label>
                                <input v-model="add.email_khoi_phuc" type="email" class="form-control" placeholder="Nhập email tạo">
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="form-label">Password</label>
                                <input v-model="add.password" type="text" class="form-control" placeholder="Nhập password của mail">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" v-on:click="addMail" type="button">Nhập Mail</button>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    {{-- <select class="form-control">
                        <option value="1">2</option>
                        <option value="1">x</option>
                    </select> --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-drop">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle" colspan="1">
                                        Chọn Người Tạo
                                    </th>
                                    <td colspan="2">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <select class="form-control" v-on:change="loadData()" v-model="id_nhan_vien">
                                                    <option value="0">Tất Cả</option>
                                                    <template v-for="(v, k) in list_nv">
                                                        <option v-if="v.is_open == 1" v-bind:value="v.id">@{{ v.ho_va_ten }}</option>
                                                    </template>
                                                </select>
                                            </div>
                                        </div>
                                    </td>
                                    <td colspan="3" class="align-middle">
                                        <b>Tổng email:</b> @{{ list.length }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-center">Nhân Viên Tạo</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Tên Email</th>
                                    <th class="text-center">Tình Trạng Mail</th>
                                    <th class="text-center">Tình Trạng Review</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(value, index) in list" :key="index">
                                    <td class="align-middle">@{{ value.ho_va_ten }}</td>
                                    <td class="align-middle" data-bs-toggle="modal" data-bs-target="#chitietmail" v-on:click="chitietMail = value">@{{ value.email }}</td>
                                    <td class="text-center align-middle">@{{ value.full_name }}</td>
                                    <td class="text-center align-middle">
                                        <button v-on:click="doiTrangThai(value, 1)" v-if="value.is_die == 1" class="btn btn-success">Còn Sống</button>
                                        <button v-on:click="doiTrangThai(value, 1)" v-else class="btn btn-danger">Đã Chết</button>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button v-on:click="doiTrangThai(value, 2)" v-if="value.is_review == 0" class="btn btn-primary">Chưa Review</button>
                                        <button v-on:click="doiTrangThai(value, 2)" v-else-if="value.is_review == 1" class="btn btn-success">Đã Review Lên</button>
                                        <button v-on:click="doiTrangThai(value, 2)" v-else class="btn btn-danger">Đã Review Không Lên</button>
                                    </td>
                                    <td class="text-center align-middle">
                                        {{-- <button class="btn btn-primary" v-on:click="edit = value" data-bs-toggle="modal" data-bs-target="#updateFarm" >Up Farm</button> --}}
                                        <button class="btn btn-primary" v-on:click="edit = value" data-bs-toggle="modal" data-bs-target="#editTools" >Cập Nhật</button>
                                        <button class="btn btn-danger" v-on:click="del = value" data-bs-toggle="modal" data-bs-target="#deleteTools" >Xóa</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="modal fade" id="editTools" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Cập Nhật Mail</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" v-model="edit.id" >
                                        <div class="col-md-12 mt-2">
                                            <label class="form-label">Họ Và Tên</label>
                                            <input v-model="edit.full_name" type="text" class="form-control" placeholder="Nhập đầy đủ họ tên">
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <label class="form-label">Email</label>
                                            <input v-model="edit.email" type="email" class="form-control" placeholder="Nhập email tạo">
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <label class="form-label">Email Khôi Phục</label>
                                            <input v-model="edit.email_khoi_phuc" type="email" class="form-control" placeholder="Nhập email tạo">
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <label class="form-label">Password</label>
                                            <input v-model="edit.password" type="text" class="form-control" placeholder="Nhập password của mail">
                                        </div>
                                        {{-- <div class="col-md-12 mt-2">
                                            <label class="form-label">Ngày Tháng Năm Sinh</label>
                                            <input v-model="edit.dob" type="date" class="form-control">
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <label class="form-label">Số Điện Thoại</label>
                                            <input v-model="edit.phone" type="text" class="form-control" placeholder="Nhập số điện thoại dùng để đăng ký">
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <label class="form-label">Giới Tính</label>
                                            <select v-model="edit.sex" class="form-control">
                                                <option value="1">Nam</option>
                                                <option value="0">Nữ</option>
                                                <option value="2">Khác</option>
                                                <option value="3">Không Khai Báo</option>
                                            </select>
                                        </div> --}}
                                        <div class="col-md-12 mt-2">
                                            <label class="form-label">Người cập nhật</label>
                                            <select v-model="edit.id_nhan_vien" class="form-control">
                                                <template v-for="(value, key) in list_nv">
                                                    <option v-if="value.is_open == 1" v-bind:value="value.id">@{{value.ho_va_ten}}</option>
                                                </template>
                                            </select>
                                        </div>
                                        {{-- <div class="col-md-12 mt-2">
                                            <label class="form-label">Token Phone</label>
                                            <input v-model="edit.token_phone" type="text" class="form-control" placeholder="Nhập số điện thoại dùng để đăng ký">
                                        </div> --}}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                                        <button v-on:click="updateMail()" type="button" class="btn btn-primary">Cập Nhật</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="deleteTools" tabindex="-1" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Xóa Mail</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Ban chắc chắn xoá mail <b class="text-danger">@{{ del.email }}</b>
                                        này!<br>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                                        <button v-on:click="deleteMail()" type="button" class="btn btn-primary">Xóa</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="chitietmail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Chi Tiết Mail: @{{ chitietMail.email }}</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <p>Email khôi phục: @{{ chitietMail.email_khoi_phuc }}</p>
                                  <p>Password: @{{ chitietMail.password }}</p>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="modal fade" id="updateFarm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Cập Nhật Ngày Farm</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <label>Chọn Ngày</label>
                                    <input type="date" v-model="edit.ngay_farm" class="form-control">
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-primary" v-on:click="updateMail()">Cập Nhật</button>
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
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
            add         : {},
            list        : [],
            list_nv     : [],
            edit        : {},
            del         : {},
            chitietMail : {},
            id_nhan_vien : 0,
        },
        created() {
            this.loadData(0);
            this.loadNhanVien();
        },
        methods :   {
            date_format(now) {
                    return moment(now).format('DD/MM/yyyy');
            },
            doiTrangThai(v, number){
                v.check = number;
                axios
                    .post('/admin/tools/doi-trang-thai', v)
                    .then((res) => {
                        displaySuccess(res);
                        this.loadData();
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },

            addMail() {
                axios
                    .post('/admin/tools/create-mail',this.add)
                    .then((res) => {
                        displaySuccess(res);
                        this.add = {};
                        this.loadData();
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },
            loadData() {
                var id = this.id_nhan_vien;
                axios
                    .get('/admin/tools/get-mail/' + id)
                    .then((res) => {
                        this.list = res.data.data;
                    });
            },
            updateMail() {
                axios
                    .post('/admin/tools/update-mail', this.edit)
                    .then((res) => {
                        if(res.data.status){
                            this.loadData();
                            $('#editTools').modal('hide');
                            $('#updateFarm').modal('hide');
                        }
                        displaySuccess(res);
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },
            deleteMail() {
                axios
                    .post('/admin/tools/del-mail', this.del)
                    .then((res) => {
                        displaySuccess(res);
                        this.loadData();
                        $('#deleteTools').modal('hide');
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },

            loadNhanVien() {
                axios
                    .get('/admin/nhan-vien/data')
                    .then((res) => {
                        this.list_nv = res.data.data;
                        console.log(this.list_nv);
                    });
            },
        },
    });
    </script>
@endsection
