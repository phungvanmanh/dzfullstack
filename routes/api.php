<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BinanceController;
use App\Http\Controllers\BuoiHocController;
use App\Http\Controllers\ChamCongController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\DanhGiaRenLuyenController;
use App\Http\Controllers\HocVienController;
use App\Http\Controllers\KeyWordController;
use App\Http\Controllers\KhoaHocController;
use App\Http\Controllers\LichHocController;
use App\Http\Controllers\LichLamViecController;
use App\Http\Controllers\LopHocController;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\SupportHocVienController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ToolMailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/409e24fb-47e7-4cc3-9710-54a2e998c859' , [ConfigController::class , 'index']);

Route::post('/mail' , [TestController::class , 'testMail']);

Route::post('/login' , [HocVienController::class , 'actionApiLoginhocVien']);

// Login admin
Route::post('/admin/login' , [AdminController::class , 'actionLoginVue']);
// Route::post('/check-login' , [AdminController::class , 'checkLoginVue']);
Route::group(['prefix' => '/tools'], function() {
    Route::post('/create-mail', [ToolMailController::class, 'createMail']);
    Route::post('/create-mail-python', [ToolMailController::class, 'createMail_Python']);
    Route::post('/update-cookie', [ToolMailController::class, 'updateCookie']);
    Route::get('/get-mail', [ToolMailController::class, 'getMail']);
    Route::post('/update-count-mail', [ToolMailController::class, 'countFarmUpdate']);
});
Route::group(['prefix' => '/', 'middleware' => 'auth:sanctum'], function() {
    Route::post('/check-login' , [HocVienController::class , 'infoHocVien']);
});

