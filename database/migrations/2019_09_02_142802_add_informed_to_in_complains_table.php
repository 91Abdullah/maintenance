<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInformedToInComplainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('complains', function (Blueprint $table) {
            $table->dateTime('closure_time')->nullable();
            $table->dropColumn('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('complains', function (Blueprint $table) {
            $table->dropColumn('closure_time');
            $table->unsignedBigInteger('customer_id');
        });
    }
}
