<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment', function (Blueprint $table) {
            $table->integer('commid', true);
            $table->mediumText('comment')->nullable();
            $table->integer('memid')->nullable();
            $table->timestamp('date')->nullable()->useCurrent();
            $table->integer('userid')->nullable();
            $table->integer('staffid')->nullable();
            $table->integer('active')->nullable()->default(0);
            $table->integer('conf')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment');
    }
}
