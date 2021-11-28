<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFollowingIdToUnfollowers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unfollowers', function (Blueprint $table) {
            $table->unsignedBigInteger('following_id');
            $table->foreign('following_id')->references('id')->on('following_targets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unfollowers', function (Blueprint $table) {
            $table->dropForeign(['following_id']);
            $table->dropColumn('following_id');
        });
    }
}
