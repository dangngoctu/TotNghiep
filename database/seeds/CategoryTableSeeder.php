<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('m_categories')->insert([
            ['status' => 1 ],
            ['status' => 1 ],
            ['status' => 1 ],
            ['status' => 1 ],
        ]);
        DB::table('m_categories_translation')->insert([
            ['name' => 'Safety','translation_id' => 1 , 'language_id' => 2 ],
            ['name' => 'An toàn','translation_id' => 1, 'language_id' => 1 ],
            ['name' => 'Machine Facility','translation_id' => 2,'language_id' => 2 ],
            ['name' => 'Cơ sở máy móc','translation_id' => 2 ,'language_id' => 1],
            ['name' => 'Environment','translation_id' => 3 ,'language_id' => 2],
            ['name' => 'Môi trường','translation_id' => 3 ,'language_id' => 1],
            ['name' => 'Orderline','translation_id' => 4 ,'language_id' => 2],
            ['name' => 'Ngoài luồng','translation_id' => 4 ,'language_id' => 1],
        ]);

        DB::table('m_falure_mode')->insert([
            ['category_id' => 1 ,'status' => 1 ],
            ['category_id' => 1 ,'status' => 1 ],
            ['category_id' => 1 ,'status' => 1 ],
            ['category_id' => 1 ,'status' => 1 ],

            ['category_id' => 2 ,'status' => 1 ],
            ['category_id' => 2 ,'status' => 1 ],

            ['category_id' => 3 ,'status' => 1 ],
            ['category_id' => 3 ,'status' => 1 ],
            ['category_id' => 3 ,'status' => 1 ],
            ['category_id' => 3 ,'status' => 1 ],

            ['category_id' => 4 ,'status' => 1 ],
            ['category_id' => 4 ,'status' => 1 ],
            ['category_id' => 4 ,'status' => 1 ],
        ]);

        DB::table('m_falure_mode_translation')->insert([
            //Safety
            ['name' => 'Not complied to Life Saving Rules','translation_id' => 1 , 'language_id' => 2],
            ['name' => 'Không tuân thủ các quy tắc cứu sinh','translation_id' => 1 , 'language_id' => 1],
            ['name' => 'Unsafe Machine','translation_id' => 2 , 'language_id' => 2],
            ['name' => 'Máy móc không an toàn','translation_id' => 2 , 'language_id' => 1],
            ['name' => 'Unsafe Facility / Storage','translation_id' => 3 , 'language_id' => 2],
            ['name' => 'Cơ sở / Kho lưu trữ không an toàn','translation_id' => 3 , 'language_id' => 1],
            ['name' => 'Unsafe Acts','translation_id' => 4 , 'language_id' => 2],
            ['name' => 'Hành vi không an toàn','translation_id' => 4 , 'language_id' => 1],
            //Machine/Facility
            ['name' => 'Basic conditions not well maintained','translation_id' => 5 , 'language_id' => 2],
            ['name' => 'Điều kiện cơ bản không được duy trì tốt','translation_id' => 5 , 'language_id' => 1],
            ['name' => 'Lack of / bad facilities to perform tasks. Eg. PPE, clothing, tools','translation_id' => 6 , 'language_id' => 2],
            ['name' => 'Thiếu / cơ sở xấu để thực hiện nhiệm vụ. Ví dụ. PPE, quần áo, dụng cụ','translation_id' => 6 , 'language_id' => 1],
            //Enviroment
            ['name' => 'Leaking. Eg. Chemicals,  water, energy resources','translation_id' => 7 , 'language_id' => 2],
            ['name' => 'Rò rỉ. Ví dụ. Hóa chất, nước, tài nguyên năng lượng','translation_id' => 7 , 'language_id' => 1],
            ['name' => 'Insects','translation_id' => 8 , 'language_id' => 2],
            ['name' => 'Insects','translation_id' => 8 , 'language_id' => 1],
            ['name' => 'Bad smell','translation_id' => 9 , 'language_id' => 2],
            ['name' => 'Có mùi','translation_id' => 9 , 'language_id' => 1],
            ['name' => 'Wastes & Waste Containers  ','translation_id' => 10 , 'language_id' => 2],
            ['name' => 'Chất thải và thùng chứa chất thải','translation_id' => 10 , 'language_id' => 1],
            //Ngoài luồng
            ['name' => 'Working area not well maintained. Eg. room, floor, ceiling wall, stair, window  ','translation_id' => 11 , 'language_id' => 2],
            ['name' => 'Khu vực làm việc không được bảo trì tốt. Ví dụ. phòng, sàn, tường trần, cầu thang, cửa sổ', 'translation_id' => 11 , 'language_id' => 1],
            ['name' => 'Untidy / unclean working area ','translation_id' => 12 , 'language_id' => 2],
            ['name' => 'Khu vực làm việc không gọn gàng / ô uế','translation_id' => 12 , 'language_id' => 1],
            ['name' => 'There are unnecessary things in place ','translation_id' => 13 , 'language_id' => 2],
            ['name' => 'Có những thứ không cần thiết tại đây','translation_id' => 13 , 'language_id' => 1],
        ]);

        DB::table('m_falure_mode_detail')->insert([
            //Not complied to Life Saving Rules
            ['falure_id' => 1 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
            ['falure_id' => 1 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
            ['falure_id' => 1 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
            ['falure_id' => 1 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
            ['falure_id' => 1 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
            ['falure_id' => 1 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
            ['falure_id' => 1 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
            ['falure_id' => 1 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
            //Unsafe Machine
            ['falure_id' => 2 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
            ['falure_id' => 2 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
            ['falure_id' => 2 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
            //Unsafe Facility / Storage
            ['falure_id' => 3 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 3 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 3 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 3 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
            ['falure_id' => 3 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
            ['falure_id' => 3 ,'status' => 1 ,'weight_factor'=> 3, 'is_HOC'=> 0 ],
            ['falure_id' => 3 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
            ['falure_id' => 3 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
            //Unsafe Acts
            ['falure_id' => 4 ,'status' => 1 ,'weight_factor'=> 3, 'is_HOC'=> 0 ],
            ['falure_id' => 4 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 4 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 4 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 4 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            //Basic conditions not well maintained
            ['falure_id' => 5 ,'status' => 1 ,'weight_factor'=> 3, 'is_HOC'=> 1 ],
            ['falure_id' => 5 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 5 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 5 ,'status' => 1 ,'weight_factor'=> 3, 'is_HOC'=> 1 ],
            ['falure_id' => 5 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            //Lack of / bad facilities to perform tasks. Eg. PPE, clothing, tools
            ['falure_id' => 6 ,'status' => 1 ,'weight_factor'=> 1, 'is_HOC'=> 0 ],
            ['falure_id' => 6 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
            ['falure_id' => 6 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
            ['falure_id' => 6 ,'status' => 1 ,'weight_factor'=> 3, 'is_HOC'=> 0 ],
            ['falure_id' => 6 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
            ['falure_id' => 6 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
            ['falure_id' => 6 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 6 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 6 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 6 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 6 ,'status' => 1 ,'weight_factor'=> 3, 'is_HOC'=> 1 ],
            //Working area not well maintained.
            ['falure_id' => 7 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 7 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 7 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 7 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 7 ,'status' => 1 ,'weight_factor'=> 3, 'is_HOC'=> 1 ],
            ['falure_id' => 7 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 7 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 7 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 7 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
            ['falure_id' => 7 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
            ['falure_id' => 7 ,'status' => 1 ,'weight_factor'=> 1, 'is_HOC'=> 0 ],
            ['falure_id' => 7 ,'status' => 1 ,'weight_factor'=> 1, 'is_HOC'=> 0 ],
            ['falure_id' => 7 ,'status' => 1 ,'weight_factor'=> 1, 'is_HOC'=> 0 ],
            //Untidy / unclean working area
            ['falure_id' => 8 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 8 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 8 ,'status' => 1 ,'weight_factor'=> 3, 'is_HOC'=> 1 ],
            ['falure_id' => 8 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 8 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 8 ,'status' => 1 ,'weight_factor'=> 1, 'is_HOC'=> 0 ],
            ['falure_id' => 8 ,'status' => 1 ,'weight_factor'=> 1, 'is_HOC'=> 0 ],
            //There are unnecessary things in place
            ['falure_id' => 9 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 9 ,'status' => 1 ,'weight_factor'=> 3, 'is_HOC'=> 1 ],
            ['falure_id' => 9 ,'status' => 1 ,'weight_factor'=> 1, 'is_HOC'=> 0 ],
            //Leaking. 
            ['falure_id' => 10 ,'status' => 1 ,'weight_factor'=> 3, 'is_HOC'=> 1 ],
            ['falure_id' => 10 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
            ['falure_id' => 10 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
            //Insects
            ['falure_id' => 11 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 11 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 1 ],
            ['falure_id' => 11 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
            //Bad smell
            ['falure_id' => 12 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
            //Wastes & Waste Containers  
            ['falure_id' => 13 ,'status' => 1 ,'weight_factor'=> 3, 'is_HOC'=> 1 ],
            ['falure_id' => 13 ,'status' => 1 ,'weight_factor'=> 5, 'is_HOC'=> 0 ],
        ]);

        DB::table('m_falure_mode_detail_translation')->insert([
            //Not complied to Life Saving Rules
            ['name' => 'Hold/using handphone when driving vehicles','translation_id' => 1 , 'language_id' => 2],
            ['name' => 'Không giữ / sử dụng điện thoại di động khi lái xe ','translation_id' => 1 , 'language_id' => 1],
            ['name' => 'Not wearing seatbelt when driving vehicles','translation_id' => 2 , 'language_id' => 2],
            ['name' => 'Không thắt dây an toàn khi lái xe','translation_id' => 2 , 'language_id' => 1],
            ['name' => 'Operate vehicles when un-authorized','translation_id' => 3 , 'language_id' => 2],
            ['name' => 'Vận hành xe khi không được ủy quyền','translation_id' => 3 , 'language_id' => 1],
            ['name' => 'Chemical safety compliance','translation_id' => 4 , 'language_id' => 2],
            ['name' => 'Tuân thủ an toàn hóa chất','translation_id' => 4 , 'language_id' => 1],
            ['name' => 'LOTO compliance (LOTO is not complied with as defined)','translation_id' => 5 , 'language_id' => 2],
            ['name' => 'Tuân thủ LOTO (LOTO không được tuân thủ theo quy định)','translation_id' => 5 , 'language_id' => 1],
            ['name' => 'Safe work permit compliance','translation_id' => 6 , 'language_id' => 2],
            ['name' => 'Tuân thủ giấy phép lao động an toàn','translation_id' => 6 , 'language_id' => 1],
            ['name' => 'CO2 unsafe detected','translation_id' => 7 , 'language_id' => 2],
            ['name' => 'Phát hiện CO2 không an toàn','translation_id' => 7 , 'language_id' => 1],
            ['name' => 'Unsafe behavior detected ','translation_id' => 8 , 'language_id' => 2],
            ['name' => 'Phát hiện hành vi không an toàn','translation_id' => 8 , 'language_id' => 1],
            //Unsafe Machine
            ['name' => 'Machine safety compliance','translation_id' => 9 , 'language_id' => 2],
            ['name' => 'Tuân thủ an toàn máy','translation_id' => 9 , 'language_id' => 1],
            ['name' => 'Radiation safety compliance','translation_id' => 10 , 'language_id' => 2],
            ['name' => 'Tuân thủ an toàn bức xạ','translation_id' => 10 , 'language_id' => 1],
            ['name' => 'Use of inappropriate tools (Self-created tools, wrong tools) ','translation_id' => 11 , 'language_id' => 2],
            ['name' => 'Sử dụng các công cụ không phù hợp (Công cụ tự tạo, công cụ sai)','translation_id' => 11 , 'language_id' => 1],
            //Unsafe Facility / Storage
            ['name' => 'Windowpanes and lamps protected against breakage','translation_id' => 12 , 'language_id' => 2],
            ['name' => 'Cửa sổ và đèn được bảo vệ chống vỡ','translation_id' => 12 , 'language_id' => 1],
            ['name' => 'Safety exits - unblocked and clearly labelled','translation_id' => 13 , 'language_id' => 2],
            ['name' => 'Lối thoát an toàn - bỏ chặn và dán nhãn rõ ràng','translation_id' => 13 , 'language_id' => 1],
            ['name' => 'Entry to production area clearly labelled with safety signs','translation_id' => 14 , 'language_id' => 2],
            ['name' => 'Vào khu vực sản xuất được dán nhãn rõ ràng với các dấu hiệu an toàn','translation_id' => 14 , 'language_id' => 1],
            ['name' => 'Electrical installations','translation_id' => 15 , 'language_id' => 2],
            ['name' => 'Lắp đặt điện','translation_id' => 15 , 'language_id' => 1],
            ['name' => 'Fire extinguisher, fire safety','translation_id' => 16 , 'language_id' => 2],
            ['name' => 'Bình chữa cháy, an toàn phòng cháy chữa cháy','translation_id' => 16 , 'language_id' => 1],
            ['name' => 'Emergency water shower ','translation_id' => 17 , 'language_id' => 2],
            ['name' => 'Vòi cứu hỏa khẩn cấp','translation_id' => 17 , 'language_id' => 1],
            ['name' => 'No separation of liquid and solid chemical, acids and bases','translation_id' => 18 , 'language_id' => 2],
            ['name' => 'Không tách chất lỏng và hóa chất rắn, axit và bazơ','translation_id' => 18 , 'language_id' => 1],
            ['name' => 'Spill kits for chemical spillages (acids, bases …) such as: full set of spill kit, sand, shovels, spillage collector…etc','translation_id' => 19 , 'language_id' => 2],
            ['name' => 'Bộ dụng cụ chống tràn cho các sự cố tràn hóa chất (axit, bazơ) như: bộ đầy đủ bộ dụng cụ tràn, cát, xẻng, bộ thu gom đổ tràn vv','translation_id' => 19 , 'language_id' => 1],
            //Unsafe Acts
            ['name' => 'Authorized personnel working only','translation_id' => 20 , 'language_id' => 2],
            ['name' => 'Nhân viên được ủy quyền chỉ làm việc','translation_id' => 20 , 'language_id' => 1],
            ['name' => 'Use of personal protective equipment (PPE) and clothing as required','translation_id' => 21 , 'language_id' => 2],
            ['name' => 'Sử dụng thiết bị bảo hộ cá nhân (PPE) và quần áo theo yêu cầu','translation_id' => 21 , 'language_id' => 1],
            ['name' => 'Wearing of correct, clean, company clothing ','translation_id' => 22 , 'language_id' => 2],
            ['name' => 'Mặc quần áo đúng cách, sạch sẽ, công ty','translation_id' => 22 , 'language_id' => 1],
            ['name' => 'Consumption of food and non-alcoholic beverages in areas where this is permitted','translation_id' => 23 , 'language_id' => 2],
            ['name' => 'Tiêu thụ thực phẩm và đồ uống không cồn trong khu vực được phép','translation_id' => 23 , 'language_id' => 1],
            ['name' => 'Smoking only in rooms where this is permitted','translation_id' => 24 , 'language_id' => 2],
            ['name' => 'Chỉ hút thuốc trong phòng được phép','translation_id' => 24 , 'language_id' => 1],
            //Basic conditions not well maintained
            ['name' => 'Leakage repaired without delay (installations and transfer lines)','translation_id' => 25 , 'language_id' => 2],
            ['name' => 'Rò rỉ được sửa chữa không chậm trễ (cài đặt và chuyển đường)','translation_id' => 25 , 'language_id' => 1],
            ['name' => 'Installations - hygienically designed, clean, well maintained, flow directions and medium indicated','translation_id' => 26 , 'language_id' => 2],
            ['name' => 'Lắp đặt - được thiết kế hợp vệ sinh, sạch sẽ, được bảo trì tốt, hướng dòng chảy và phương tiện được chỉ định','translation_id' => 26 , 'language_id' => 1],
            ['name' => 'Equipment- hygienically designed, clean, well maintained (without leaks,protected, with appropriate safety signs)','translation_id' => 27 , 'language_id' => 2],
            ['name' => 'Thiết bị - được thiết kế hợp vệ sinh, sạch sẽ, được bảo trì tốt (không rò rỉ, được bảo vệ, có dấu hiệu an toàn phù hợp)','translation_id' => 27 , 'language_id' => 1],
            ['name' => 'Unnecessary equipment, parts lying about this','translation_id' => 28 , 'language_id' => 2],
            ['name' => 'Thiết bị không cần thiết, bộ phận nói dối về này','translation_id' => 28 , 'language_id' => 1],
            ['name' => 'Makeshift repairs, rope and tape','translation_id' => 29 , 'language_id' => 2],
            ['name' => 'Sửa chữa ca, dây và băng','translation_id' => 29 , 'language_id' => 1],
            //Lack of / bad facilities to perform tasks. Eg. PPE, clothing, tools
            ['name' => 'Are the visual 5S standard available on site?','translation_id' => 30 , 'language_id' => 2],
            ['name' => 'Là tiêu chuẩn 5S trực quan có sẵn trên trang web?','translation_id' => 30 , 'language_id' => 1],
            ['name' => 'Spill kits for chemical spillages (acids, bases …) such as: full set of spill kit, sand, shovels, spillage collector…etc','translation_id' => 31 , 'language_id' => 2],
            ['name' => 'Bộ dụng cụ chống tràn cho các sự cố tràn hóa chất (axit, bazơ) như: bộ đầy đủ bộ dụng cụ tràn, cát, xẻng, bộ thu gom đổ tràn vv','translation_id' => 31 , 'language_id' => 1],
            ['name' => 'First aid facilities','translation_id' => 32 , 'language_id' => 2],
            ['name' => 'Cơ sở sơ cứu','translation_id' => 32 , 'language_id' => 1],
            ['name' => 'Emergency water shower','translation_id' => 33 , 'language_id' => 2],
            ['name' => 'Vòi cứu hỏa khẩn cấp','translation_id' => 33 , 'language_id' => 1],
            ['name' => 'Fire extinguisher, fire safety','translation_id' => 34 , 'language_id' => 2],
            ['name' => 'Bình chữa cháy, an toàn phòng cháy chữa cháy','translation_id' => 34 , 'language_id' => 1],
            ['name' => 'Use of inappropriate tools (Self-created tools, wrong tools)','translation_id' => 35 , 'language_id' => 2],
            ['name' => 'Sử dụng các công cụ không phù hợp (Công cụ tự tạo, công cụ sai)','translation_id' => 35 , 'language_id' => 1],
            ['name' => 'Operating and work instructions clean and legible (no dirt or mould growth)','translation_id' => 36 , 'language_id' => 2],
            ['name' => 'Hướng dẫn vận hành và làm việc sạch sẽ và dễ đọc (không có bụi bẩn hoặc nấm mốc phát triển)','translation_id' => 36 , 'language_id' => 1],
            ['name' => 'Cleaning equipment properly stored, labelled and easily accessible','translation_id' => 37 , 'language_id' => 2],
            ['name' => 'Thiết bị làm sạch được lưu trữ đúng cách, được dán nhãn và dễ dàng truy cập','translation_id' => 37 , 'language_id' => 1],
            ['name' => 'Suitable area for operator records','translation_id' => 38 , 'language_id' => 2],
            ['name' => 'Khu vực thích hợp cho hồ sơ điều hành','translation_id' => 38 , 'language_id' => 1],
            ['name' => 'Ventilation systems, grids - clean, well maintained, in order,','translation_id' => 39 , 'language_id' => 2],
            ['name' => 'Hệ thống thông gió, lưới điện - sạch sẽ, được bảo trì tốt, theo thứ tự,','translation_id' => 39 , 'language_id' => 1],
            ['name' => 'Toilets / Changing areas/Eating areas (location, technical conditions, equipment, cleanliness)','translation_id' => 40 , 'language_id' => 2],
            ['name' => 'Nhà vệ sinh / Thay đổi khu vực / Khu vực ăn uống (vị trí, điều kiện kỹ thuật, thiết bị, vệ sinh)','translation_id' => 40 , 'language_id' => 1],
            //Working area not well maintained.
            ['name' => 'Floors, stairs properly maintained','translation_id' => 41 , 'language_id' => 2],
            ['name' => 'Sàn nhà, cầu thang được bảo trì đúng cách','translation_id' => 41 , 'language_id' => 1],
            ['name' => 'Walls in good condition and properly maintained','translation_id' => 42 , 'language_id' => 2],
            ['name' => 'Trần trong tình trạng tốt, sạch sẽ, không có vết nứt hoặc rò rỉ','translation_id' => 42 , 'language_id' => 1],
            ['name' => 'Ceilings in good condition, clean, no cracks or leaks','translation_id' => 43 , 'language_id' => 2],
            ['name' => 'Hệ thống thông gió, lưới điện - sạch sẽ, được bảo trì tốt, theo thứ tự,','translation_id' => 43 , 'language_id' => 1],
            ['name' => 'Windowpanes and lamps protected against breakage','translation_id' => 44 , 'language_id' => 2],
            ['name' => 'Cửa sổ và đèn được bảo vệ chống vỡ','translation_id' => 44 , 'language_id' => 1],
            ['name' => 'Damage repaired without delay (external walls, internal constructions)','translation_id' => 45 , 'language_id' => 2],
            ['name' => 'Hư hỏng được sửa chữa không chậm trễ (tường ngoài, công trình bên trong)','translation_id' => 45 , 'language_id' => 1],
            ['name' => 'Installations - hygienically designed, clean, well maintained, flow directions and medium indicated','translation_id' => 46 , 'language_id' => 2],
            ['name' => 'Lắp đặt - được thiết kế hợp vệ sinh, sạch sẽ, được bảo trì tốt, hướng dòng chảy và phương tiện được chỉ định','translation_id' => 46 , 'language_id' => 1],
            ['name' => 'Doors and windows closed (where possible)','translation_id' => 47 , 'language_id' => 2],
            ['name' => 'Cửa ra vào và cửa sổ đóng lại (nếu có thể)','translation_id' => 47 , 'language_id' => 1],
            ['name' => 'Makeshift repairs, rope and tape','translation_id' => 48 , 'language_id' => 2],
            ['name' => 'Sửa chữa ca, dây và băng','translation_id' => 48 , 'language_id' => 1],
            ['name' => 'Leakage of oils, lubricants, cautics and other energy resources & chemicals…','translation_id' => 49 , 'language_id' => 2],
            ['name' => 'Rò rỉ dầu, chất bôi trơn, cautics và các nguồn năng lượng & hóa chất khác','translation_id' => 49 , 'language_id' => 1],
            ['name' => 'Litter or put wastes in wrong rubbish bins','translation_id' => 50 , 'language_id' => 2],
            ['name' => 'Xả rác hoặc bỏ chất thải vào thùng rác sai','translation_id' => 50 , 'language_id' => 1],
            ['name' => 'Are there any unnecessary items at the area?','translation_id' => 51 , 'language_id' => 2],
            ['name' => 'Có bất kỳ mục không cần thiết trong khu vực?','translation_id' => 51 , 'language_id' => 1],
            ['name' => 'Are all updated/needed items stored in their defined locations?','translation_id' => 52 , 'language_id' => 2],
            ['name' => 'Có phải tất cả các mục cập nhật / cần thiết được lưu trữ trong vị trí xác định của họ?','translation_id' => 52 , 'language_id' => 1],
            ['name' => 'Are the critical areas inspected & cleaned according to the standards?','translation_id' => 53 , 'language_id' => 2],
            ['name' => 'Các khu vực quan trọng được kiểm tra và làm sạch theo các tiêu chuẩn?','translation_id' => 53 , 'language_id' => 1],
            //Untidy / unclean working area
            ['name' => 'Accumulation of dirt/fungi in corners and on surfaces','translation_id' => 54 , 'language_id' => 2],
            ['name' => 'Tích tụ bụi bẩn / nấm ở các góc và trên bề mặt','translation_id' => 54 , 'language_id' => 1],
            ['name' => 'Prevent litter (cigarette butts, bolts, plastic cups, etc.)','translation_id' => 55 , 'language_id' => 2],
            ['name' => 'Ngăn ngừa xả rác (tàn thuốc lá, bu lông, cốc nhựa, v.v.)','translation_id' => 55 , 'language_id' => 1],
            ['name' => 'Suitable area for operator records','translation_id' => 56 , 'language_id' => 2],
            ['name' => 'Khu vực thích hợp cho hồ sơ điều hành','translation_id' => 56 , 'language_id' => 1],
            ['name' => 'Cleaning equipment properly stored, labelled and easily accessible)','translation_id' => 57 , 'language_id' => 2],
            ['name' => 'Thiết bị làm sạch được lưu trữ đúng cách, được dán nhãn và dễ dàng truy cập','translation_id' => 57 , 'language_id' => 1],
            ['name' => 'Operating and work instructions clean and legible (no dirt or mould growth)','translation_id' => 58 , 'language_id' => 2],
            ['name' => 'Hướng dẫn vận hành và làm việc sạch sẽ và dễ đọc (không có bụi bẩn hoặc nấm mốc phát triển)','translation_id' => 58 , 'language_id' => 1],
            ['name' => 'Are the critical areas inspected & cleaned according to the standards?','translation_id' => 59 , 'language_id' => 2],
            ['name' => 'Các khu vực quan trọng được kiểm tra và làm sạch theo các tiêu chuẩn?' ,'translation_id'=> 59 , 'language_id' => 1],
            ['name' => 'Are the visual 5S standard available on site?','translation_id' => 60 , 'language_id' => 2],
            ['name' => 'Là tiêu chuẩn 5S trực quan có sẵn trên trang web?','translation_id' => 60 , 'language_id' => 1],
            //There are unnecessary things in place
            ['name' => 'Food contact materials (no unnecessary wooden materials in the production area)','translation_id' => 61 , 'language_id' => 2],
            ['name' => 'Vật liệu tiếp xúc thực phẩm (không có vật liệu gỗ không cần thiết trong khu vực sản xuất)','translation_id' => 61 , 'language_id' => 1],
            ['name' => 'Unnecessary equipment, parts lying about','translation_id' => 62 , 'language_id' => 2],
            ['name' => 'Thiết bị không cần thiết, bộ phận nói dối về','translation_id' => 62 , 'language_id' => 1],
            ['name' => 'Are there any unnecessary items at the area?','translation_id' => 63 , 'language_id' => 2],
            ['name' => 'Có bất kỳ mục không cần thiết trong khu vực?','translation_id' => 63 , 'language_id' => 1],
            //Leaking. 
            ['name' => 'Leakage repaired without delay (installations and transfer lines)','translation_id' => 64 , 'language_id' => 2],
            ['name' => 'Rò rỉ được sửa chữa không chậm trễ (cài đặt và chuyển đường)','translation_id' => 64 , 'language_id' => 1],
            ['name' => 'Leakage of oils, lubricants, cautics and other energy resources & chemicals…','translation_id' => 65 , 'language_id' => 2],
            ['name' => 'Rò rỉ dầu, chất bôi trơn, cautics và các nguồn năng lượng & hóa chất khác','translation_id' => 65 , 'language_id' => 1],
            ['name' => 'Spill kits for chemical spillages (acids, bases …) such as: full set of spill kit, sand, shovels, spillage collector…etc','translation_id' => 66 , 'language_id' => 2],
            ['name' => 'Bộ dụng cụ chống tràn cho các sự cố tràn hóa chất (axit, bazơ) như: bộ đầy đủ bộ dụng cụ tràn, cát, xẻng, bộ thu gom đổ tràn vv','translation_id' => 66 , 'language_id' => 1],
            //Insects
            ['name' => 'Measures to combat vermin (rodent traps, no evidence of vermin droppings)','translation_id' => 67 , 'language_id' => 2],
            ['name' => 'Các biện pháp chống lại sâu bọ (bẫy chuột, không có bằng chứng về phân trùn quế)','translation_id' => 67 , 'language_id' => 1],
            ['name' => 'Accumulation of dirt/fungi in corners and on surfaces','translation_id' => 68 , 'language_id' => 2],
            ['name' => 'Tích tụ bụi bẩn / nấm ở các góc và trên bề mặt','translation_id' => 68 , 'language_id' => 1],
            ['name' => 'Present of any kind of pests','translation_id' => 69 , 'language_id' => 2],
            ['name' => 'Hiện tại của bất kỳ loại sâu bệnh','translation_id' => 69 , 'language_id' => 1],
            //Bad smell
            ['name' => 'Bad smell, odor from organic disintegation','translation_id' => 70 , 'language_id' => 2],
            ['name' => 'Mùi hôi, mùi từ sự tan rã hữu cơ','translation_id' => 70 , 'language_id' => 1],
            //Wastes & Waste Containers 
            ['name' => 'Waste containers - suitable, correctly labelled, containing only correct litter','translation_id' => 71 , 'language_id' => 2],
            ['name' => 'Thùng chứa chất thải - phù hợp, được dán nhãn chính xác, chỉ chứa rác đúng','translation_id' => 71 , 'language_id' => 1],
            ['name' => 'Spill kits for chemical spillages (acids, bases …) such as: full set of spill kit, sand, shovels, spillage collector…etc','translation_id' => 72 , 'language_id' => 2],
            ['name' => 'Bộ dụng cụ chống tràn cho các sự cố tràn hóa chất (axit, bazơ) như: bộ đầy đủ bộ dụng cụ tràn, cát, xẻng, bộ thu gom đổ tràn vv','translation_id' => 72 , 'language_id' => 1],
        ]);
    }
}
