<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DeviceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_major')->insert([
            ['status' => 1 ],
            ['status' => 1 ],
            ['status' => 1 ],
        ]);

        DB::table('m_major_translation')->insert([
            ['name' => 'CNTT_en', 'translation_id' => 1, 'language_id' => 2 ],
            ['name' => 'CNTT_vn', 'translation_id' => 1, 'language_id' => 1 ],

            ['name' => 'QLDD_en', 'translation_id' => 2, 'language_id' => 2 ],
            ['name' => 'QLDD_vn', 'translation_id' => 2, 'language_id' => 1 ],

            ['name' => 'CTT_en', 'translation_id' => 3, 'language_id' => 2 ],
            ['name' => 'CTT_vn', 'translation_id' => 3, 'language_id' => 1 ]
        ]);

        DB::table('m_course')->insert([
            //CNTT
            ['major_id' => 1, 'status' => 1 ],
            ['major_id' => 1, 'status' => 1 ],
            ['major_id' => 1, 'status' => 1 ],

            //QLDD
            ['major_id' => 2, 'status' => 1 ],
            ['major_id' => 2, 'status' => 1 ],

            //CTT
            ['major_id' => 3, 'status' => 1 ],
            ['major_id' => 3, 'status' => 1 ],
        ]);

        DB::table('m_course_translation')->insert([
            ['name' => 'CNTT_Course_01', 'translation_id' => 1, 'language_id' => 2 ],
            ['name' => 'CNTT_Khóa_01', 'translation_id' => 1, 'language_id' => 1 ],
            ['name' => 'CNTT_Course_02', 'translation_id' => 2, 'language_id' => 2 ],
            ['name' => 'CNTT_Khóa_02', 'translation_id' => 2, 'language_id' => 1 ],
            ['name' => 'CNTT_Course_03', 'translation_id' => 3, 'language_id' => 2 ],
            ['name' => 'CNTT_Khóa_03', 'translation_id' => 3, 'language_id' => 1 ],

            ['name' => 'QLDD_Course_01', 'translation_id' => 4, 'language_id' => 2 ],
            ['name' => 'QLDD_Khóa_01', 'translation_id' => 4, 'language_id' => 1 ],
            ['name' => 'QLDD_Course_02', 'translation_id' => 5, 'language_id' => 2 ],
            ['name' => 'QLDD_Khóa_02', 'translation_id' => 5, 'language_id' => 1 ],
            
            ['name' => 'CTT_Course_01', 'translation_id' => 6, 'language_id' => 2 ],
            ['name' => 'CTT_Khóa_01', 'translation_id' => 6, 'language_id' => 1 ],
            ['name' => 'CTT_Course_02', 'translation_id' => 7, 'language_id' => 2 ],
            ['name' => 'CTT_Khóa_02', 'translation_id' => 7, 'language_id' => 1 ],
        ]);

        DB::table('m_class')->insert([
            ['course_id' => 1, 'status' => 1 ],
            ['course_id' => 1, 'status' => 1 ],
            ['course_id' => 2, 'status' => 1 ],
            ['course_id' => 2, 'status' => 1 ],
            ['course_id' => 3, 'status' => 1 ],
            ['course_id' => 3, 'status' => 1 ],


            ['course_id' => 4, 'status' => 1 ],
            ['course_id' => 4, 'status' => 1 ],
            ['course_id' => 5, 'status' => 1 ],
            ['course_id' => 5, 'status' => 1 ],

            ['course_id' => 6, 'status' => 1 ],
            ['course_id' => 6, 'status' => 1 ],
            ['course_id' => 7, 'status' => 1 ],
            ['course_id' => 7, 'status' => 1 ],

        ]);

        DB::table('m_class_translation')->insert([
            ['name' => '01DHCNTT1_en', 'translation_id' => 1, 'language_id' => 2 ],
            ['name' => '01DHCNTT1_en', 'translation_id' => 1, 'language_id' => 1 ],
            ['name' => '01DHCNTT2_en', 'translation_id' => 2, 'language_id' => 2 ],
            ['name' => '01DHCNTT2_en', 'translation_id' => 2, 'language_id' => 1 ],
            ['name' => '02DHCNTT1_en', 'translation_id' => 3, 'language_id' => 2 ],
            ['name' => '02DHCNTT1_en', 'translation_id' => 3, 'language_id' => 1 ],
            ['name' => '02DHCNTT2_en', 'translation_id' => 4, 'language_id' => 2 ],
            ['name' => '02DHCNTT2_en', 'translation_id' => 4, 'language_id' => 1 ],
            ['name' => '03DHCNTT1_en', 'translation_id' => 5, 'language_id' => 2 ],
            ['name' => '03DHCNTT1_en', 'translation_id' => 5, 'language_id' => 1 ],
            ['name' => '03DHCNTT2_en', 'translation_id' => 6, 'language_id' => 2 ],
            ['name' => '03DHCNTT2_en', 'translation_id' => 6, 'language_id' => 1 ],

            ['name' => '01DHQLDD1_en', 'translation_id' => 1, 'language_id' => 2 ],
            ['name' => '01DHQLDD1_en', 'translation_id' => 1, 'language_id' => 1 ],
            ['name' => '01DHQLDD2_en', 'translation_id' => 2, 'language_id' => 2 ],
            ['name' => '01DHQLDD2_en', 'translation_id' => 2, 'language_id' => 1 ],
            ['name' => '02DHQLDD1_en', 'translation_id' => 3, 'language_id' => 2 ],
            ['name' => '02DHQLDD1_en', 'translation_id' => 3, 'language_id' => 1 ],
            ['name' => '02DHQLDD2_en', 'translation_id' => 4, 'language_id' => 2 ],
            ['name' => '02DHQLDD2_en', 'translation_id' => 4, 'language_id' => 1 ],

            ['name' => '01DHCTT1_en', 'translation_id' => 1, 'language_id' => 2 ],
            ['name' => '01DHCTT1_en', 'translation_id' => 1, 'language_id' => 1 ],
            ['name' => '01DHCTT2_en', 'translation_id' => 2, 'language_id' => 2 ],
            ['name' => '01DHCTT2_en', 'translation_id' => 2, 'language_id' => 1 ],
            ['name' => '02DHCTT1_en', 'translation_id' => 3, 'language_id' => 2 ],
            ['name' => '02DHCTT1_en', 'translation_id' => 3, 'language_id' => 1 ],
            ['name' => '02DHCTT2_en', 'translation_id' => 4, 'language_id' => 2 ],
            ['name' => '02DHCTT2_en', 'translation_id' => 4, 'language_id' => 1 ],
        ]);
    }
}
