@extends('admin.share.master')
@section('content')
    <div class="card" id="app">
        <button class="btn btn-primary me-3 ms-3 mt-3"  data-bs-toggle="modal"
            data-bs-target="#exampleModal">Chấm Công</button>
            {{-- Ghi Chú --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận chấm công</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <textarea v-model="ghi_chu" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                        <button type="button" class="btn btn-primary" v-on:click="chamCong()">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên Nhân Viên</th>
                        <th>Ca</th>
                        <th>Trạng Thái</th>
                        <th>Ghi Chú</th>
                        <th>Ip Chấm Công</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>

                        <td>
                            1
                        </td>
                        <td>
                            Admin
                        </td>
                        <td>
                            Sáng
                        </td>
                        <td>
                            Đúng Giờ
                        </td>
                        <td>
                            abc
                        </td>
                        <td>
                            192.16.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <script>
        new Vue({
            el: '#app',
            data: {
                ghi_chu : ''
            },
            created() {

            },
            methods: {
                chamCong() {
                    axios
                        .post('/admin/cham-cong/check-in-cham-cong',this.ghi_chu)
                        .then((res) => {

                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0], 'Error');
                            });
                        });
                },
            },
        });
    </script>
@endsection
