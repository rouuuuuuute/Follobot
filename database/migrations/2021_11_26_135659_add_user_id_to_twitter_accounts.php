<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddUserIdToTwitterAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('twitter_accounts', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('twitter_id')->unique();
            $table->string('screen_name');
            $table->string('oauth_token');
            $table->string('oauth_token_secret');
            $table->dropColumn('account_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('twitter_accounts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropColumn('twitter_id');
            $table->dropColumn('screen_name');
            $table->dropColumn('oauth_token');
            $table->dropColumn('oauth_token_secret');
            $table->string('account_name');
        });
    }
}
