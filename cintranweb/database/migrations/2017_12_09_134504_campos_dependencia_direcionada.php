<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CamposDependenciaDirecionada extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('placas', function($table){
            $table->integer('esquerda')->nullable();
            $table->integer('frente')->nullable();
            $table->integer('direita')->nullable();
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
            $table->dropColumn('esquerda' );
        });

        Schema::table('placas', function($table){
            $table->dropColumn('frente' );
        });

        Schema::table('placas', function($table){
            $table->dropColumn('direita' );
        });
    }
}
