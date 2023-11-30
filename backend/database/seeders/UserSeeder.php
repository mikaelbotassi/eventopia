<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // name, cpf_cnpj, birth, email, password
        $bruteArr = [
            ['root', '73622420006', '2001-11-08', 'root@gmail.com', '$2y$12$xaW5sc2WMcjy.0shNG0/L.1yHe.r.vHY7IrabNMjSbASQQR46NqSG']
        ];

        $arrInsert = [];
        foreach($bruteArr as $arr){
            $arrInsert[] = [
                'name' => $arr[0],
                'cpf_cnpj' => $arr[1],
                'birth' => $arr[2],
                'email' => $arr[3],
                'password' => $arr[4],
                'created_at' => new DateTime(),
            ];
        }

        DB::table('users')->insertOrIgnore($arrInsert);
    }
}
