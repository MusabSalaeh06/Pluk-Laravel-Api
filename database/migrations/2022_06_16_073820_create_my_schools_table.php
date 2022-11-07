<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMySchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_schools', function (Blueprint $table) {
            $table->id('id');
            $table->string('member_id');
            $table->string('school_name')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->string('edu_level')->nullable();
            $table->string('fac_name')->nullable();
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
        Schema::dropIfExists('my_schools');
    }
}
