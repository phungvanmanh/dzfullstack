<!doctype html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.share.css')
</head>

<body class="bg-login">
    <!--wrapper-->
    <div class="wrapper" id="app">
        <div class="d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container">
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2">
                    <div class="col mx-auto">
                        <div class="my-4 text-center">
                            <img src="/assets/images/logo-1.png" width="180" alt="" />
                        </div>
                        <h4 style="margin-top:-25px;margin-bottom:-20px" class="text-center">DZ FullStack</h4>
                        <div class="card border-top border-0 border-4 border-primary mt-5">
                            <div class="card-body">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h3 style="margin-top:-40px; margin-bottom: 20px">Đăng Ký Khóa học</h3>
                                        <hr>
                                    </div>
                                    {{-- <form class="row g-3" action="/dang-ky-khoa-hoc/create" method="POST"> --}}
                                        {{-- @csrf --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Họ Và Tên</label>
                                                <input v-model="add.ho_va_ten" class="form-control" placeholder="Nhập họ và tên">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Email</label>
                                                <input v-model="add.email" class="form-control" placeholder="Nhập email cá nhân">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label class="form-label">Link Facebook cá nhân</label>
                                                <input v-model="add.facebook" type="text" class="form-control"
                                                    placeholder="Link facebook cá nhân ">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Số Điện Thoại</label>
                                                <input v-model="add.so_dien_thoai" type="tel" class="form-control" placeholder="Nhập số điện thoại">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <label class="form-label">Mô Tả Trình Độ</label>
                                                <textarea v-model="add.mo_ta_trinh_do" class="form-control" placeholder="Mô tả về trình độ của bản thân" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label class="form-label">Người Giới Thiệu</label>
                                                <input v-model="add.nguoi_gioi_thieu" type="text" class="form-control"
                                                    placeholder="Tên người giới thiệu">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Chọn Khóa Học</label>
                                                <select v-model="add.id_lop_dang_ky" class="form-select">
                                                    <option value="">Khóa học...</option>
                                                    @foreach ($lopDangKy as $key => $value)
                                                        <option value="{{ $value->id }}">{{ $value->ten_lop_hoc }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 text-end">
                                            <hr>
                                            <button v-on:click="ThemMoi()" style="margin-top:15px; margin-bottom:-30px" type="button"
                                                class="btn btn-primary px-5">Đăng Ký</button>
                                        </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </div>
    <!--end wrapper-->

    @include('admin.share.js')
    <script>
        // @php
        //         dd(count($errors));
        // @endphp
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif

        new Vue({
            el  : '#app',
            data    :  {
                add :   {},
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
                ThemMoi() {
                    axios
                        .post('/dang-ky-khoa-hoc/create', this.add)
                        .then((res) => {
                            displaySuccess(res);
                            if(res.data.status) {
                                window.setTimeout('location.reload()', 400);
                            }
                        })
                        .catch((err) => {
                            displayErrors(err);
                        });
                },
            }
        });
    </script>
</body>

</html>
