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
            ['name' => 'Machine / Facility','translation_id' => 2,'language_id' => 2 ],
            ['name' => 'Cơ sở máy móc','translation_id' => 2 ,'language_id' => 1],
            ['name' => 'Environment','translation_id' => 3 ,'language_id' => 2],
            ['name' => 'Môi trường','translation_id' => 3 ,'language_id' => 1],
            ['name' => 'Orderliness','translation_id' => 4 ,'language_id' => 2],
            ['name' => 'Ngoài luồng','translation_id' => 4 ,'language_id' => 1],
        ]);

        DB::table('m_failure_mode')->insert([
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
        ]);

        DB::table('m_failure_mode_translation')->insert([
            //Safety
            ['name' => 'Not complied to Life Saving Rules','translation_id' => 1 , 'language_id' => 2],
            ['name' => 'Không tuân thủ các quy tắc cứu sinh','translation_id' => 1 , 'language_id' => 1],
            ['name' => 'Unsafe Machine','translation_id' => 2 , 'language_id' => 2],
            ['name' => 'Máy móc không an toàn','translation_id' => 2 , 'language_id' => 1],
            ['name' => 'Unsafe Facility / Storage','translation_id' => 3 , 'language_id' => 2],
            ['name' => 'Cơ sở / Kho lưu trữ không an toàn','translation_id' => 3 , 'language_id' => 1],
            ['name' => 'Unsafe Acts','translation_id' => 4 , 'language_id' => 2],
            ['name' => 'Hành vi không an toàn','translation_id' => 4 , 'language_id' => 1],
            //Machine / Facility
            ['name' => 'Basic conditions not well maintained','translation_id' => 5 , 'language_id' => 2],
            ['name' => 'Điều kiện cơ bản không được duy trì tốt','translation_id' => 5 , 'language_id' => 1],
            ['name' => 'Lack of / bad facilities to perform tasks. Eg. PPE, clothing, tools','translation_id' => 6 , 'language_id' => 2],
            ['name' => 'Thiếu / cơ sở xấu để thực hiện nhiệm vụ. Ví dụ. PPE, quần áo, dụng cụ','translation_id' => 6 , 'language_id' => 1],
            //Environment
            ['name' => 'Leaking. Eg. Chemicals, water, energy resources','translation_id' => 7 , 'language_id' => 2],
            ['name' => 'Rò rỉ. Ví dụ. Hóa chất, nước, tài nguyên năng lượng','translation_id' => 7 , 'language_id' => 1],
            ['name' => 'Bad smell','translation_id' => 8 , 'language_id' => 2],
            ['name' => 'Có mùi','translation_id' => 8 , 'language_id' => 1],
            ['name' => 'Wastes & Waste Containers','translation_id' => 9 , 'language_id' => 2],
            ['name' => 'Chất thải và thùng chứa chất thải','translation_id' => 9 , 'language_id' => 1],
            ['name' => 'Working area not well maintained. Eg. room, floor, ceiling wall, stair, window  ','translation_id' => 10 , 'language_id' => 2],
            ['name' => 'Khu vực làm việc không được bảo trì tốt. Ví dụ. phòng, sàn, tường trần, cầu thang, cửa sổ','translation_id' => 10 , 'language_id' => 1],
            //Ngoài luồng
            ['name' => 'There are unnecessary things in place','translation_id' => 11 , 'language_id' => 2],
            ['name' => 'Có những thứ không cần thiết tại đây','translation_id' => 11 , 'language_id' => 1],
            ['name' => 'Visual Management & Boards are not well maintained','translation_id' => 12 , 'language_id' => 2],
            ['name' => 'Quản lý hình ảnh & bảng không được duy trì tốt','translation_id' => 12 , 'language_id' => 1],
        ]);
    }
}
