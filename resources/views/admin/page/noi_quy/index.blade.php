@extends('admin.share.master')
@section('content')
    <div class="row" id="app">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <b>Thêm Mới Nội Quy</b>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label">Nội Dung</label>
                            <textarea v-model="add.noi_dung" name="" id="" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" v-on:click="themMoi()">Thêm Mới</button>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <b>Danh Sách Nội Quy</b>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered ">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Nội Quy</th>
                                    <th>Tình Trạng</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(value, index) in list">
                                    <th class="text-center align-middle">@{{ index + 1 }}</th>
                                    <td class="align-middle">@{{ wrapText(value.noi_dung) }}</td>
                                    <td class="text-center align-middle">
                                        <button v-if="value.tinh_trang == 1" class="btn btn-success">Mở</button>
                                        <button v-else class="btn btn-danger">Đóng</button>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button class="btn btn-primary" v-on:click="detail = Object.assign({}, value)"
                                            data-bs-toggle="modal" data-bs-target="#updateLink">Cập Nhập</button>
                                        <button class="btn btn-danger" v-on:click="detail = Object.assign({}, value)"
                                            data-bs-toggle="modal" data-bs-target="#deleteLinkModel">Xóa</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal fade" id="updateLink" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Cập Nhập Nội Quy</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-label">Nội Dung</label>
                                            <textarea v-model="detail.noi_dung" name="" id="" cols="30" rows="10" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    <button v-on:click="update()" type="button" class="btn btn-primary">Cập Nhập</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Delete --}}
                    <div class="modal fade" id="deleteLinkModel" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Xóa Link Driver</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Bạn Có chắc chắn muốn xóa Link Driver Chức Năng này!</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    <button v-on:click="destroy()" type="button" class="btn btn-danger">Xóa</button>
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
                detail: {},
                list: [],
            },
            created() {
                this.loadData();
            },
            methods: {
                loadData() {
                    axios
                        .get('/admin/noi-quy/data')
                        .then((res) => {
                            this.list = res.data.data;
                        });
                },

                themMoi() {
                    axios
                        .post('/admin/noi-quy/create', this.add)
                        .then((res) => {
                            displaySuccess(res);
                            this.add = {},
                                this.loadData();
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
                },

                update() {
                    axios
                        .post('/admin/noi-quy/update', this.link_detail)
                        .then((res) => {
                            displaySuccess(res);
                            this.link_detail = {},
                                this.loadData();
                            $("#updateLink").modal('hide');
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
                },

                destroy() {
                    axios
                        .post('/admin/noi-quy/delete', this.link_detail)
                        .then((res) => {
                            displaySuccess(res);
                            this.link_detail = {},
                                this.loadData();
                            $("#deleteLinkModel").modal('hide');
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
                },

                wrapText(content) {
                    const words = content.split(' '); // Tách nội dung thành các từ
                    let result = '';
                    let count = 0;

                    for (const word of words) {
                        result += word + ' '; // Thêm từ vào kết quả
                        count++;

                        if (count === 20) {
                            result += '<br>'; // Thêm thẻ xuống dòng sau mỗi 20 từ
                            count = 0;
                        }
                    }

                    return result;
                }
            }
        });
    </script>
@endsection
