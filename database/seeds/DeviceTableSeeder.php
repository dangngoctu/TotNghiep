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
        DB::table('m_site')->insert([
            ['status' => 1 , 'point' => '11.58813, 105.843684;11.609654, 107.859675;10.001773, 107.865168;10.039639, 105.85467'],
            ['status' => 1 , 'point' => '11.58813, 105.843684;11.609654, 107.859675;10.001773, 107.865168;10.039639, 105.85467'],
            ['status' => 1 , 'point' => '11.58813, 105.843684;11.609654, 107.859675;10.001773, 107.865168;10.039639, 105.85467']
        ]);

        DB::table('m_site_translation')->insert([
            ['name' => 'HVNHM_en', 'translation_id' => 1, 'language_id' => 2 ],
            ['name' => 'HVNHM_vn', 'translation_id' => 1, 'language_id' => 1 ],

            ['name' => 'HVNDN_en', 'translation_id' => 2, 'language_id' => 2 ],
            ['name' => 'HVNDN_vn', 'translation_id' => 2, 'language_id' => 1 ],

            ['name' => 'HVNTG_en', 'translation_id' => 3, 'language_id' => 2 ],
            ['name' => 'HVNTG_vn', 'translation_id' => 3, 'language_id' => 1 ]
        ]);

        DB::table('m_area')->insert([
            //Silo
            ['site_id' => 1, 'status' => 1 ],
            ['site_id' => 1, 'status' => 1 ],
            ['site_id' => 1, 'status' => 1 ],
            ['site_id' => 1, 'status' => 1 ],

            //Brewhouse
            ['site_id' => 2, 'status' => 1 ],
            ['site_id' => 2, 'status' => 1 ],
            ['site_id' => 2, 'status' => 1 ],

            //Fermentation
            ['site_id' => 3, 'status' => 1 ],
            ['site_id' => 3, 'status' => 1 ],
            ['site_id' => 3, 'status' => 1 ],
            ['site_id' => 3, 'status' => 1 ],
            ['site_id' => 3, 'status' => 1 ]
        ]);

        DB::table('m_area_translation')->insert([
            ['name' => 'Raw Material Intake', 'translation_id' => 1, 'language_id' => 2 ],
            ['name' => 'Raw Material Intake', 'translation_id' => 1, 'language_id' => 1 ],
            ['name' => 'Raw Material Transfer', 'translation_id' => 2, 'language_id' => 2 ],
            ['name' => 'Raw Material Transfer', 'translation_id' => 2, 'language_id' => 1 ],
            ['name' => 'Top Silo', 'translation_id' => 3, 'language_id' => 2 ],
            ['name' => 'Top Silo', 'translation_id' => 3, 'language_id' => 1 ],
            ['name' => 'Ground Silo', 'translation_id' => 4, 'language_id' => 2 ],
            ['name' => 'Ground Silo', 'translation_id' => 4, 'language_id' => 1 ],

            ['name' => 'BH2', 'translation_id' => 5, 'language_id' => 2 ],
            ['name' => 'BH2', 'translation_id' => 5, 'language_id' => 1 ],
            ['name' => 'BH3', 'translation_id' => 6, 'language_id' => 2 ],
            ['name' => 'BH3', 'translation_id' => 6, 'language_id' => 1 ],
            ['name' => 'BH4', 'translation_id' => 7, 'language_id' => 2 ],
            ['name' => 'BH4', 'translation_id' => 7, 'language_id' => 1 ],
            
            ['name' => 'Cellar 1', 'translation_id' => 8, 'language_id' => 2 ],
            ['name' => 'Cellar 1', 'translation_id' => 8, 'language_id' => 1 ],
            ['name' => 'Cellar 2', 'translation_id' => 9, 'language_id' => 2 ],
            ['name' => 'Cellar 2', 'translation_id' => 9, 'language_id' => 1 ],
            ['name' => 'Cellar 3', 'translation_id' => 10, 'language_id' => 2 ],
            ['name' => 'Cellar 3', 'translation_id' => 10, 'language_id' => 1 ],
            ['name' => 'Cellar 4', 'translation_id' => 11, 'language_id' => 2 ],
            ['name' => 'Cellar 4', 'translation_id' => 11, 'language_id' => 1 ],
            ['name' => 'Cellar 5', 'translation_id' => 12, 'language_id' => 2 ],
            ['name' => 'Cellar 5', 'translation_id' => 12, 'language_id' => 1 ]
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
            ['area_id' => 8, 'status' => 1 ],
            ['area_id' => 8, 'status' => 1 ],
            ['area_id' => 9, 'status' => 1 ],
            ['area_id' => 9, 'status' => 1 ],
            ['area_id' => 10, 'status' => 1 ],
            ['area_id' => 10, 'status' => 1 ],
            ['area_id' => 11, 'status' => 1 ],
            ['area_id' => 11, 'status' => 1 ],
            ['area_id' => 12, 'status' => 1 ],
            ['area_id' => 12, 'status' => 1 ]
        ]);

        DB::table('m_device_translation')->insert([
            ['name' => 'Wall/Ceiling', 'translation_id' => 1, 'language_id' => 2 ],
            ['name' => 'Wall/Ceiling', 'translation_id' => 1, 'language_id' => 1 ],
            ['name' => 'Depalletizer', 'translation_id' => 2, 'language_id' => 2 ],
            ['name' => 'Depalletizer', 'translation_id' => 2, 'language_id' => 1 ],
            ['name' => 'Unpacker', 'translation_id' => 3, 'language_id' => 2 ],
            ['name' => 'Unpacker', 'translation_id' => 3, 'language_id' => 1 ],
            ['name' => 'Crate Washer', 'translation_id' => 4, 'language_id' => 2 ],
            ['name' => 'Crate Washer', 'translation_id' => 4, 'language_id' => 1 ],
            ['name' => 'Bottle Washer', 'translation_id' => 5, 'language_id' => 2 ],
            ['name' => 'Bottle Washer', 'translation_id' => 5, 'language_id' => 1 ],
            ['name' => 'EBI', 'translation_id' => 6, 'language_id' => 2 ],
            ['name' => 'EBI', 'translation_id' => 6, 'language_id' => 1 ],
            ['name' => 'Filler and Crowner', 'translation_id' => 7, 'language_id' => 2 ],
            ['name' => 'Filler and Crowner', 'translation_id' => 7, 'language_id' => 1 ],
            ['name' => 'FHI after Filler', 'translation_id' => 8, 'language_id' => 2 ],
            ['name' => 'FHI after Filler', 'translation_id' => 8, 'language_id' => 1 ],
            ['name' => 'Crown Cork Transport', 'translation_id' => 9, 'language_id' => 2 ],
            ['name' => 'Crown Cork Transport', 'translation_id' => 9, 'language_id' => 1 ],
            ['name' => 'Pasteurizer', 'translation_id' => 10, 'language_id' => 2 ],
            ['name' => 'Pasteurizer', 'translation_id' => 10, 'language_id' => 1 ],
            ['name' => 'Labeller', 'translation_id' => 11, 'language_id' => 2 ],
            ['name' => 'Labeller', 'translation_id' => 11, 'language_id' => 1 ],
            ['name' => 'FHI after Labeller', 'translation_id' => 12, 'language_id' => 2 ],
            ['name' => 'FHI after Labeller', 'translation_id' => 12, 'language_id' => 1 ],
            ['name' => 'Packer', 'translation_id' => 13, 'language_id' => 2 ],
            ['name' => 'Packer', 'translation_id' => 13, 'language_id' => 1 ],
            ['name' => 'FCI', 'translation_id' => 14, 'language_id' => 2 ],
            ['name' => 'FCI', 'translation_id' => 14, 'language_id' => 1 ],
            ['name' => 'Palletizer', 'translation_id' => 15, 'language_id' => 2 ],
            ['name' => 'Palletizer', 'translation_id' => 15, 'language_id' => 1 ],
            ['name' => 'Pallet Conveyer', 'translation_id' => 16, 'language_id' => 2 ],
            ['name' => 'Pallet Conveyer', 'translation_id' => 16, 'language_id' => 1 ],
            ['name' => 'Pallet Magazine', 'translation_id' => 17, 'language_id' => 2 ],
            ['name' => 'Pallet Magazine', 'translation_id' => 17, 'language_id' => 1 ],
            ['name' => 'Crate Conveyer from Depalletizer to Unpacker', 'translation_id' => 18, 'language_id' => 2 ],
            ['name' => 'Crate Conveyer from Depalletizer to Unpacker', 'translation_id' => 18, 'language_id' => 1 ],
            ['name' => 'Crate Conveyer from Unpacker to Crate Washer', 'translation_id' => 19, 'language_id' => 2 ],
            ['name' => 'Crate Conveyer from Unpacker to Crate Washer', 'translation_id' => 19, 'language_id' => 1 ],
            ['name' => 'Crate Conveyer from Crate Washer to Packer', 'translation_id' => 20, 'language_id' => 2 ],
            ['name' => 'Crate Conveyer from Crate Washer to Packer', 'translation_id' => 20, 'language_id' => 1 ],
            ['name' => 'Crate Conveyer from Packer to Palletizer', 'translation_id' => 21, 'language_id' => 2 ],
            ['name' => 'Crate Conveyer from Packer to Palletizer', 'translation_id' => 21, 'language_id' => 1 ],
            ['name' => 'Bottle Conveyer from Unpacker to Washer', 'translation_id' => 22, 'language_id' => 2 ],
            ['name' => 'Bottle Conveyer from Unpacker to Washer', 'translation_id' => 22, 'language_id' => 1 ],
            ['name' => 'Bottle Conveyer from Washer to EBI', 'translation_id' => 23, 'language_id' => 2 ],
            ['name' => 'Bottle Conveyer from Washer to EBI', 'translation_id' => 23, 'language_id' => 1 ],
            ['name' => 'Bottle Conveyer from EBI to Filler and Washer', 'translation_id' => 24, 'language_id' => 2 ],
            ['name' => 'Bottle Conveyer from EBI to Filler and Washer', 'translation_id' => 24, 'language_id' => 1 ]
        ]);
    }
}
