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
                'twitter_id' => Str::random(5),
                'screen_name' => Str::random(7),
                'oauth_token' => Str::random(10),
                'oauth_token_secret' => Str::random(10),
            ]);
    }
}
