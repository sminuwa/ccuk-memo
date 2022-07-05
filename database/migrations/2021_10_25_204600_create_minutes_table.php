<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMinutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('minutes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('memo_id')->index('memo_id');
            $table->longText('body');
            $table->enum('flag', ['positive', 'negative']);
            $table->unsignedBigInteger('from_user')->index('from_user');
            $table->unsignedBigInteger('to_user')->index('to_user');
            $table->enum('confidentiality', ['confidential', 'not confidential'])->default('not confidential');
            $table->text('copy');
            $table->enum('status', ['not seen', 'seen', 'read']);
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
        Schema::dropIfExists('minutes');
    }
}
