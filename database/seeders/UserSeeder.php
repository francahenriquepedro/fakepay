<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ( User::count() == 0 ) {

            User::create([
                'name' => 'Usuário comum',
                'document' => '00000001910',
                'email' => 'common.user@gmail.com',
                'password' => Hash::make('123456789'),
                'wallet' => 1000.00,
                'type' => 'common'
            ]);

            User::create([
                'name' => 'Lojista',
                'document' => '79590778000158',
                'email' => 'shop.keeper@gmail.com',
                'password' => Hash::make('123456789'),
                'wallet' => 100.00,
                'type' => 'merchant'
            ]);
        }
    }
}
