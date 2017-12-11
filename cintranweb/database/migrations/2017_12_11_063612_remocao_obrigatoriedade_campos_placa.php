<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemocaoObrigatoriedadeCamposPlaca extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::table('placas', function(Blueprint $table){
            $table->integer('altura')->nullable()->change();
        });

        Schema::table('placas', function(Blueprint $table){
            $table->integer('tempo_transmissao')->nullable()->change();
        });

        Schema::table('placas', function(Blueprint $table){
            $table->integer('velocidade_via')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::table('placas', function(Blueprint $table){
            $table->integer('altura')->default(0)->change();
        });

        Schema::table('placas', function(Blueprint $table){
            $table->integer('tempo_transmissao')->default(0)->change();
        });

        Schema::table('placas', function(Blueprint $table){
            $table->integer('velocidade_via')->default(0)->change();
        });
    }
}
