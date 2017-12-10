<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoverObrigatoriedadeCoordenadas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('placas', function(Blueprint $table){
            $table->string('latitude', 15)->nullable()->change();
        });

        Schema::table('placas', function(Blueprint $table){
            $table->string('longitude', 15)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::table('placas', function(Blueprint $table){
            $table->string('latitude', 15)->change();
        });

        Schema::table('placas', function(Blueprint $table){
            $table->string('longitude', 15)->change();
        });
    }
}
