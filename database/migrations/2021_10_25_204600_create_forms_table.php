<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->bigInteger('memo_id');
            $table->string('type');
            $table->text('data');
            $table->enum('accept_retirements', ['Yes', 'No'])->default('No');
            $table->enum('is_retired', ['Yes', 'No'])->default('No');
            $table->enum('has_payments', ['Yes', 'No'])->nullable()->default('Yes');
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
        Schema::dropIfExists('forms');
    }
}
