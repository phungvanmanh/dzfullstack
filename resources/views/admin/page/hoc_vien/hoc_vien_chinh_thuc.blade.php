@extends('admin.share.master')
@section('content')
    <div class="row" id="app">
        <div class="card border-primary border-bottom border-3 border-0">
            <div class="card-header mt-3 mb-3">
                <div class="row">
                    <div class="col mt-2">
                        <h6>Danh Sách Học Viên Đã Vào Lớp</h6>
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
                                <th class="text-center">Email</th>
                                <th class="text-center">Tài Khoản FB</th>
                                <th class="text-center">Số Điện Thoại</th>
                                <th class="text-center">Mô Tả Trình Độ</th>
                                <th class="text-center">Người Giới Thiệu</th>
                                <th class="text-center">Khóa</th>
                                <th class="text-center">Lớp</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(value, index) in list" :key="index">
                                <th class="text-center align-middle">@{{ index + 1 }}</th>
                                <td class="text-center align-middle">@{{ value.ho_va_ten }}</td>
                                <td class="text-center align-middle">@{{ value.email }}</td>
                                <td class="text-center align-middle">
                                    <a  v-bind:href="value.facebook" target="_blank" class="text-center">
                                        <i class="fa-brands fa-facebook fa-3x" style="padding: 10px"></i>
                                    </a>
                                </td>
                                <td class="text-center align-middle">
                                    <a>@{{ value.so_dien_thoai }}</a>
                                </td>
                                <td class="text-center align-middle">
                                    <button v-on:click="modal = value"  data-bs-toggle="modal" data-bs-target="#moTaTrinhDoModal" class="btn btn-primary"><i style="padding-left: 6px" class="fa-solid fa-info"></i></button>
                                </td>
                                <td class="text-center align-middle">@{{ value.nguoi_gioi_thieu }}</td>
                                <td class="text-center align-middle">@{{ value.ten_khoa_hoc }}</td>
                                <td class="text-center align-middle">@{{ value.ten_lop_hoc }}</td>
                                <td class="text-center align-middle">
                                    <button v-on:click="destroy = value"  data-bs-toggle="modal" data-bs-target="#deleteHocVien" class="btn btn-danger">Xóa</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="modal fade" id="moTaTrinhDoModal" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Mô Tả Trình Độ</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @{{ modal.mo_ta_trinh_do }}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="deleteHocVien" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Xoá Học Viên</b></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Ban chắc chắn là sẽ xoá học viên <b class="text-danger">@{{ destroy.ho_va_ten }}</b> này!<br>
                                    <b>Lưu ý: Hành động này không thể khôi phục!</b>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button v-on:click="deleteHocVien()" type="button" class="btn btn-primary">Xoá Học Viên</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="modal fade" id="updateHocVien" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Cập Nhật Học Viên</b></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <select class="form-control">
                                        <template v-for="(value, index) in list_nhanvien">
                                            <option v-bind:value="value.id">@{{value.ho_va_ten}}</option>
                                        </template>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button v-on:click="updateHocVien()" type="button" class="btn btn-primary">Cập Nhật Học Viên</button>
                                </div>
                            </div>
                        </div>
                    </div> --}}
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
            list    :   [],
            modal   :   {},
            destroy :   {},
            list_nhanvien : [],
        },
        created() {
            this. loadData();
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
            loadData() {
                axios
                    .get('/admin/hoc-vien-chinh-thuc/data')
                    .then((res) => {
                        this.list = res.data.data;
                        // this.list_nhanvien = res.data.data_nhanvien;
                    });
            },
            deleteHocVien() {
                axios
                    .post('/admin/hoc-vien-chinh-thuc/delete', this.destroy)
                    .then((res) => {
                        displaySuccess(res);
                        this.loadData();
                        $('#deleteHocVien').modal('hide');
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },
        }
    });
</script>
@endsection
