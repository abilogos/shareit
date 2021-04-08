<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migration for creating file table.
     *
     * @return void
     */
    public function up() : void
    {
        Schema::create('files', function (Blueprint $table) {
            //primary key
            $table->id();
            //Foreign Key for users table
            $table->unsignedBigInteger('user_id');

            $table->string('name');
            $table->unsignedInteger('download_count');
            $table->timestamps();
            $table->softDeletes();
        });

        //foregin key definition
        Schema::table('files', function ($table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists('files');
    }
}
