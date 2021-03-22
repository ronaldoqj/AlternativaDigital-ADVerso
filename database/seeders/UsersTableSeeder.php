<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('users')->insert([
            'name' => 'Usuário Master',
            'funcao' => 'Adm-Master',
            'email' => 'master@adm.com',
            'password' => bcrypt('123456'),
            'type' => 'master',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('users')->insert([
            'name' => 'Usuário Teste',
            'email' => 'teste@teste.com',
            'password' => bcrypt('123456'),
            'created_at' => date("Y-m-d H:i:s"),
        ]);

    }
}
