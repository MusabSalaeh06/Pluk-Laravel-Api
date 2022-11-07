<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrolls', function (Blueprint $table) {
            $table->id('enroll_id');
            $table->string('course_id');
            $table->string('org_id')->nullable();
            $table->string('member_id')->nullable();
            $table->string('enroll_type')->nullable();
            $table->string('status')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('image')->nullable();
            $table->string('creator')->nullable();
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
        Schema::dropIfExists('enrolls');
    }
}
