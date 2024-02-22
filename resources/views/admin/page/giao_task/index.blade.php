@extends('admin.share.master')
@section('content')
    <div class="row" id="app">
        <div class="card border-primary border-bottom border-3 border-0">
            <div class="card-header mt-3 mb-3">
                <div class="row">
                    <div class="col-md-10 mt-2">
                        <h6>Danh Sách Task được giao</h6>
                    </div>
                    <div class="col-md-2 mt-2 text-end">
                        <button class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#createTask">Thêm mới
                            Task</button>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <div class="input-group">
                            <input v-model="search.begin" class="form-control" type="date"
                                name="search" placeholder="Search now...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <input v-model="search.end" class="form-control" type="date"
                                name="search" placeholder="Search now...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select v-model="search.loai" class="form-control">
                            <option value="0">Deadline</option>
                            <option value="1">Giao Task</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-2">
                                <button  class="btn btn-success input-group-text" v-on:click="searchTasks()">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-drop">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Người giao task</th>
                                <th class="text-center">Người nhận task</th>
                                <th class="text-center">Task</th>
                                <th class="text-center">Thời Gian Giao Task</th>
                                <th class="text-center">Deadline</th>
                                <th class="text-center">Tình Trạng</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(value, index) in list">
                                <tr>
                                    <th class="text-center align-middle">@{{ index + 1 }}</th>
                                    <td class="align-middle">@{{ value.nguoi_giao }}</td>
                                    <td class="align-middle">@{{ value.list_name_nhan }}</td>
                                    <td class="align-middle">@{{ value.tieu_de }}</td>
                                    <td class="text-center align-middle">@{{ value.thoi_gian_nhan_task }}</td>
                                    <td class="text-center align-middle">@{{ value.deadline_task }}</td>
                                    <td class="align-middle text-center">
                                        <button v-if="value.tinh_trang == 0" class="btn btn-warning text-white"
                                            v-on:click="status (value)">Chưa Hoàn Thành</button>
                                        <button v-else class="btn btn-success text-nowrap" v-on:click="status (value)">Đã
                                            Hoàn Thành</button>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button v-on:click="edit = value; convertListNhan()" data-bs-toggle="modal"
                                            data-bs-target="#updateModal" class="btn btn-info"><i
                                                class="fa-solid fa-gear text-white" style="padding-left: 4px;"></i></button>
                                        <button v-on:click="del = value" class="btn btn-danger ml-1" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"><i class="fa-solid fa-trash"
                                                style="padding-left: 4px;"></i></button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                    <div class="modal fade" id="createTask" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Giao Task</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Người Giao Task</label>
                                            <select class="form-control" v-model="add.id_giao">
                                                @foreach ($nhanVien as $key => $value)
                                                    <option value="{{ $value->id }}">{{ $value->ho_va_ten }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Nhân Viên Nhận Task</label>
                                            <div class="row">
                                                @foreach ($nhanVien as $key => $value)
                                                    <div class="col-md-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                v-model="array_id_nhan_vien" value="{{ $value->id }}"
                                                                required="">
                                                            <label class="form-check-label">{{ $value->ho_va_ten }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label class="form-label">Tiêu Đề</label>
                                            <textarea v-model="add.tieu_de" type="text" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label class="form-label">Nội Dung</label>
                                            <textarea v-model="add.noi_dung" class="form-control" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Ngày Nhận Task</label>
                                            <input v-model="add.thoi_gian_nhan" type="datetime-local"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Hạn Deadline</label>
                                            <input v-model="add.deadline" type="datetime-local" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Số Ngày Lặp</label>
                                            <select class="form-control" v-model="add.so_ngay_lap">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Số Lần Lặp</label>
                                            <input v-model="add.so_lan_lap" type="number" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button v-on:click="Add()" type="button" class="btn btn-primary">Thêm
                                        Mới</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog sm-down">
                            <div class="modal-content">
                                <div class="modal-header text-wrap">
                                    <h5 class="modal-title">Bạn có muốn xóa <b
                                            class="text-danger">"@{{ del.tieu_de }}"</b> này ?</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Bạn có chắc chắn xóa bỏ task <b class="text-danger">"@{{ del.tieu_de }}"</b> này ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button v-on:click="deleteTask()" type="button" class="btn btn-danger">Xóa
                                        bỏ</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Cập Nhật Giao Task</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Người Giao Task</label>
                                            <select class="form-control" v-model="edit.id_giao">
                                                @foreach ($nhanVien as $key => $value)
                                                    <option value="{{ $value->id }}">{{ $value->ho_va_ten }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Nhân Viên Nhận Task</label>
                                            <div class="row">
                                                @foreach ($nhanVien as $key => $value)
                                                    <div class="col-md-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                v-model="edit.list_nhan" value="{{ $value->id }}"
                                                                required="">
                                                            <label class="form-check-label">{{ $value->ho_va_ten }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label class="form-label">Tiêu Đề</label>
                                            <textarea v-model="edit.tieu_de" type="text" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label class="form-label">Nội Dung</label>
                                            <textarea v-model="edit.noi_dung" class="form-control" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Ngày Nhận Task</label>
                                            <input v-model="edit.thoi_gian_nhan" type="datetime-local"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Hạn Deadline</label>
                                            <input v-model="edit.deadline" type="datetime-local" class="form-control">
                                        </div>
                                    </div>

                                    {{-- <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Số Ngày Lặp</label>
                                            <select class="form-control" v-model="edit.so_ngay_lap">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Số Lần Lặp</label>
                                            <input v-model="edit.so_lan_lap" type="number" class="form-control">
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button v-on:click="updateTask($event)" type="button" class="btn btn-primary">Cập
                                        Nhật</button>
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
        $(document).ready(function() {
            new Vue({
                el: '#app',
                data: {
                    add: {
                        'id_giao': {!! Auth::guard('nhanVien')->user()->id !!},
                        'thoi_gian_nhan': moment().format("YYYY-MM-DD HH:mm:ss"),
                        'so_ngay_lap': 1,
                        'so_lan_lap': 1,
                    },
                    list: [],
                    del: {},
                    edit: {},
                    modal: {},
                    file: '',
                    search: {},
                    array_id_nhan_vien: [],
                },
                created() {
                    this.loadData();
                },
                methods: {
                    getFile(e) {
                        this.file = e.target.files[0];
                    },
                    convertListNhan() {
                        this.edit.list_nhan = this.edit.list_nhan.split(",");
                    },
                    loadData() {
                        axios
                            .get('/admin/tasks/data')
                            .then((res) => {
                                this.list = res.data.data;
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },
                    Add() {
                        this.add.list_nhan = this.array_id_nhan_vien;
                        axios
                            .post('/admin/tasks/create', this.add)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message);
                                    $('#createTask').modal('hide');
                                    this.add = {
                                        'id_giao': {!! Auth::guard('nhanVien')->user()->id !!},
                                        'thoi_gian_nhan': moment().format("YYYY-MM-DD HH:mm:ss"),
                                        'so_ngay_lap': 1,
                                        'so_lan_lap': 1,
                                    };
                                    this.array_id_nhan_vien = [];
                                    this.loadData();
                                } else {
                                    toastr.error(res.data.message);
                                    $('#createTask').modal('hide');
                                    this.loadData();
                                }
                            })
                            .catch((err) => {
                                displayErrors(err);
                            });
                    },
                    deleteTask() {
                        axios
                            .post('/admin/tasks/delete', this.del)
                            .then((res) => {
                                displaySuccess(res);
                                $('#deleteModal').modal('hide');
                                this.loadData();
                            })
                            .catch((err) => {
                                displayErrors(err);
                            });
                    },
                    updateTask(e) {
                        axios
                            .post('/admin/tasks/update', this.edit)
                            .then((res) => {
                                displaySuccess(res);
                                $('#updateModal').modal('hide');
                                this.loadData();
                            })
                            .catch((err) => {
                                displayErrors(err);
                                this.loadData();
                            });
                    },
                    status(value) {
                        axios
                            .post('/admin/tasks/status', value)
                            .then((res) => {
                                displaySuccess(res);
                                this.loadData();
                            })
                            .catch((err) => {
                                displayErrors(err);
                            });
                    },
                    searchTasks(){
                        axios
                            .post('/admin/tasks/search', this.search)
                            .then((res) => {
                                this.list = res.data.data;
                                // this.loadData();
                            })
                            .catch((err) => {
                                displayErrors(err);
                            });
                    }
                },
            });
        });
    </script>
@endsection
