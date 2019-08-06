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

        DB::table('config_language')->insert([
            [
                'name' => 'Tiếng Việt',
                'code' => 'vi',
                'default' => 1,
                'currency_code' => 'VNĐ',
                'date_format' => 'd-m-Y'
            ],
            [
                'name' => 'Tiếng Anh',
                'code' => 'en',
                'default' => 0,
                'currency_code' => 'USD',
                'date_format' => 'd M Y'
            ],
        ]);
        
        DB::table('m_line')->insert([
            ['status' => 1 ],
            ['status' => 1 ],
            ['status' => 1 ],
        ]);

        DB::table('m_line_translation')->insert([
            ['name' => 'Bottling_en', 'translation_id' => 1, 'language_id' => 2 ],
            ['name' => 'Bottling_vn', 'translation_id' => 1, 'language_id' => 1 ],

            ['name' => 'Canning_en', 'translation_id' => 2, 'language_id' => 2 ],
            ['name' => 'Canning_vn', 'translation_id' => 2, 'language_id' => 1 ],

            ['name' => 'Kegging_en', 'translation_id' => 3, 'language_id' => 2 ],
            ['name' => 'Kegging_vn', 'translation_id' => 3, 'language_id' => 1 ]
        ]);

        DB::table('m_area')->insert([
            //CNTT
            ['line_id' => 1, 'status' => 1 ],
            ['line_id' => 1, 'status' => 1 ],
            ['line_id' => 1, 'status' => 1 ],

            //QLDD
            ['line_id' => 2, 'status' => 1 ],
            ['line_id' => 2, 'status' => 1 ],

            //CTT
            ['line_id' => 3, 'status' => 1 ],
            ['line_id' => 3, 'status' => 1 ],
        ]);

        DB::table('m_area_translation')->insert([
            ['name' => 'Bottle conveyor Filler area', 'translation_id' => 1, 'language_id' => 2 ],
            ['name' => 'Bottle conveyor Filler area', 'translation_id' => 1, 'language_id' => 1 ],
            ['name' => 'Bottle conveyor from Labellers to Packer', 'translation_id' => 2, 'language_id' => 2 ],
            ['name' => 'Bottle conveyor from Labellers to Packer', 'translation_id' => 2, 'language_id' => 1 ],
            ['name' => 'Bottle conveyor from Pasteurizer to Labellers', 'translation_id' => 3, 'language_id' => 2 ],
            ['name' => 'Bottle conveyor from Pasteurizer to Labellers', 'translation_id' => 3, 'language_id' => 1 ],

            ['name' => 'Can conveyor from Depalletizer to Rinser', 'translation_id' => 4, 'language_id' => 2 ],
            ['name' => 'Can conveyor from Depalletizer to Rinser', 'translation_id' => 4, 'language_id' => 1 ],
            ['name' => 'Can Conveyor from Filler to WAs', 'translation_id' => 5, 'language_id' => 2 ],
            ['name' => 'Can Conveyor from Filler to WAs', 'translation_id' => 5, 'language_id' => 1 ],
            
            ['name' => 'Filling area', 'translation_id' => 6, 'language_id' => 2 ],
            ['name' => 'Filling area', 'translation_id' => 6, 'language_id' => 1 ],
            ['name' => 'Packing area', 'translation_id' => 7, 'language_id' => 2 ],
            ['name' => 'Packing area', 'translation_id' => 7, 'language_id' => 1 ],
        ]);

        DB::table('m_device')->insert([
            ['area_id' => 1, 'status' => 1 ],
            ['area_id' => 1, 'status' => 1 ],
            ['area_id' => 2, 'status' => 1 ],
            ['area_id' => 2, 'status' => 1 ],
            ['area_id' => 3, 'status' => 1 ],
            ['area_id' => 3, 'status' => 1 ],


            ['area_id' => 4, 'status' => 1 ],
            ['area_id' => 4, 'status' => 1 ],
            ['area_id' => 5, 'status' => 1 ],
            ['area_id' => 5, 'status' => 1 ],

            ['area_id' => 6, 'status' => 1 ],
            ['area_id' => 6, 'status' => 1 ],
            ['area_id' => 7, 'status' => 1 ],
            ['area_id' => 7, 'status' => 1 ],

        ]);

        DB::table('m_device_translation')->insert([
            ['name' => 'BL2-Bottle Conveyor From Filler To Pasteurizer', 'translation_id' => 1, 'language_id' => 2 ],
            ['name' => 'BL2-Bottle Conveyor From Filler To Pasteurizer', 'translation_id' => 1, 'language_id' => 1 ],
            ['name' => 'BL2-Change part Filler', 'translation_id' => 2, 'language_id' => 2 ],
            ['name' => 'BL2-Change part Filler', 'translation_id' => 2, 'language_id' => 1 ],
            ['name' => 'BL2-Bottle Conveyor From Labeler To Packer and WAX system', 'translation_id' => 3, 'language_id' => 2 ],
            ['name' => 'BL2-Bottle Conveyor From Labeler To Packer and WAX system', 'translation_id' => 3, 'language_id' => 1 ],
            ['name' => 'BL2-Bottle Conveyor From Pasteurizer To Labeller and Air Driers', 'translation_id' => 4, 'language_id' => 2 ],
            ['name' => 'BL2-Bottle Conveyor From Pasteurizer To Labeller and Air Driers', 'translation_id' => 4, 'language_id' => 1 ],
            ['name' => 'BL2-Bottle Conveyer From Unpacker To Washer', 'translation_id' => 5, 'language_id' => 2 ],
            ['name' => 'BL2-Bottle Conveyer From Unpacker To Washer', 'translation_id' => 5, 'language_id' => 1 ],
            ['name' => 'BL2-Bottle Conveyor From Washer To EBI', 'translation_id' => 6, 'language_id' => 2 ],
            ['name' => 'BL2-Bottle Conveyor From Washer To EBI', 'translation_id' => 6, 'language_id' => 1 ],

            ['name' => 'CL4-Can Conveyer From Pasteurizer To Wrap Around And FHIs', 'translation_id' => 1, 'language_id' => 2 ],
            ['name' => 'CL4-Can Conveyer From Pasteurizer To Wrap Around And FHIs', 'translation_id' => 1, 'language_id' => 1 ],
            ['name' => 'CL4-Can Crusher', 'translation_id' => 2, 'language_id' => 2 ],
            ['name' => 'CL4-Can Crusher', 'translation_id' => 2, 'language_id' => 1 ],
            ['name' => 'CL4-Carton Conveyer From Wrap Around 01 To Divider', 'translation_id' => 3, 'language_id' => 2 ],
            ['name' => 'CL4-Carton Conveyer From Wrap Around 01 To Divider', 'translation_id' => 3, 'language_id' => 1 ],
            ['name' => 'CL4-Carton Conveyer From Wrap Around 02 To Divider', 'translation_id' => 4, 'language_id' => 2 ],
            ['name' => 'CL4-Carton Conveyer From Wrap Around 02 To Divider', 'translation_id' => 4, 'language_id' => 1 ],

            ['name' => 'KL6-Plate Chain Conveyer From Filler To Palletizer', 'translation_id' => 1, 'language_id' => 2 ],
            ['name' => 'KL6-Plate Chain Conveyer From Filler To Palletizer', 'translation_id' => 1, 'language_id' => 1 ],
            ['name' => 'KL6-Keg Palletizer', 'translation_id' => 2, 'language_id' => 2 ],
            ['name' => 'KL6-Keg Palletizer', 'translation_id' => 2, 'language_id' => 1 ],
            ['name' => 'KL6-Roller Conveyor Segment', 'translation_id' => 3, 'language_id' => 2 ],
            ['name' => 'KL6-Roller Conveyor Segment', 'translation_id' => 3, 'language_id' => 1 ],
            ['name' => 'KL6-Plate Chain Conveyer Segment', 'translation_id' => 4, 'language_id' => 2 ],
            ['name' => 'KL6-Plate Chain Conveyer Segment', 'translation_id' => 4, 'language_id' => 1 ],
        ]);
    }
}
