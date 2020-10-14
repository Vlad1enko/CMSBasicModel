<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('title_eng');
            $table->text('message_eng')->nullable();
            $table->string('title_rus');
            $table->text('message_rus')->nullable();
            $table->string('name');
            $table->string('surname');
            $table->text('image_link')->nullable();

            $table->foreignId('parent_id')->nullable();

            $table->enum('order_type', ['date_desc', 'date_asc', 'order_num_desc', 'order_num_asc']);
            $table->enum('view_type', ['tiles', 'list']);
            $table->integer('order')->nullable();
            $table->timestamps();
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('pages')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
