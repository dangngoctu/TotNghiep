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
            ['name' => 'Document','translation_id' => 1 , 'language_id' => 2 ],
            ['name' => 'Tài liệu','translation_id' => 1, 'language_id' => 1 ],
            ['name' => 'Preparation','translation_id' => 2,'language_id' => 2 ],
            ['name' => 'Sự chuẩn bị','translation_id' => 2 ,'language_id' => 1],
            ['name' => 'Presentation','translation_id' => 3 ,'language_id' => 2],
            ['name' => 'Thuyết trình','translation_id' => 3 ,'language_id' => 1],
            ['name' => 'Order','translation_id' => 4 ,'language_id' => 2],
            ['name' => 'Những thứ khác','translation_id' => 4 ,'language_id' => 1],
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

        ]);

        DB::table('m_falure_mode_translation')->insert([
            //Document
            ['name' => 'Document is blurred','translation_id' => 1 , 'language_id' => 2],
            ['name' => 'Tài liệu bị mờ','translation_id' => 1 , 'language_id' => 1],
            ['name' => 'Missing of signature','translation_id' => 2 , 'language_id' => 2],
            ['name' => 'Thiếu chữ ký của giảng viên','translation_id' => 2 , 'language_id' => 1],
            ['name' => 'Sketchy documents','translation_id' => 3 , 'language_id' => 2],
            ['name' => 'Tài liệu sơ sài','translation_id' => 3 , 'language_id' => 1],
            ['name' => 'Copy content of others','translation_id' => 4 , 'language_id' => 2],
            ['name' => 'Sao chép nội dung của người khác','translation_id' => 4 , 'language_id' => 1],
            //Preparation
            ['name' => 'Lack device','translation_id' => 5 , 'language_id' => 2],
            ['name' => 'Thiếu thiết bị cần thiết','translation_id' => 5 , 'language_id' => 1],
            ['name' => 'Invalid uniform','translation_id' => 6 , 'language_id' => 2],
            ['name' => 'Đồng phục không phù hợp','translation_id' => 6 , 'language_id' => 1],
            //Presentation
            ['name' => 'Speaking not fluently','translation_id' => 7 , 'language_id' => 2],
            ['name' => 'Nói không lưu loát','translation_id' => 7 , 'language_id' => 1],
            ['name' => 'Do not respect','translation_id' => 8 , 'language_id' => 2],
            ['name' => 'Không tôn trọng giảng viên','translation_id' => 8 , 'language_id' => 1],
            ['name' => 'Lack of cooperation','translation_id' => 9 , 'language_id' => 2],
            ['name' => 'Thiếu hợp tác','translation_id' => 9 , 'language_id' => 1],
            ['name' => 'Untruthful','translation_id' => 10 , 'language_id' => 2],
            ['name' => 'Không trung thực','translation_id' => 10 , 'language_id' => 1],
            //Ngoài luồng
        ]);
    }
}
