<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CamposNovosPlacas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('placas', function($table){
            $table->integer('altura')->default(5);
            $table->integer('tempo_transmissao')->default(5);
            $table->integer('velocidade_via')->default(40);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('placas', function($table){
            $table->dropColumn('altura' );
        });

        Schema::table('placas', function($table){
            $table->dropColumn('tempo_transmissao' );
        });

        Schema::table('placas', function($table){
            $table->dropColumn('velocidade_via' );
        });
    }
}
