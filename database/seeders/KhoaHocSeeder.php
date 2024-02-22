<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KhoaHocSeeder extends Seeder
{
    public function run()
    {
        DB::table('khoa_hocs')->delete();

        DB::table('khoa_hocs')->truncate();

        DB::table('khoa_hocs')->insert([
            [
                'ten_khoa_hoc'          => "LaravelFullStack",
                'mo_ta_khoa'            => "Nói chung là khóa này học xong có thể làm được hầu hết những gì mà các bạn thấy.
                                            Đảm bảo:
                                            1. CAM KẾT KHÓA HỌC CHẤT LƯỢNG - NẾU KHÔNG LÀM ĐƯỢC THẦY REFUND 100% HỌC PHÍ
                                            2. Dạy từ MẤT GỐC. Nếu thật sự các bạn muốn theo ngành này nhưng đã mất gốc thì hãy cố gắng trong 3 tháng, ước mơ sẽ trở lại.
                                            3. Sau 3 tháng các bạn có thể làm được đề tài KHÓA LUẬN TỐT NGHIỆP (CHẤT LƯỢNG CAO) được luôn nhé. Nghĩa là các bạn bỏ thời gian 3 tháng được học trước công nghệ mấy năm.
                                            4. Học phí được đóng từng tháng. Các bạn không tìm ở đâu dạy khóa học mà cho đóng từng tháng, nhưng ở đây cho đóng từng tháng nghĩa là rất tự tin về chất lượng để các bạn học xong khóa và vừa tạo điều kiện để đóng học phí nhẹ nhàng hơn.
                                            5. Các bạn học được support tận nơi, hầu như 24/7 (kể chủ nhật). RẤT QUAN TRỌNG - NẾU BÍ THÌ SẼ ĐƯỢC THẦY TEAMVIEW SỬA LỖI NGAY LẬP TỨC ĐỂ CÁC BẠN LÀM TIẾP.
                                            6. Nếu học xong muốn thầy giới thiệu công ty thì thầy sẽ giới thiệu để đi làm.
                                            7. Được ký chứng nhận thực tập tốt nghiệp
                                            ",
                'is_open'               => 1,
                'so_buoi_trong_thang'   => 12,
                'hoc_phi_theo_thang'    => 2500000,
                'so_thang_hoc'          => 3,
            ],
            [
                'ten_khoa_hoc'          => "AndroidFullStack",
                'mo_ta_khoa'            => "Nói chung là khóa này học xong có thể làm được hầu hết những gì mà các bạn thấy.
                                            Đảm bảo:
                                            1. CAM KẾT KHÓA HỌC CHẤT LƯỢNG - NẾU KHÔNG LÀM ĐƯỢC THẦY REFUND 100% HỌC PHÍ
                                            2. Dạy từ MẤT GỐC. Nếu thật sự các bạn muốn theo ngành này nhưng đã mất gốc thì hãy cố gắng trong 3 tháng, ước mơ sẽ trở lại.
                                            3. Sau 3 tháng các bạn có thể làm được đề tài KHÓA LUẬN TỐT NGHIỆP (CHẤT LƯỢNG CAO) được luôn nhé. Nghĩa là các bạn bỏ thời gian 3 tháng được học trước công nghệ mấy năm.
                                            4. Học phí được đóng từng tháng. Các bạn không tìm ở đâu dạy khóa học mà cho đóng từng tháng, nhưng ở đây cho đóng từng tháng nghĩa là rất tự tin về chất lượng để các bạn học xong khóa và vừa tạo điều kiện để đóng học phí nhẹ nhàng hơn.
                                            5. Các bạn học được support tận nơi, hầu như 24/7 (kể chủ nhật). RẤT QUAN TRỌNG - NẾU BÍ THÌ SẼ ĐƯỢC THẦY TEAMVIEW SỬA LỖI NGAY LẬP TỨC ĐỂ CÁC BẠN LÀM TIẾP.
                                            6. Nếu học xong muốn thầy giới thiệu công ty thì thầy sẽ giới thiệu để đi làm.
                                            7. Được ký chứng nhận thực tập tốt nghiệp
                                            ",
                'is_open'               => 1,
                'so_buoi_trong_thang'   => 12,
                'hoc_phi_theo_thang'    => 2500000,
                'so_thang_hoc'          => 3,
            ],
        ]);
    }
}
