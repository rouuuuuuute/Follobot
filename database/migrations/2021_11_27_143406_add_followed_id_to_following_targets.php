<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFollowedIdToFollowingTargets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('following_targets', function (Blueprint $table) {
            $table->unsignedBigInteger('followed_id');
            $table->foreign('followed_id')->references('id')->on('followed_targets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('following_targets', function (Blueprint $table) {
            $table->dropForeign(['followed_id']);
            $table->dropColumn('followed_id');
        });
    }
}
