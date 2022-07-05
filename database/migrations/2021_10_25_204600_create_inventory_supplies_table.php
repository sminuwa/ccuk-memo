<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventorySuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_supplies', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('branch_id');
            $table->bigInteger('item_id');
            $table->string('batch_number')->nullable();
            $table->integer('quantity');
            $table->integer('unit_price');
            $table->date('date')->nullable();
            $table->date('expiry')->nullable();
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
        Schema::dropIfExists('inventory_supplies');
    }
}
