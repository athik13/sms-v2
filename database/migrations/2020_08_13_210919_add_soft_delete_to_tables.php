<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeleteToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('single_messages', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('received_sms', function (Blueprint $table) {
            $table->softDeletes();
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
            $table->dropSoftDeletes();
        });
        Schema::table('received_sms', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
