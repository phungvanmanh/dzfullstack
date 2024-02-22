<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BinanceController;
use App\Http\Controllers\BuoiHocController;
use App\Http\Controllers\ChamCongController;
use App\Http\Controllers\ChatAIController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\DangkykhoahocController;
use App\Http\Controllers\DanhGiaRenLuyenController;
use App\Http\Controllers\DeCuongContoller;
use App\Http\Controllers\GiaoTaskController;
use App\Http\Controllers\HocVienController;
use App\Http\Controllers\KhoaHocController;
use App\Http\Controllers\LichHocController;
use App\Http\Controllers\LichLamViecController;
use App\Http\Controllers\LichSupportController;
use App\Http\Controllers\LinkDriverController;
use App\Http\Controllers\LopHocController;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\NoiQuyController;
use App\Http\Controllers\PhanQuyenController;
use App\Http\Controllers\SupportHocVienController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ToolMailController;
use App\Models\DanhGiaRenLuyen;
use Google\Service\Adsense\Row;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('test', [TestController::class, 'index']);
Route::get('test1', [TestController::class, 'index1']);

Route::get('them-moi-buoi-hoc', [TestController::class, 'themMoiBuoiHoc']);


Route::get('/' , [ChatAIController::class , 'view']);
Route::post('/ai' , [ChatAIController::class , 'ai']);
Route::get('/migrate' , [ChatAIController::class , 'actionMigrate']);

Route::get('/admin/login' , [AdminController::class , 'viewLogin']);
Route::post('/admin/login' , [AdminController::class , 'actionLogin']);
Route::get('/admin/logout' , [AdminController::class , 'logout']);
Route::get('/hocVien/logout' , [HocVienController::class , 'logout']);

Route::get('/vcard/{uuid}', [HocVienController::class, 'showInfoByUUID']);
Route::get('/vcard', [TestController::class, 'index']);
Route::get('/lich-support', [LichSupportController::class, 'lichLamViecTuan']);
Route::get('/lich-support/data/{type}' , [LichSupportController::class , 'dataDangKyLichSupport']);
Route::get('/lich-support/data-nv', [LichSupportController::class, 'getDataNV']);
//đăng ký khóa học của học viên
Route::group(['prefix' => '/dang-ky-khoa-hoc'], function() {
    Route::get('/',[DangkykhoahocController::class,'index']);
    // Route::get('/data', [DangkykhoahocController::class, 'getData']);
    Route::post('/create', [DangkykhoahocController::class, 'RegisAction']);
    // Route::post('/update', [DangkykhoahocController::class, 'update']);
    // Route::post('/delete', [DangkykhoahocController::class, 'destroy']);
});

// login học viên
Route::get('/login' , [HocVienController::class , 'viewLoginHocVien']);
Route::post('/login' , [HocVienController::class , 'actionLoginhocVien']);
//đăng ký khóa học của học viên

//Quên mật khẩu học viên
Route::get('/quen-mat-khau' , [HocVienController::class , 'viewQuenMatKhau']);
Route::post('/quen-mat-khau' , [HocVienController::class , 'actioQuenMatKhau']);
Route::get('/reset-password/{hash}' , [HocVienController::class , 'viewResetPassword']);
Route::post('/reset-password' , [HocVienController::class , 'actioResetPassword']);



//Học Viên Login
Route::group(['prefix' => '/hocVien'], function() {
    //profile học viên
    Route::get('/thong-tin-ca-nhan', [HocVienController::class, 'viewThongTinCaNhanHocVien']);
    Route::post('/update-thong-tin-ca-nhan', [HocVienController::class, 'updateThongTinCaNhanHocVien']);
    Route::post('/change-password', [HocVienController::class, 'changePasswordHocVien']);

    Route::group(['prefix' => '/don-xin-phep'], function() {
        Route::get('/index' , [HocVienController::class , 'viewDonXinPhep']);
        Route::get('/get-lop-dang-hoc' , [HocVienController::class , 'getLopDangHoc']);
        Route::get('/get-buoi-hoc/{id}' , [HocVienController::class , 'getBuoiHoc']);
        Route::post('/update-ly-do-vang', [HocVienController::class , 'updateLyDoVang']);
        Route::post('/update-hoc-vien-danh-gia-buoi-hoc', [HocVienController::class , 'updateHocVienDanhGia']);
    });
});

