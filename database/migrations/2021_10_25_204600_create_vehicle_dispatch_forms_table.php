<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleDispatchFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_dispatch_forms', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('memo_id');
            $table->bigInteger('vehicle_dispatch_id');
            $table->enum('type', ['Fuel', 'Carriage', 'Expense', 'Feeding', 'Repair', 'Dispatch', 'Others'])->default('Others');
            $table->enum('category', ['Revenue', 'Expense', 'Others'])->default('Others');
            $table->enum('has_payment', ['Yes', 'No'])->default('No');
            $table->integer('amount')->nullable();
            $table->text('data');
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
        Schema::dropIfExists('vehicle_dispatch_forms');
    }
}
