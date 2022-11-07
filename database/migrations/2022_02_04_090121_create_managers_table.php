<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managers', function (Blueprint $table) {
            $table->id('manager_id');
            $table->string('user_status_id');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name');
            $table->string('surname');
            $table->string('gender');
            $table->string('tell');
            $table->string('manager_image')->nullable();
            $table->string('school_name');
            $table->string('school_Detail');
            $table->string('school_image')->nullable();
            $table->string('Address_hn');
            $table->string('Address_m');
            $table->string('Address_t');
            $table->string('Address_a');
            $table->string('Address_j');
            $table->string('Address_p');
            $table->string('school_tell');
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
        Schema::dropIfExists('managers');
    }
}
