<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('code', 100);
            $table->string('name');
            $table->string('color')->nullable();
            $table->string('model')->nullable();
            $table->string('cassis')->nullable();
            $table->string('number')->nullable();
            $table->enum('fuel', ['Diesel', 'Petrol']);
            $table->enum('new_second', ['New', 'Second'])->default('New');
            $table->timestamp('date_purchased')->nullable();
            $table->integer('cost')->default(0);
            $table->string('category');
            $table->string('type')->nullable();
            $table->string('tonnage')->nullable();
            $table->enum('status', ['Repair', 'Routine Maintenance', 'Accident', 'In Transit', 'Idle']);
            $table->enum('has_driver', ['Yes', 'No'])->default('Yes');
            $table->enum('has_external_body', ['Yes', 'No'])->default('Yes');
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
        Schema::dropIfExists('vehicles');
    }
}
