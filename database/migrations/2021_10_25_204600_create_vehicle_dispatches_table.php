<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleDispatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_dispatches', function (Blueprint $table) {
            $table->integer('id', true);
            $table->bigInteger('memo_id');
            $table->bigInteger('vehicle_driver_id');
            $table->timestamp('date_from')->nullable();
            $table->timestamp('date_to')->nullable();
            $table->string('number');
            $table->enum('status', ['Opened', 'Verified', 'Approved', 'Authorized'])->nullable()->default('Opened');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_dispatches');
    }
}
