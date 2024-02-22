<div class="mobile-topbar-header">
    <div>
        <img style="height:56px;width:69px" src="/assets/images/logo-2.png" class="logo-icon" alt="logo icon">
    </div>
    <div>
        <h4 class="text-dark" style="font-size:16px; margin-left: 3px">DZ FullStack</h4>
    </div>
    <div class="toggle-icon ms-auto"><i style="margin-bottom:6px" class='bx bx-arrow-to-left'></i>
    </div>
</div>
<nav class="navbar navbar-expand-xl w-100">
    <ul class="navbar-nav justify-content-start flex-grow-1 gap-1">
        <li class="nav-item">
            <a class="nav-link" href="/hocVien/don-xin-phep/index">
                <div class="parent-icon">
                    <i class="fa-solid fa-house"></i>
                </div>
                <div class="menu-title mt-2">Buổi Học</div>
            </a>
        </li>
        <li class="nav-item">
            @if (Auth::guard('hocVien')->user())
            <a class="nav-link" href="/vcard/{{Auth::guard('hocVien')->user()->uuid}}" target="_blank">
                <div style="margin-top: -5px;width: 10px; height: 10px;" class="parent-icon">
                    <i style="" class="fas fa-solid fa-address-card"></i>
                </div>
                <div style="margin-left: 20px" class="menu-title mt-2">Vcard</div>
            </a>
            @endif
        </li>
        {{-- <li class="nav-item dropdown">
            <a href="javascript:;" class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                <div class="parent-icon"><i class="fa-regular fa-calendar-days"></i>
                </div>
                <div class="menu-title mt-2">Đăng Kí Lịch Tuần</div>
            </a>
            <ul class="dropdown-menu">
                <li> <a class="dropdown-item" href="/admin/lich-lam-viec/dang-ky"><i
                            class="bx bx-right-arrow-alt"></i>Đăng Kí Lịch</a>
                </li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a href="javascript:;" class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                <div class="parent-icon"><i class="fa-solid fa-school"></i>
                </div>
                <div class="menu-title mt-2">Khóa Học</div>
            </a>
            <ul class="dropdown-menu">
                <li> <a class="dropdown-item" href="/admin/khoa-hoc"><i
                            class="bx bx-right-arrow-alt"></i>Khóa Học</a>
                </li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a href="javascript:;" class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                <div class="parent-icon"><i class="fa-regular fa-square-plus"></i>
                </div>
                <div class="menu-title mt-2">Tạo Lớp Học</div>
            </a>
            <ul class="dropdown-menu">
                <li> <a class="dropdown-item" href="/admin/lop-hoc"><i
                            class="bx bx-right-arrow-alt"></i>Lớp Học</a>
                </li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a href="javascript:;" class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                <div class="parent-icon"><i class="fa-solid fa-building-columns"></i>
                </div>
                <div class="menu-title mt-2">Lớp Học</div>
            </a>
            <ul class="dropdown-menu">
                <li> <a class="dropdown-item" href="/admin/lop-dang-day"><i
                            class="bx bx-right-arrow-alt"></i>Lớp Đang Dạy</a>
                </li>
                <li> <a class="dropdown-item" href="/admin/lop-ket-thuc"><i
                    class="bx bx-right-arrow-alt"></i>Lớp Kết Thúc</a>
                </li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a href="javascript:;" class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                <div class="parent-icon"><i class="fa-solid fa-user"></i>
                </div>
                <div class="menu-title mt-2">Học Viên Đã Đăng Ký</div>
            </a>
            <ul class="dropdown-menu">
                <li> <a class="dropdown-item" href="/admin/hoc-vien/hoc-vien-da-dang-ky"><i
                            class="bx bx-right-arrow-alt"></i>Đã Đăng Ký</a>
                </li>
            </ul>
        </li> --}}
    </ul>
</nav>
