<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TwitterAccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            DB::table('twitter_accounts')->insert([
                'user_id' => '1',
                'twitter_id' => '1234567890',
                'screen_name' => '12345',
                'oauth_token' => '123456',
                'oauth_token_secret' => '1234567',
            ]);
    }
}