Route::group(['prefix' => '/admin', 'middleware' => 'auth:sanctum'], function() {
    Route::post('/logout-vue' , [AdminController::class , 'logoutVue']);
    Route::group(['prefix' => '/khoa-hoc'], function() {
        Route::post('/data', [KhoaHocController::class, 'getData'])->name("KhoaHoc_getData");
        Route::post('/create', [KhoaHocController::class, 'store'])->name("KhoaHoc_store");
        Route::post('/update', [KhoaHocController::class, 'update'])->name("KhoaHoc_update");
        Route::post('/delete', [KhoaHocController::class, 'destroy'])->name("KhoaHoc_destroy");
    });

    Route::group(['prefix' => '/nhan-vien'], function() {
        Route::post('/data', [NhanVienController::class, 'getData'])->name("NhanVien_getData");
        Route::post('/create', [NhanVienController::class, 'store'])->name("NhanVien_store");
        Route::post('/update', [NhanVienController::class, 'update'])->name("NhanVien_update");
        Route::post('/delete', [NhanVienController::class, 'destroy'])->name("NhanVien_destroy");

        Route::post('/update-thong-tin-ca-nhan', [NhanVienController::class, 'updateThongTinCaNhan'])->name("NhanVien_updateThongTinCaNhan");
        Route::post('/change-password', [NhanVienController::class, 'changePassword'])->name("NhanVien_changePassword");

        Route::post('/change-status', [NhanVienController::class, 'changeStatus']);

        Route::post('/thong-tin-ca-nhan', [NhanVienController::class, 'viewThongTinCaNhan']);

    });

    Route::group(['prefix' => '/lich-lam-viec'], function () {
        Route::post('/buoi-lam/update-vue', [LichLamViecController::class, 'updateNoiDungBuoiLamViecVue'])->name("LichLamViec_updateNoiDungBuoiLamViec");
        Route::post('/buoi-lam/data', [LichLamViecController::class, 'dataBuoiLamViec'])->name("LichLamViec_dataBuoiLamViec");
        Route::post('/dang-ky/data-vue/{type}' , [LichLamViecController::class , 'dataDangKyLichLamViecVue'])->name("LichLamViec_dataDangKyLichLamViec");
        Route::post('/dang-ky/store-vue', [LichLamViecController::class, 'storeDangKyLichLamViecVue'])->name("LichLamViec_storeDangKyLichLamViec");
        Route::post('/dang-ky/update-vue', [LichLamViecController::class, 'updateDangKyLichLamViecVue'])->name("LichLamViec_updateDangKyLichLamViec");
        Route::post('/data-nv', [NhanVienController::class, 'getDataNV']);
    });

    Route::group(['prefix' => '/lop-hoc'], function() {
        Route::post('/data', [LopHocController::class, 'getData'])->name("LopHoc_getData");
        Route::post('/data/{id_lop_hoc}', [LopHocController::class, 'getDataTheoLop']);
        // Route::post('/create', [LopHocController::class, 'store'])->name("LopHoc_store");
        Route::post('/create', [LopHocController::class, 'store_v2']);
        Route::post('/update', [LopHocController::class, 'update'])->name("LopHoc_update");
        Route::post('/update-trang-thai', [LopHocController::class, 'updateTrangThai']);
        Route::post('/delete', [LopHocController::class, 'destroy'])->name("LopHoc_destroy");
    });

    Route::group(['prefix' => '/buoi-hoc'], function() {
        Route::post('/data/{id_lop_hoc}', [BuoiHocController::class, 'getData'])->name("BuoiHoc_getData");
        Route::post('/data-buoi-hoc/{id_buoi_hoc}', [BuoiHocController::class, 'getDataBuoiHoc'])->name("BuoiHoc_getDataBuoiHoc");
        Route::post('/create', [BuoiHocController::class, 'store'])->name("BuoiHoc_store");
        Route::post('/update', [BuoiHocController::class, 'update'])->name("BuoiHoc_update");
        Route::post('/delete/{id_buoi_hoc}', [BuoiHocController::class, 'delete'])->name("BuoiHoc_update");
    });

    Route::group(['prefix' => '/hoc-vien'], function() {
        Route::post('/hoc-vien-da-dang-ky', [HocVienController::class, 'index'])->name("LichLamViec_updateDangKyLichLamViec");
        Route::post('/data', [HocVienController::class, 'getData'])->name("LichLamViec_updateDangKyLichLamViec");
        Route::post('/update', [HocVienController::class, 'update'])->name("LichLamViec_updateDangKyLichLamViec");
        Route::post('/delete', [HocVienController::class, 'destroy'])->name("LichLamViec_updateDangKyLichLamViec");
        Route::post('/add-to-class', [HocVienController::class, 'addToClass'])->name("LichLamViec_updateDangKyLichLamViec");
        Route::post('/thong-tin/{id}', [HocVienController::class, 'thongTinHocVienTheoId'])->name("LichLamViec_updateDangKyLichLamViec");

        Route::post('/search', [HocVienController::class, 'search']);
        // Begin Mid
        Route::post('/lay-thong-tin-lop-dang-ki', [HocVienController::class, 'layThongTinLopDangKi']);
        // END Mid
    });

    Route::group(['prefix' => '/lop-dang-day'], function() {
        Route::post('/danh-sach-lop', [LopHocController::class, 'dataDanhSachLop'])->name("LichLamViec_updateDangKyLichLamViec");
        Route::post('/danh-sach-lop/{id_lop_hoc}', [LopHocController::class, 'dataDanhSachHocVienLop'])->name("LichLamViec_updateDangKyLichLamViec");

        Route::post('/change-status-vue/{id}', [LopHocController::class, 'changeStatusAddFBVue'])->name("LichLamViec_updateDangKyLichLamViec");

        Route::post('/change-status-zalo-vue/{id}', [LopHocController::class, 'changeStatusAddZaloVue'])->name("LichLamViec_updateDangKyLichLamViec");
        Route::post('/delete-hoc-vien', [LopHocController::class, 'deleteHocVien']);
        Route::post('/update-teamview-ultraview-hoc-vien', [LopHocController::class, 'updateTeamViewUtraview']);
        Route::post('/search', [LopHocController::class, 'search']);

    });

    Route::group(['prefix' => '/lich-hoc'], function() {
        Route::post('/hoc-vien-buoi-hoc/{id_buoi_hoc}', [LichHocController::class, 'hocVienBuoiHoc']);
        Route::post('/diem-danh', [LichHocController::class, 'diemDanh']);
        Route::post('/data/{id_lop_hoc}', [LichHocController::class, 'getData']);
        Route::post('/data/chua-lam-bt/{id_lop_hoc}', [LichHocController::class, 'getDataChuaLamBT']);
        Route::post('/data-khoa-hoc-vue', [LichHocController::class, 'getDataTheoThang']);
        Route::post('/data/di-hoc/{id_lop_hoc}', [LichHocController::class, 'getDataDiHoc']);
        Route::post('/data/vang-phep/{id_lop_hoc}', [LichHocController::class, 'getDataVangPhep']);
        Route::post('/data/vang-khong/{id_lop_hoc}', [LichHocController::class, 'getDataVangKhong']);
        Route::post('/data/{id_lop_hoc}', [LichHocController::class, 'getData']);
        Route::post('/update-nhan-vien-danh-gia', [LichHocController::class, 'updateNhanVienDanhGia']);
        Route::post('/update-hoc-vien-danh-gia', [LichHocController::class, 'updatehocVienDanhGia']);
        Route::post('/update-ly-do-vang', [LichHocController::class, 'updateLyDoVang']);
        Route::post('/update-share-video', [LichHocController::class, 'updateShareVideo']);

        Route::post('/share-video', [LichHocController::class, 'shareVideo']);
    });

    Route::group(['prefix' => '/support-hoc-vien'], function() {
        Route::post('/create-vue', [SupportHocVienController::class, 'storeVue']);
        Route::post('/thong-tin-da-support', [SupportHocVienController::class, 'thongTinDaSupport']);
        Route::post('/delete', [SupportHocVienController::class, 'destroy']);

    });

    Route::group(['prefix' => '/accounts'], function() {
        Route::post('/create', [AccountController::class, 'createAccount']);
        Route::post('/change-active', [AccountController::class, 'changeActive']);
        Route::post('/delete', [AccountController::class, 'deleteAccount']);
        Route::post('/data', [AccountController::class, 'getData']);

    });

    Route::group(['prefix'  => '/cham-cong'],function(){
        // Route::post('/search-by-day',[ChamCongController::class,'searchByDay']);
        Route::post('/search-by-day',[ChamCongController::class,'dataChamCong']);
        Route::post('/list-ngay-lam',[ChamCongController::class,'listNgayLam']);
    });

});

Route::group(['prefix' => '/proxy'], function() {
    Route::get('/', [ToolMailController::class, 'indexProxy']);
    Route::post('/create', [ToolMailController::class, 'createProxy']);
    Route::post('/delete', [ToolMailController::class, 'destroyProxy']);
    Route::post('/doi-ip', [ToolMailController::class, 'changeIpProxy']);
    Route::post('/gia-han', [ToolMailController::class, 'giaHanProxy']);
    Route::get('/data', [ToolMailController::class, 'dataProxy']);
});

Route::group(['prefix' => '/key-word'], function() {
    Route::get('/data', [KeyWordController::class, 'getData']);
    Route::post('/data-random', [KeyWordController::class, 'getDataRandom']);
    Route::post('/update-count-key', [KeyWordController::class, 'updateCountKey']);
});

Route::post('/check-user-mb', [ConfigController::class, 'checkUserMB']);

Route::post('/create-data-binance', [BinanceController::class, 'createDataBinance']);
Route::get('/reset-data', [BinanceController::class, 'resetData']);


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
