@extends('admin.share.master')
@section('content')
<div class="row" id="app">
    <div class="card border-primary border-bottom border-3 border-0">
        <div class="card-header mt-3 mb-3">
            <div class="row">
                <div class="col mt-2">
                    <h6>Danh Sách Khoá Học</h6>
                </div>
                <div class="col text-end mb-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createKhoaHoc">Thêm Mới</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-drop">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Tên Khoá Học</th>
                            <th class="text-center">Tình Trạng</th>
                            <th class="text-center">Mô Tả Khóa Học</th>
                            <th class="text-center">Số Tháng Học</th>
                            <th class="text-center">Số Buổi Trong Tháng</th>
                            <th class="text-center">Học Phí 1 Tháng</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(value, index) in list" :key="index">
                            <th class="text-center align-middle">@{{ index + 1 }}</th>
                            <th class="text-center align-middle">@{{ value.ten_khoa_hoc }}</th>
                            <td class="text-center align-middle">
                                <button  v-on:click="status (value)" class="btn btn-primary" v-if="value.is_open == 1">Open</button>
                                <button  v-on:click="status (value)" class="btn btn-warning" v-else>Close</button>
                            </td>
                            <td class="text-center align-middle">
                                <button v-on:click="modal = value"  data-bs-toggle="modal" data-bs-target="#moTaKhoa" class="btn btn-primary"><i style="padding-left: 6px" class="fa-solid fa-info"></i></button>
                            </td>
                            <td class="text-center align-middle">@{{ value.so_thang_hoc }}</td>
                            <td class="text-center align-middle">@{{ value.so_buoi_trong_thang }}</td>
                            <td class="text-center align-middle">@{{ number_format(value.hoc_phi_theo_thang, 0, ',', '.') }}</td>
                            <td class="text-center align-middle">
                                <button v-on:click="edit = Object.assign({}, value)" data-bs-toggle="modal" data-bs-target="#editKhoaHoc" class="btn btn-primary" type="button" aria-expanded="false"><i style="padding-left: 4px" class="fa-solid fa-pen"></i></button>
                                <button v-on:click="destroy = value" data-bs-toggle="modal" data-bs-target="#deleteKhoaHoc" class="btn btn-danger" type="button" aria-expanded="false"><i style="padding-left: 4px" class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="modal fade" id="createKhoaHoc" tabindex="-1" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Thêm Mới Khoá Học</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col">
                                        <label class="form-label">Tên Khoá Học</label>
                                        <input type="text" v-model="add.ten_khoa_hoc" class="form-control" placeholder="Nhập tên khóa học">
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Tình Trạng</label>
                                        <select v-model="add.is_open" class="form-select">
                                            <option value="1">Open</option>
                                            <option value="0">Close</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <label class="form-label">Mô Tả Khoá Học</label>
                                        <textarea v-model="add.mo_ta_khoa" class="form-control" placeholder="Nhập mô tả" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <label class="form-label">Số Tháng Học</label>
                                        <input v-model="add.so_thang_hoc" type="number" class="form-control" min="1" max="5">
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Số Buổi Trong Tháng</label>
                                        <input v-model="add.so_buoi_trong_thang" type="number" class="form-control" min="5" max="20">
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Học Phí 1 Tháng</label>
                                        <input  v-model="add.hoc_phi_theo_thang" type="number" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button v-on:click="createKhoaHoc()" type="button" class="btn btn-primary">Tạo Mới Khoá Học</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="deleteKhoaHoc" tabindex="-1" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Xoá Khoá Học</b></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Chắc chắn là sẽ xoá khoá học <b class="text-danger">"@{{ destroy.ten_khoa_hoc }}"</b> này!!!
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button v-on:click="deleteKhoaHoc()" type="button" class="btn btn-danger" data-bs-dismiss="modal">Xoá Khoá Học</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="editKhoaHoc" tabindex="-1" aria-hidden="true" style="display: none;">
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
                                        <label class="form-label">Tên Khoá Học</label>
                                        <input type="text" v-model="edit.ten_khoa_hoc" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Tình Trạng</label>
                                        <select v-model="edit.is_open" class="form-select">
                                            <option value="1">Open</option>
                                            <option value="0">Close</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <label class="form-label">Mô Tả Khoá Học</label>
                                        <textarea v-model="edit.mo_ta_khoa" class="form-control" placeholder="Mô tả khóa học." rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <label class="form-label">Số Tháng Học</label>
                                        <input v-model="edit.so_thang_hoc" type="number" class="form-control" min="1" max="5">
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Số Buổi Trong Tháng</label>
                                        <input v-model="edit.so_buoi_trong_thang" type="number" class="form-control" min="5" max="20">
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Học Phí 1 Tháng</label>
                                        <input  v-model="edit.hoc_phi_theo_thang" type="number" class="form-control">
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
                <div class="modal fade" id="moTaKhoa" tabindex="-1" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Mô Tả Khóa Học</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <textarea disabled class="form-control" cols="30" rows="10">
                                    @{{ modal.mo_ta_khoa }}
                                </textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    Vue.use(VueMask.VueMaskPlugin);
    new Vue({
        el      :  '#app',
        data    :  {
            add                 :   {},
            list                :   [],
            destroy             :   {},
            edit                :   {},
            modal               :   {},
        },
        created() {
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
            createKhoaHoc() {
                axios
                    .post('/admin/khoa-hoc/create', this.add)
                    .then((res) => {
                        displaySuccess(res);
                        $('#createKhoaHoc').modal('hide');
                        this.loadData();
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },
            loadData() {
                axios
                    .get('/admin/khoa-hoc/data')
                    .then((res) => {
                        this.list = res.data.data;
                    });
            },
            deleteKhoaHoc() {
                axios
                    .post('/admin/khoa-hoc/delete', this.destroy)
                    .then((res) => {
                        displaySuccess(res);
                        this.loadData();
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },
            updateKhoaHoc() {
                axios
                    .post('/admin/khoa-hoc/update', this.edit)
                    .then((res) => {
                        displaySuccess(res);
                        $('#editKhoaHoc').modal('hide');
                        this.loadData();
                    })
                    .catch((err) => {
                        displayErrors(err);
                        this.loadData();
                    });
            },
            status(value) {
                value.is_open = !value.is_open;
                console.log(value.is_open);
                axios
                    .post('/admin/khoa-hoc/update', value)
                    .then((res) => {
                        displaySuccess(res);
                        this.loadData();
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },
        }
    });
</script>
@endsection
