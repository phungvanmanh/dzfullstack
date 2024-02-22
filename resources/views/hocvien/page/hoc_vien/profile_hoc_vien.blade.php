@extends('hocvien.share.master')
@section('content')
<div class="row" id="app">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column align-items-center text-center">
                    @php
                        $user = Auth::guard('hocVien')->user();
                    @endphp
                    <img src="{{ $user->anh_dai_dien != null ? $user->anh_dai_dien :  "/assets/images/avatars/avatar-2.png" }}" class="rounded-circle p-1 bg-primary" width="300px" height="300px">
                    <div class="mt-3">
                        <h4>{{ $user ? $user->ho_va_ten : "Chưa Có Tên" }}</h4>
                    </div>
                </div>
                <hr class="my-4 mt-1"/>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6>Thông tin Cá Nhân</h6>
            </div>
            <div class="card-body">
                <form id="updateProfile">
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Họ Và Tên</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="ho_va_ten" placeholder="Nhập họ và tên" v-model="user.ho_va_ten"/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" placeholder="Nhập vào Email" name="email" v-model="user.email" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Số Điện Thoại</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" placeholder="Nhập vào số điện thoại" name="so_dien_thoai" v-model="user.so_dien_thoai"/>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">FaceBook</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="facebook" v-model="user.facebook"/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Slogan</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="sologan" v-model="user.sologan"/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Tài Khoản Git</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control" name="tai_khoan_git" v-model="user.tai_khoan_git"/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Tài TeamView/UtraView</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input class="form-control" v-model="user.danh_sach_teamview" disabled/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Skill Level</h6>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-danger" v-on:click="addSkilPercent()" type="button"><i class="fa-solid fa-plus" style="margin-left: 5px"></i></button>
                        </div>
                        <div class="col-sm-8 text-secondary" id="text_skill">
                            <template v-for="(value, index) in array_skill">
                                <template v-if="index == 0">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" v-model="value.name" placeholder="Nhập Skill"/>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" class="form-control" v-model="value.percent" placeholder="% skill"/>
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="row mt-2">
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" v-model="value.name"  placeholder="Nhập Skill"/>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" class="form-control" v-model="value.percent" placeholder="% skill"/>
                                        </div>
                                        <div class="col-md-1">
                                            <button class="btn btn-secondary" style="margin-right: 5px" v-on:click="removeSkill(index)" type="button"><i style="max-width: 10px" class="fa-solid fa-minus"></i></button>
                                        </div>
                                    </div>
                                </template>
                            </template>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Ảnh</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <div class="input-group">
                                <input class="form-control" type="file" v-on:change="getFile($event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9 text-secondary">
                            <button class="btn btn-primary" type="submit" v-on:click="updateProfile($event)">Lưu Thông Tin</button>
                        </div>
                    </div>
                </form>

                <hr class="my-4" />
                <div class="row mb-4 text-center">
                    <div class="col-sm-3">
                        <h5 class="mb-0">Thay Đổi Mật Khẩu</h5>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Mật Khẩu Mới</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="password" class="form-control" name="password" v-model="password_new.password" placeholder="Nhập vào mật khẩu của bạn"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Nhập Lại Mật Khẩu Mới</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="password" class="form-control" name="re_password" v-model="password_new.re_password" placeholder="Nhập vào mật khẩu của bạn"/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9 text-secondary">
                        <button class="btn btn-primary" v-on:click="changePassWord()">Lưu Mật Khẩu</button>
                    </div>
                </div>

                {{-- <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Mật Khẩu</h6>
                    </div>
                    <div class="col-sm-9">
                        <button class="btn btn-info text-white">Đổi Mật Khẩu</button>
                    </div>
                </div> --}}


            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    var user = <?php echo json_encode($user); ?>;
    console.log(user);
    new Vue({
        el      :  '#app',
        data    :  {
            user                : user,
            password_new        : {},
            file                : '',
            array_skill         : user.skill_level == null ? [
                {name: null, percent: null}]: JSON.parse(user.skill_level),
        },
        created() {

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

            checkFalse(value) {
                if((value.name == null && value.percent != null) || (value.name != null && value.percent == null)) {
                    toastr.error("Vui lòng điền đầy đủ thông tin của Skill Level");
                    return false;
                }
                return true;
            },

            checkArraySkill() {
                $.each(this.array_skill, function(key, value) {
                    if(key == 0) {
                        if(value.name == null && value.percent == null) {
                            return 3;
                        } else if((value.name == null && value.percent != null) || (value.name != null && value.percent == null)) {
                            toastr.error("Vui lòng điền đầy đủ thông tin của Skill Level");
                            return 2;
                        }
                    } else {
                        if((value.name == null && value.percent == null) || (value.name == null && value.percent != null) || (value.name != null && value.percent == null)) {
                            toastr.error("Vui lòng điền đầy đủ thông tin của Skill Level");
                            return 2;
                        }
                    }
                });

                return 1;
            },

            jsonEnCode(check) {
                if(check == 3) {
                    return '';
                } else {
                    return JSON.stringify(this.array_skill);
                }
            },

            updateProfile(e) {
                e.preventDefault();
                var get = window.getFormData($("#updateProfile"));
                const payload = new FormData();
                payload.append('id', get['id']);
                payload.append('email', get['email']);
                payload.append('ho_va_ten', get['ho_va_ten']);
                payload.append('so_dien_thoai', get['so_dien_thoai']);
                payload.append('facebook', get['facebook']);
                payload.append('sologan', get['sologan']);
                payload.append('tai_khoan_git', get['tai_khoan_git']);
                payload.append('danh_sach_teamview', get['danh_sach_teamview']);
                payload.append('anh_dai_dien', this.file);
                var check = this.checkArraySkill();
                console.log(check);
                if(check == 3 || check == 1) {
                    payload.append('skill_level', this.jsonEnCode(this.checkArraySkill));
                    axios
                    .post('/hocVien/update-thong-tin-ca-nhan', payload,
                        {
                            headers:
                                {
                                    'Content-Type': 'multipart/form-data'
                                }
                        }
                    )
                    .then((res) => {
                        displaySuccess(res);
                        setTimeout(() => {
                            window.location.href = '/hocVien/thong-tin-ca-nhan';
                        }, 2000)
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
                }

            },

            getFile(e)
            {
                this.file = e.target.files[0];
            },

            changePassWord() {
                this.password_new.id = this.user.id;
                axios
                    .post('/hocVien/change-password', this.password_new)
                    .then((res) => {
                        displaySuccess(res);
                    })
                    .catch((err) => {
                        displayErrors(err);
                    });
            },

            addSkilPercent()
            {
                this.array_skill.push({name: null, percent: null});
            },

            removeSkill(index)
            {
                this.array_skill.splice(index,1);
            }
        },
    });
</script>
@endsection