Route::group(['prefix' => '/admin', 'middleware' => 'AdminMiddleware'], function() {
    // Route::get('/', [AdminController::class, 'test']);
    Route::group(['prefix' => '/khoa-hoc'], function() {
        Route::get('/', [KhoaHocController::class, 'index']);
        Route::get('/data', [KhoaHocController::class, 'getData'])->name('KhoaHoc_GetData');
        Route::post('/create', [KhoaHocController::class, 'store'])->name('KhoaHoc_Store');
        Route::post('/update', [KhoaHocController::class, 'update']);
        Route::post('/delete', [KhoaHocController::class, 'destroy']);
    });

    Route::group(['prefix' => '/nhan-vien'], function() {
        Route::get('/', [NhanVienController::class, 'index']);
        Route::get('/data', [NhanVienController::class, 'getData']);
        Route::post('/create', [NhanVienController::class, 'store']);
        Route::post('/update', [NhanVienController::class, 'update']);
        Route::post('/delete', [NhanVienController::class, 'destroy']);
        Route::post('/change-status', [NhanVienController::class, 'changeStatus']);

        Route::get('/thong-tin-ca-nhan', [NhanVienController::class, 'viewThongTinCaNhan']);
        Route::post('/update-thong-tin-ca-nhan', [NhanVienController::class, 'updateThongTinCaNhan']);
        Route::post('/change-password', [NhanVienController::class, 'changePassword']);
    });

    Route::group(['prefix' => '/lop-hoc'], function() {
        Route::get('/', [LopHocController::class, 'index']);
        Route::get('/data', [LopHocController::class, 'getData']);
        Route::get('/data/{id_lop_hoc}', [LopHocController::class, 'getDataTheoLop']);
        // Route::post('/create', [LopHocController::class, 'store']);
        // Mid Viết
        Route::post('/create', [LopHocController::class, 'store_v2']);
        // End Mid Viết
        Route::post('/update', [LopHocController::class, 'update']);
        Route::post('/update-trang-thai', [LopHocController::class, 'updateTrangThai']);
        Route::post('/doi-buoi-hoc', [LopHocController::class, 'doiBuoi']);
        Route::post('/delete', [LopHocController::class, 'destroy']);
    });

    Route::group(['prefix'  => '/cham-cong'],function(){
        Route::get('/',[ChamCongController::class,'index']);
        // Route::post('/search-by-day',[ChamCongController::class,'searchByDay']);
        Route::post('/search-by-day',[ChamCongController::class,'dataChamCong']);
        Route::post('/list-ngay-lam',[ChamCongController::class,'listNgayLam']);

        // check-in
        Route::get('/check-in',[ChamCongController::class,'indexCheckIn']);
        Route::post('/check-in-cham-cong',[ChamCongController::class,'checkInChamCong']);

    });

    Route::group(['prefix'  => '/tasks'],function(){
        Route::get('/',[GiaoTaskController::class,'index']);
        Route::post('/create',[GiaoTaskController::class,'store']);
        Route::get('/data',[GiaoTaskController::class,'getData']);
        Route::post('/delete', [GiaoTaskController::class, 'destroy']);
        Route::post('/update', [GiaoTaskController::class, 'update']);
        Route::post('/status', [GiaoTaskController::class, 'changeStatus']);
        Route::post('/search', [GiaoTaskController::class, 'SearchGiaoTask']);
    });

    Route::group(['prefix' => '/lich-lam-viec'], function () {
        Route::get('/' , [LichLamViecController::class , 'index']);
        Route::post('/buoi-lam/update', [LichLamViecController::class, 'updateNoiDungBuoiLamViec']);
        Route::get('/buoi-lam/data/{id_buoi_lam_viec}', [LichLamViecController::class, 'dataBuoiLamViec']);
        Route::get('/dang-ky' , [LichLamViecController::class , 'viewDangKyLichLamViec']);
        Route::get('/dang-ky/data/{type}' , [LichLamViecController::class , 'dataDangKyLichLamViec']);
        Route::post('/dang-ky/store', [LichLamViecController::class, 'storeDangKyLichLamViec']);
        Route::post('/dang-ky/update', [LichLamViecController::class, 'updateDangKyLichLamViec']);
        Route::get('/data-nv', [NhanVienController::class, 'getDataNV']);

    });

    Route::group(['prefix' => '/buoi-hoc'], function() {
        Route::get('/{id_lop_hoc}', [BuoiHocController::class, 'index']);
        Route::get('/data/{id_lop_hoc}', [BuoiHocController::class, 'getData']);
        Route::get('/data-buoi-hoc/{id_buoi_hoc}', [BuoiHocController::class, 'getDataBuoiHoc']);
        Route::post('/create', [BuoiHocController::class, 'store']);
        Route::post('/update', [BuoiHocController::class, 'update']);
        Route::get('/delete/{id_buoi_hoc}', [BuoiHocController::class, 'delete']);
    });

    Route::group(['prefix' => '/tong-ket-thang'], function() {
        // Route::get('/{id_lop_hoc}/{id_thang}/{so_buoi_hoc}/{a}', [BuoiHocController::class, 'view']);
        Route::get('/{id_lop_hoc}', [BuoiHocController::class, 'view']);
        Route::post('/get-data/khoa-hoc', [BuoiHocController::class,'getDataTheoKhoa']);
    });

    Route::group(['prefix' => '/lich-hoc'], function() {
        Route::get('/{id_buoi_hoc}', [LichHocController::class, 'index']);
        Route::post('/diem-danh', [LichHocController::class, 'diemDanh']);
        Route::get('/data/{id_lop_hoc}', [LichHocController::class, 'getData']);
        Route::get('/data/chua-lam-bt/{id_lop_hoc}', [LichHocController::class, 'getDataChuaLamBT']);
        Route::post('/data-khoa-hoc', [LichHocController::class, 'getDataTheoThang']);
        Route::get('/data/di-hoc/{id_lop_hoc}', [LichHocController::class, 'getDataDiHoc']);
        Route::get('/data/vang-phep/{id_lop_hoc}', [LichHocController::class, 'getDataVangPhep']);
        Route::get('/data/vang-khong/{id_lop_hoc}', [LichHocController::class, 'getDataVangKhong']);
        Route::get('/data/{id_lop_hoc}', [LichHocController::class, 'getData']);
        Route::post('/update-nhan-vien-danh-gia', [LichHocController::class, 'updateNhanVienDanhGia']);
        Route::post('/update-hoc-vien-danh-gia', [LichHocController::class, 'updatehocVienDanhGia']);
        Route::post('/update-ly-do-vang', [LichHocController::class, 'updateLyDoVang']);
        Route::post('/update-share-video', [LichHocController::class, 'updateShareVideo']);

        Route::post('/share-video', [LichHocController::class, 'shareVideo']);
        // Route::post('/delete', [LichHocController::class, 'destroy']);
    });

    Route::group(['prefix' => '/phan-quyen'], function() {
        Route::get('/index', [PhanQuyenController::class, 'index']);
        Route::get('/data', [PhanQuyenController::class, 'getData']);
        Route::post('/create', [PhanQuyenController::class, 'store']);
        Route::post('/update', [PhanQuyenController::class, 'update']);
        Route::post('/delete', [PhanQuyenController::class, 'destroy']);
    });

    Route::group(['prefix' => '/lop-dang-day'], function() {
        Route::get('/', [LopHocController::class, 'viewLopDangDay']);
        Route::get('/danh-sach-lop', [LopHocController::class, 'dataDanhSachLop']);
        Route::get('/danh-sach-lop/{id_lop_hoc}', [LopHocController::class, 'dataDanhSachHocVienLop']);

        Route::get('/change-status/{id}', [LopHocController::class, 'changeStatusAddFB']);

        Route::get('/change-status-zalo/{id}', [LopHocController::class, 'changeStatusAddZalo']);

        Route::post('/delete-hoc-vien', [LopHocController::class, 'deleteHocVien']);
        Route::post('/update-teamview-ultraview-hoc-vien', [LopHocController::class, 'updateTeamViewUtraview']);
        Route::post('/search', [LopHocController::class, 'search']);

    });

    Route::group(['prefix' => '/lop-ket-thuc'], function() {
        Route::get('/', [LopHocController::class, 'viewLopKetThuc']);
    });

    Route::group(['prefix' => '/support-hoc-vien'], function() {
        Route::post('/create', [SupportHocVienController::class, 'store']);
        Route::post('/thong-tin-da-support', [SupportHocVienController::class, 'thongTinDaSupport']);
        Route::post('/delete', [SupportHocVienController::class, 'destroy']);
    });

    Route::group(['prefix' => '/hoc-vien'], function() {
        Route::get('/hoc-vien-da-dang-ky', [HocVienController::class, 'index']);
        Route::post('/search', [HocVienController::class, 'search']);
        Route::get('/data', [HocVienController::class, 'getData']);
        Route::post('/update', [HocVienController::class, 'update']);
        Route::post('/delete', [HocVienController::class, 'destroy']);
        Route::post('/add-to-class', [HocVienController::class, 'addToClass']);
        Route::get('/thong-tin/{id}', [HocVienController::class, 'thongTinHocVienTheoId']);

        // Begin Mid
        Route::post('/lay-thong-tin-lop-dang-ki', [HocVienController::class, 'layThongTinLopDangKi']);
        // END Mid
    });
    Route::group(['prefix' => '/hoc-vien-chinh-thuc'], function() {
        Route::get('/', [HocVienController::class, 'hocVienChinhThuc']);
        Route::get('/data', [HocVienController::class, 'getDataHocVienChinhThuc']);
        Route::post('/delete', [HocVienController::class, 'destroy']);
    });

    Route::group(['prefix' => '/accounts'], function() {
        Route::get('/', [AccountController::class, 'index']);
        Route::post('/create', [AccountController::class, 'createAccount']);
        Route::post('/change-active', [AccountController::class, 'changeActive']);
        Route::post('/delete', [AccountController::class, 'deleteAccount']);
        Route::get('/data', [AccountController::class, 'getData']);

    });

    Route::group(['prefix' => '/dang-ky-support'], function() {
        Route::get('/dang-ky-support-tuan', [LichSupportController::class, 'viewDangKyLichSupport']);
        Route::get('/dang-ky-support-tuan/data/{type}' , [LichSupportController::class , 'dataDangKyLichLamViec']);
        Route::post('/dang-ky-support-tuan/store', [LichSupportController::class, 'storeDangKyLichLamViec']);
        Route::post('/dang-ky-support-tuan/update', [LichSupportController::class, 'updateDangKyLichLamViec']);
    });

    Route::group(['prefix' => '/tools'], function() {
        Route::get('/', [ToolMailController::class, 'index']);
        Route::post('/create-mail', [ToolMailController::class, 'createMail']);
        Route::get('/get-mail/{id}', [ToolMailController::class, 'getMail']);
        Route::post('/update-mail', [ToolMailController::class, 'update']);
        Route::post('/del-mail', [ToolMailController::class, 'destroy']);
        Route::post('/doi-trang-thai', [ToolMailController::class, 'doiTrangThai']);


    });

    Route::group(['prefix' => '/proxy'], function() {
        Route::get('/', [ToolMailController::class, 'indexProxy']);
        Route::post('/status', [ToolMailController::class, 'statusProxy']);
    });

    Route::group(['prefix' => '/keyword'], function() {
        Route::get('/danh-sach-key-word', [ToolMailController::class, 'danhSachKeyWord']);
        Route::get('/chart', [ToolMailController::class, 'indexChart']);
        Route::get('/', [ToolMailController::class, 'indexProxy']);
        Route::post('/status', [ToolMailController::class, 'statusProxy']);
        Route::get('/data', [ToolMailController::class, 'danhSachKeyWord']);
        Route::get('/data-chart', [ToolMailController::class, 'dataChart']);
        Route::post('/search', [ToolMailController::class, 'searchKeywork']);
    });

    Route::group(['prefix' => '/link-driver'], function() {
        Route::get('/', [LinkDriverController::class, 'index']);
        Route::get('/data', [LinkDriverController::class, 'getData']);
        Route::post('/create', [LinkDriverController::class, 'store']);
        Route::post('/update', [LinkDriverController::class, 'update']);
        Route::post('/delete', [LinkDriverController::class, 'destroy']);
    });

    Route::group(['prefix' => '/noi-quy'], function() {
        Route::get('/', [NoiQuyController::class, 'index']);
        Route::get('/data', [NoiQuyController::class, 'getData']);
        Route::post('/create', [NoiQuyController::class, 'store']);
        Route::post('/update', [NoiQuyController::class, 'update']);
        Route::post('/delete', [NoiQuyController::class, 'destroy']);
    });

    Route::group(['prefix' => '/config'], function() {
        Route::get('/user-mb', [ConfigController::class, 'indexUserMB']);
        Route::post('/data', [ConfigController::class, 'data']);
        Route::post('/create', [ConfigController::class, 'store']);
        Route::post('/status', [ConfigController::class, 'status']);
        Route::post('/update', [ConfigController::class, 'update']);
        Route::post('/delete', [ConfigController::class, 'destroy']);
    });

});
Route::group(['prefix' => 'laravel-filemanager'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});


