<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupOrgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_orgs', function (Blueprint $table) {
            $table->id('org_id');
            $table->string('org_name');
            $table->string('description');
            $table->string('org_tel');
            $table->string('county');
            $table->string('road');
            $table->string('alley');
            $table->string('house_number');
            $table->string('group_no');
            $table->string('sub_district');
            $table->string('district');
            $table->string('province');
            $table->string('ZIP_code');
            $table->string('book_cer');
            $table->string('org_owner');
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
        Schema::dropIfExists('group_orgs');
    }
}
