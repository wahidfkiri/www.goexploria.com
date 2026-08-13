<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                /*'id' => '1',
                'type_id' => '2',
                'email' => 'demmon.cyril@gmail.com',
                'pass_secure' => '$2y$10$LH/On5vilQPQmZDEyo/YZuAVjz8uKr64tg53eGLC.FSK3nPqgfU6m',
                'first_name' => 'cyril',
                'last_name' => 'demery',
                'name' => 'Cyril Démery',
                'is_activated' => true,
                'is_news_enabled' => true,
                'is_admin' => true,
                'coordinate_id' => 12,
                'created_at' => '2016',
                'updated_at' => '2016',
                */
                'id' => '1',
                'type_id' => '2',
                'email' => 'info@cedric-paquet.com',
                'pass_secure' => '$2y$10$kAjbbCcBSOkqvcBm.uKHM.YM7apBqJcP16KscGjB3fMjnXPAfKMpu',
                'name' => 'Cedric Paquet',
                'first_name' => 'Cedric',
                'last_name' => 'Paquet',
                'is_activated' => true,
                'is_news_enabled' => false,
                'is_admin' => true,
                'coordinate_id' => 2,
                'created_at' => time(),
                'updated_at' => null,
            ),
            1 => 
            array (
                'id' => '2',
                'type_id' => '2',
                'email' => 'info@explorezlequebec.com',
                'pass_secure' => '$2y$10$kAjbbCcBSOkqvcBm.uKHM.YM7apBqJcP16KscGjB3fMjnXPAfKMpu',
                'name' => 'JEAN BOURGET',
                'first_name' => 'JEAN',
                'last_name' => 'BOURGET',
                'is_activated' => true,
                'is_news_enabled' => false,
                'is_admin' => true,
                'coordinate_id' => 1,
                'created_at' => time(),
                'updated_at' => null,
            ),
            
        ));
        
        
    }
}