Route::group(['prefix' => '/dtu'], function() {
    Route::group(['prefix' => '/de-cuong'], function() {
        Route::get('/', [DeCuongContoller::class, 'index']);
        Route::get('/data', [DeCuongContoller::class, 'getData']);
        Route::post('/lichTrinh', [DeCuongContoller::class, 'getlichTrinh']);
        Route::post('/create', [DeCuongContoller::class, 'store']);
        Route::post('/update', [DeCuongContoller::class, 'update']);
        Route::post('/delete', [DeCuongContoller::class, 'destroy']);
    });

    // BEGIN HOC KI
    Route::get('/tao-hoc-ky', [\App\Http\Controllers\DTUController::class, 'viewTaoHocKy']);
    Route::post('/tao-hoc-ky', [\App\Http\Controllers\DTUController::class, 'TaoHocKy']);
    Route::get('/data-hoc-ky', [\App\Http\Controllers\DTUController::class, 'getDataHocKi']);

    Route::post('/update-hoc-ky', [\App\Http\Controllers\DTUController::class, 'updateHocKi']);
    Route::post('/delete-hoc-ky', [\App\Http\Controllers\DTUController::class, 'deleteHocKi']);
    // END HOC KI

    // BEGIN LICH DE CUONG
    Route::get('/tao-lich-de-cuong', [\App\Http\Controllers\LichDeCuongController::class, 'viewTaoLichDeCuong']);
    Route::post('/tao-lich-de-cuong', [\App\Http\Controllers\LichDeCuongController::class, 'actionTaoLichDeCuong']);
    // END LICH DE CUONG
    Route::post('/get-info', [\App\Http\Controllers\DTUController::class, 'getInfo']);
    Route::post('/create-calender', [\App\Http\Controllers\DTUController::class, 'createCalender']);
    Route::post('/check-calender', [\App\Http\Controllers\DTUController::class, 'checkCalender']);
    Route::post('/get-calender-of-user', [\App\Http\Controllers\DTUController::class, 'getCalenderOfUser']);

    Route::post('/get-lich-de-cuong', [\App\Http\Controllers\DTUController::class, 'getLichDeCuong']);

    Route::get('/api-lich-trinh', [\App\Http\Controllers\LichDeCuongController::class, 'apiLichTrinh']);

    Route::post('/update-student', [DanhGiaRenLuyenController::class, 'store']);

    Route::post('/get-info-de-cuong', [\App\Http\Controllers\DTUController::class, 'getInfoDeCuong']);
    Route::post('/kiem-tra-quy-tac', [\App\Http\Controllers\DeCuongContoller::class, 'kiemTraQuyTac']);

    Route::post('/check-before-run', [\App\Http\Controllers\DanhGiaRenLuyenController::class, 'checkBeforeRun']);

    Route::post('/change-status-done', [\App\Http\Controllers\DanhGiaRenLuyenController::class, 'updateDanhGiaRenLuyen']);

});

// Binance
// Route::get('/binance', [BinanceController::class, 'getData']);
// Route::get('/binance-new', [BinanceController::class, 'getDataNew']);
Route::get('/binance-index', [BinanceController::class, 'index']);
Route::get('/data-binance', [BinanceController::class, 'dataBinance']);



