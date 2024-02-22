@extends('admin.share.master')
@section('content')
<div class="row" id="app">
    <div class="col-md-4">
        <div class="card border-primary border-bottom border-3 border-0">
            <div class="card-header">
                <h6>Thêm mới Account</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">User Name</label>
                    <input type="text" v-model="add.username" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tình Trạng</label>
                    <select class="form-control" v-model="add.is_active">
                        <option value="1">Kích Hoạt</option>
                        <option value="0">Không kích Hoạt</option>
                    </select>
                </div>
                <div class="text-end">
                    <button type="button" v-on:click="createAccount()" class="btn btn-primary">Thêm Mới</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card border-primary border-bottom border-3 border-0">
            <div class="card-header">
                <h6>Danh Sách Account</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="align-middle text-center">#</th>
                            <th class="align-middle text-center">User Name</th>
                            <th class="align-middle text-center">Count User</th>
                            <th class="align-middle text-center">Tình Trạng</th>
                            <th class="align-middle text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(value, key) in list">
                            <tr>
                                <th class="align-middle text-center">@{{ key + 1 }}</th>
                                <td class="align-middle">@{{ value.username }}</td>
                                <td class="align-middle">
                                    @{{number_format(value.count_use)}}
                                </td>
                                <td class="text-center align-middle">
                                    <button class="btn btn-success" v-on:click="changeActive(value)" v-if="value.is_active == 1">Đã Kích hoạt</button>
                                    <button class="btn btn-danger" v-on:click="changeActive(value)"v-else>Không kích hoạt</button>
                                </td>
                                <td class="text-center align-middle">
                                    <button class="btn btn-danger" v-on:click='deleteaccount = value' data-bs-toggle="modal" data-bs-target="#deleteModal">Xóa</button>
                                </td>
                            </tr>
                        </template>

                    </tbody>
                </table>
            </div>
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header bg-danger">
                      <h5 class="modal-title text-white" id="exampleModalLabel">Xóa Account - @{{ deleteaccount.username }}</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <h5>Bạn có chắc chắn muốn xóa Account - @{{ deleteaccount.username }}</h5>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                      <button type="button" class="btn btn-primary" v-on:click="deleteAccount(deleteaccount)" data-bs-dismiss="modal">Đồng Ý</button>
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
            add     : {},
            deleteaccount     : {},
            list    : [],
        },
        created() {
            this.loadData();
        },
        methods: {
            date_format(now) {
                return moment(now).format('DD/MM/yyyy');
            },
            number_format(number, decimals = 0, dec_point = ",", thousands_sep = ".") {
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
            createAccount() {
                axios
                    .post('/admin/accounts/create', this.add)
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
                axios
                    .get('/admin/accounts/data')
                    .then((res) => {
                        this.list = res.data.data;
                    });
            },

            changeActive(v){
                axios
                    .post('/admin/accounts/change-active', v)
                    .then((res) => {
                        displaySuccess(res);
                        this.loadData();
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },

            deleteAccount(v){
                axios
                    .post('/admin/accounts/delete', v)
                    .then((res) => {
                        displaySuccess(res);
                        $('#deleteModal').hide('modal');
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
