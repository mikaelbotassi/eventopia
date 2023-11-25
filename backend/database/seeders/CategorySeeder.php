<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr = [
            'CONFERÊNCIA',
            'WORKSHOP',
            'SEMINÁRIO',
            'WEBINAR',
            'REUNIÃO',
            'TREINAMENTO',
            'CULTURAL',
            'ESPORTIVO',
            'TECNOLOGIA',
            'CIÊNCIA',
            'ARTE',
            'EDUCAÇÃO',
            'NEGÓCIOS',
            'SAÚDE',
            'MEIO AMBIENTE',
            'SOCIAL',
            'OUTRO'
        ];

        $arrInsert = [];
        foreach($arr as $value){
            $arrInsert[] = [
                'name' => $value,
                'created_at' => new DateTime(),
            ];
        }

        DB::table('categories')->insertOrIgnore($arrInsert);
    }
}
