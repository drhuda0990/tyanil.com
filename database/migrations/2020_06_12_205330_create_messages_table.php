<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();
            $table->text('message')->nullable();
            $table->string('section')->nullable();

            $table->text('sender')->nullable();
            $table->text('sender_has')->nullable();

            $table->text('json')->nullable();

            $table->datetime('sent_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->integer('type')->default(0)->nullable();
            $table->boolean('state')->default(false)->nullable();


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
        Schema::dropIfExists('messages');
    }
}
