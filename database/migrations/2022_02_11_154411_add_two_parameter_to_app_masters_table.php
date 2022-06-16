<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTwoParameterToAppMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_masters', function (Blueprint $table) {
            $table->string('parameter', '100')->nullable()->after('description');
            $table->string('additional_parameter', '100')->nullable()->after('parameter');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('app_masters', function (Blueprint $table) {
            //
        });
    }
}
