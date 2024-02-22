@extends('admin.share.master')
@section('content')
<div class="row" id="app">
    <div class="card border-primary border-bottom border-3 border-0">
        <div class="card-header mt-3 mb-3">
            <div class="row">
                <div class="col mt-2">
                    <h6>Danh Sách Lớp Học</h6>
                </div>
                <div class="col text-end mb-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createLopHoc">Thêm Mới</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-drop">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Tên lớp học</th>
                            <th class="text-center">Khóa học</th>
                            <th class="text-center">Giáo viên</th>
                            <th class="text-center">Ngày bắt đầu học</th>
                            <th class="text-center">Trạng thái</th>
                            <th class="text-center">Kết Thúc Khóa</th>
                            <th class="text-center">Buổi Học</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(value, index) in list" :key="index">
                            <th class="text-center align-middle">@{{ index + 1 }}</th>
                            <th class="align-middle">@{{ value.ten_lop_hoc }}</th>
                            <td class="align-middle">@{{  value.ten_khoa_hoc }}</td>
                            <td class="align-middle">@{{  value.ten_giao_vien }}</td>
                            <td class="text-center align-middle">@{{  date_format(value.ngay_bat_dau_hoc) }}</td>
                            <td class="text-center align-middle">
                                <button class="btn btn-success" v-if="value.is_mo_dang_ky == 1" v-on:click="status(value)">Open</button>
                                <button class="btn btn-warning" v-else v-on:click="status(value)">Close</button>
                            </td>
                            <td class="text-center align-middle">
                                <button class="btn btn-danger" v-if="value.is_done == 1" v-on:click="statusDone(value)">Đã Kết Thúc</button>
                                <template v-else>
                                    <button class="btn btn-success" v-if="value.check_end" v-on:click="statusDone(value)">Done</button>
                                    <button class="btn btn-success" v-else disabled>Done</button>
                                </template>
                            </td>
                            <td class="text-center align-middle">
                                <a class="btn btn-primary"  v-bind:href="'/admin/buoi-hoc/' + value.id">Buổi Học</a>
                            </td>
                            <td class="text-center align-middle text-nowrap" style="width: 200px;">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-edit" style="margin-left: 20%;"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" v-on:click="xulyThuUpdate(edit = Object.assign({}, value))" data-bs-toggle="modal" data-bs-target="#editLopHoc">Cập Nhật</a></li>
                                        <li><a class="dropdown-item" v-on:click="loadDataBuoiHoc(value.id)" data-bs-toggle="modal" data-bs-target="#doiBuoiHoc">Dời Buổi Học</a></li>
                                        <li><a class="dropdown-item" v-bind:href="value.link_facebook_lop" target="_blank">Facebook</a></li>
                                        <li><a class="dropdown-item" v-bind:href="value.link_zalo_lop" target="_blank">Zalo</a></li>
                                        <li><a class="dropdown-item"  v-bind:href="value.link_driver_lop_hoc" target="_blank" >Driver</a></li>
                                        <li><a class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#motaLopHoc" v-on:click="edit = Object.assign({}, value)">Mô Tả</a></li>
                                        <li><a class="dropdown-item"  v-on:click="destroy = value" data-bs-toggle="modal" data-bs-target="#deleteLopHoc" >Xóa</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="modal fade" id="createLopHoc" tabindex="-1" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Thêm Mới Lớp Học</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col">
                                        <label class="form-label">Tên Lớp Học</label>
                                        <input type="text" v-model="add.ten_lop_hoc" class="form-control">
                                    </div>

                                    <div class="col">
                                        <label class="form-label">Ngày bắt đầu học</label>
                                        <input type="date" v-model="add.ngay_bat_dau_hoc" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Giờ bắt đầu</label>
                                        <input type="time" v-model="add.gio_bat_dau" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Giờ kết thúc</label>
                                        <input type="time" v-model="add.gio_ket_thuc" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Tình Trạng</label>
                                        <select v-model="add.is_mo_dang_ky = 1" class="form-select">
                                            <option value="1">Open</option>
                                            <option value="0">Close</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <label class="form-label">Chọn khóa học</label>
                                        <select class="form-select" v-model="add.id_khoa_hoc">
                                            <template v-for="(value, index) in list_khoa_hoc">
                                                <option v-bind:value="value.id">@{{value.ten_khoa_hoc}}</option>
                                            </template>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Chọn giáo viên</label>
                                        <select class="form-select" v-model="add.id_nhan_vien_day">
                                            <template v-for="(value, index) in list_nhan_vien">
                                                <option v-bind:value="value.id">@{{value.ho_va_ten}}</option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <label class="form-label">Link driver lớp</label>
                                        <input type="text" v-model="add.link_driver_lop_hoc" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Link zalo lớp</label>
                                        <input type="text" v-model="add.link_zalo_lop" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Link facebook lớp</label>
                                        <input type="text" v-model="add.link_facebook_lop" class="form-control">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <label class="form-label">Mô tả lớp học</label>
                                        <textarea class="form-control" v-model="add.mo_ta_khoa" rows="3"></textarea>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Thứ trong tuần</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" v-model="thu_trong_tuan" type="checkbox" value="2" id="defaultCheck2">
                                                    <label class="form-check-label" for="defaultCheck2">Thứ 2</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" v-model="thu_trong_tuan" type="checkbox" value="3" id="defaultCheck3">
                                                    <label class="form-check-label" for="defaultCheck3">Thứ 3</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" v-model="thu_trong_tuan" type="checkbox" value="4" id="defaultCheck4">
                                                    <label class="form-check-label" for="defaultCheck4">Thứ 4</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" v-model="thu_trong_tuan" type="checkbox" value="5" id="defaultCheck5">
                                                    <label class="form-check-label" for="defaultCheck5">Thứ 5</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" v-model="thu_trong_tuan" type="checkbox" value="6" id="defaultCheck6">
                                                    <label class="form-check-label" for="defaultCheck6">Thứ 6</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" v-model="thu_trong_tuan" type="checkbox" value="7" id="defaultCheck7">
                                                    <label class="form-check-label" for="defaultCheck7">Thứ 7</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"  v-model="thu_trong_tuan" value="8" id="defaultCheck8">
                                                    <label class="form-check-label" for="defaultCheck8">Chủ nhật</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button v-on:click="createLopHoc()" type="button" class="btn btn-primary">Thêm Mới Lớp Học</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="deleteLopHoc" tabindex="-1" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Xoá Lớp Học</b></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Chắc chắn là sẽ xoá lớp học <b class="text-danger">"@{{ destroy.ten_lop_hoc }}"</b> này!!!
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button v-on:click="deleteLopHoc()" type="button" class="btn btn-danger">Xoá Lớp Học</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="editLopHoc" tabindex="-1" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Thêm Mới Khoá Học</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" v-model="edit.id">
                                <div class="row">
                                    <div class="col">
                                        <label class="form-label">Tên Lớp Học</label>
                                        <input type="text" v-model="edit.ten_lop_hoc" class="form-control">
                                    </div>

                                    <div class="col">
                                        <label class="form-label">Ngày bắt đầu học</label>
                                        <input type="date" v-model="edit.ngay_bat_dau_hoc" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Giờ bắt đầu</label>
                                        <input type="time" v-model="edit.gio_bat_dau" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Giờ kết thúc</label>
                                        <input type="time" v-model="edit.gio_ket_thuc" class="form-control">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <label class="form-label">Chọn khóa học</label>
                                        <select class="form-select" v-model="edit.id_khoa_hoc">
                                            <template v-for="(value, index) in list_khoa_hoc">
                                                <option v-bind:value="value.id">@{{value.ten_khoa_hoc}}</option>
                                            </template>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Chọn giáo viên</label>
                                        <select class="form-select" v-model="edit.id_nhan_vien_day">
                                            <template v-for="(value, index) in list_nhan_vien">
                                                <option v-bind:value="value.id">@{{value.ho_va_ten}}</option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <label class="form-label">Link driver lớp</label>
                                        <input type="text" v-model="edit.link_driver_lop_hoc" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Link zalo lớp</label>
                                        <input type="text" v-model="edit.link_zalo_lop" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Link facebook lớp</label>
                                        <input type="text" v-model="edit.link_facebook_lop" class="form-control">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <label class="form-label">Mô tả lớp học</label>
                                        <textarea class="form-control" v-model="edit.mo_ta_khoa" rows="3"></textarea>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Thứ trong tuần</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" v-model="thu_trong_tuan" type="checkbox" value="2" id="defaultCheck2">
                                                    <label class="form-check-label" for="defaultCheck2">Thứ 2</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" v-model="thu_trong_tuan" type="checkbox" value="3" id="defaultCheck3">
                                                    <label class="form-check-label" for="defaultCheck3">Thứ 3</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" v-model="thu_trong_tuan" type="checkbox" value="4" id="defaultCheck4">
                                                    <label class="form-check-label" for="defaultCheck4">Thứ 4</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" v-model="thu_trong_tuan" type="checkbox" value="5" id="defaultCheck5">
                                                    <label class="form-check-label" for="defaultCheck5">Thứ 5</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" v-model="thu_trong_tuan" type="checkbox" value="6" id="defaultCheck6">
                                                    <label class="form-check-label" for="defaultCheck6">Thứ 6</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" v-model="thu_trong_tuan" type="checkbox" value="7" id="defaultCheck7">
                                                    <label class="form-check-label" for="defaultCheck7">Thứ 7</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"  v-model="thu_trong_tuan" value="8" id="defaultCheck8">
                                                    <label class="form-check-label" for="defaultCheck8">Chủ nhật</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button v-on:click="updateKhoaHoc()" type="button" class="btn btn-primary">Cập Nhật Khoá Học</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="motaLopHoc" tabindex="-1" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Mô Tả Lớp Học</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @{{edit.mo_ta_khoa}}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="doiBuoiHoc" tabindex="-1" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Dời buổi học khóa @{{doiBuoiHoc.ten_lop_hoc}}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="">Buổi Bắt Đầu Dời</label>
                                    <select class="form-control mt-3" v-model="doiBuoiHoc.id_buoi_doi">
                                        <template v-for="(value, index) in listBuoiHoc">
                                            <option v-bind:value="value.id">Buổi @{{ value.thu_tu_buoi_khoa_hoc }} - Ngày : @{{ value.end }}</option>
                                        </template>
                                    </select>
                                    {{-- <input v-model="doiBuoiHoc.ngay_bat_dau_doi" class="form-control mt-3" type="date"> --}}
                                </div>
                                <div class="mb-3">
                                    <label for="">Ngày Bắt Đầu Học Lại</label>
                                    <input v-model="doiBuoiHoc.ngay_bat_dau_di_hoc_lai" class="form-control mt-3" type="date">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button v-on:click="DoiBuoiHoc()" type="button" class="btn btn-primary">Cập Nhật Khoá Học</button>
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
            add                 :   {},
            thu_trong_tuan      :   [],
            list_khoa_hoc       :   [],
            list_nhan_vien      :   [],
            list                :   [],
            edit                :   {},
            destroy             :   {},
            doiBuoiHoc          :   {},
            listBuoiHoc         :   [],

        },
        created() {
            this.getKhoaVaNhanVien();
            this.loadData();
        },
        methods :   {
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

                return (s +(j ? i.substr(0, j) + t : "") +i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) +(c? d +
                        Math.abs(n - i)
                            .toFixed(c)
                            .slice(2)
                        : "")
                );
            },
            createLopHoc(){
                this.add.thu_trong_tuan = this.thu_trong_tuan.toString();
                axios
                    .post('/admin/lop-hoc/create', this.add)
                    .then((res) => {
                        console.log(res.data);
                        if(res.data.status) {
                            displaySuccess(res);
                            $('#createLopHoc').modal('hide');
                            this.loadData();
                        } else {
                            displaySuccess(res);
                        }
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },
            getKhoaVaNhanVien(){
                axios
                    .get('/admin/khoa-hoc/data')
                    .then((res) => {
                        this.list_khoa_hoc = res.data.data;
                });

                axios
                    .get('/admin/nhan-vien/data')
                    .then((res) => {
                        this.list_nhan_vien = res.data.data;
                });
            },
            loadData() {
                axios
                    .get('/admin/lop-hoc/data')
                    .then((res) => {
                        this.list = res.data.data;
                    });
            },

            loadDataBuoiHoc(id) {
                axios
                    .get('/admin/buoi-hoc/data/' + id)
                    .then((res) => {
                        this.listBuoiHoc = res.data.list;
                    });
            },

            deleteLopHoc() {
                axios
                    .post('/admin/lop-hoc/delete', this.destroy)
                    .then((res) => {
                        displaySuccess(res);
                        $('#deleteLopHoc').modal('hide');
                        this.loadData();
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },
            xulyThuUpdate(edit){
                this.thu_trong_tuan = this.edit.thu_trong_tuan.split(',');
            },
            updateKhoaHoc(){
                this.edit.thu_trong_tuan = this.thu_trong_tuan.toString();
                console.log(this.edit);
                axios
                    .post('/admin/lop-hoc/update', this.edit)
                    .then((res) => {
                        displaySuccess(res);
                        $('#editLopHoc').modal('hide');
                        this.loadData();
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },
            status(value) {
                value.is_mo_dang_ky = !value.is_mo_dang_ky;
                axios
                    .post('/admin/lop-hoc/update-trang-thai', value)
                    .then((res) => {
                        displaySuccess(res);
                        this.loadData();
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },
            statusDone(value) {
                value.is_done = !value.is_done;
                axios
                    .post('/admin/lop-hoc/update-trang-thai', value)
                    .then((res) => {
                        displaySuccess(res);
                        this.loadData();
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },
            DoiBuoiHoc() {
                console.log(this.doiBuoiHoc);
                axios
                    .post('/admin/lop-hoc/doi-buoi-hoc', this.doiBuoiHoc)
                    .then((res) => {
                        displaySuccess(res);
                        $('#doiBuoiHoc').modal('hide');
                        this.doiBuoiHoc = {};
                    })
                    .catch((res) => {
                        $.each(res.response.data.errors, function(k, v) {
                            toastr.error(v[0]);
                        });
                    });
            }
        }
    });
</script>
@endsection
