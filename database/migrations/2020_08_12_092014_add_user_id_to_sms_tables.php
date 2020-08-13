<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToSmsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('single_messages', function (Blueprint $table) {
            $table->integer('user_id')->after('id')->default('0');
        });
        Schema::table('individual_group_messages', function (Blueprint $table) {
            $table->integer('user_id')->after('id')->default('0');
        });
        Schema::table('group_messages', function (Blueprint $table) {
            $table->integer('user_id')->after('id')->default('0');
        });
        Schema::table('sms_groups', function (Blueprint $table) {
            $table->integer('user_id')->after('id')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('single_messages', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('individual_group_messages', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('group_messages', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('sms_groups', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}
