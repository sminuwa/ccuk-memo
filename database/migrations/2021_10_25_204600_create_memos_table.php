<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memos', function (Blueprint $table) {
            $table->bigIncrements('id')->index('id');
            $table->string('reference', 50);
            $table->string('title');
            $table->longText('body');
            $table->unsignedBigInteger('raise_by')->index('raise_by');
            $table->unsignedBigInteger('raised_for')->index('raised_for');
            $table->dateTime('date_raised');
            $table->string('copy', 256)->nullable()->index('copy');
            $table->enum('status', ['open', 'archived', 'closed', 'completed'])->default('open');
            $table->enum('read_status', ['seen', 'not seen', 'read', 'copied'])->default('not seen');
            $table->enum('type', ['Memo', 'Form', 'Vehicle'])->default('Memo');
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
        Schema::dropIfExists('memos');
    }
}
