<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->string('surname');
            $table->string('first_name')->nullable();
            $table->string('other_names')->nullable();
            $table->enum('gender', ['Male', 'Female'])->default('Male');
            $table->enum('marital_status', ['Divorced', 'Married', 'Single', 'Widowed', 'Separated']);
            $table->integer('current_level')->default(0);
            $table->string('phone');
            $table->text('contact_address')->nullable();
            $table->string('personnel_number')->nullable();
            $table->unsignedBigInteger('department_id')->index('department_id');
            $table->bigInteger('branch_id')->nullable();
            $table->bigInteger('position_id')->nullable();
            $table->bigInteger('entry_qualification')->nullable();
            $table->bigInteger('highest_qualification')->nullable();
            $table->bigInteger('state_of_origin')->nullable();
            $table->bigInteger('state_of_residence')->nullable();
            $table->enum('status', ['active', 'fired', 'retired', 'resigned', 'deceased']);
            $table->string('signature')->nullable();
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
        Schema::dropIfExists('user_details');
    }
}
