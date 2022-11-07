<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id('id');
            $table->id('cc_id');
            $table->string('course_id');
            $table->string('course_name');
            $table->string('course_detail')->nullable();
            $table->string('course_type')->nullable();
            $table->string('course_img')->nullable();
            $table->string('price')->nullable();
            $table->string('course_owner');
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
        Schema::dropIfExists('courses');
    }
}
