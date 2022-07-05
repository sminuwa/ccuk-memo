<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_units', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('name');
            $table->string('code');
            $table->enum('base_unit', ['Metre', 'Piece', 'Kilogram', ''])->nullable();
            $table->enum('operator', ['Multiply', 'Divide', 'Plus', 'Minus', ''])->nullable();
            $table->string('operation_value', 20)->nullable();
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
        Schema::dropIfExists('inventory_units');
    }
}
