<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
             $table->string('country_code')->nullable();
              $table->string('country_enName')->nullable();
               $table->string('country_arName')->nullable();
                $table->string('country_enNationality')->nullable();
                $table->string('country_arNationality')->nullable();
                $table->string('country_arNationality_girls')->nullable();
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
        Schema::dropIfExists('countries');
    }
}
