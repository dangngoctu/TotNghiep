<?php

use Illuminate\Database\Seeder;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        for($i = 0; $i < 20; $i++){
            $class = rand(1,3);
            DB::table('m_student')->insert([
                [
                    'mssv' => '035008018'.$i, 
                    'name' => 'Student '.$i ,
                    'phone' => '093734854'.$i,
                    'avatar' => 'img/student_img/student.jpg',
                    'address' => '575 Cách Mạng Tháng Tám',
                    'class_id' => $class,
                    'dob' => '1996-07-04',
                    'status' => 1
                ]
            ]);
        }
    }
}
