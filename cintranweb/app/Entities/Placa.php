<?php

namespace cintran\Entities;

use Illuminate\Database\Eloquent\Model;

class Placa extends Model{
    public $timestamps = false;
    protected $fillable = ['id', 'latitude', 'longitude', 'altura', 'tempo_transmissao', 'velocidade_via', 'esquerda', 'frente', 'direita'];
    protected $guardable = ['status'];

    public static function validarDirecao($placas){
        $total = count($placas);
        if($total > 1){
            for($i = 0; $i < $total; $i++){
                for($j = $i + 1; $j < $total; $j++){
                    if(!empty($placas[$i]) && !empty($placas[$j])){
                        if($placas[$i] == $placas[$j])
                            return false;
                    }
                }
            }
        }

        return true;
    }

    public static function allParaDependencias(){
        $all = Placa::all();
        $placas =array( array("codigo" => "0", "texto" => "Selecione" ) );

        foreach($all as $placa){
            $placas[] = ["codigo" => $placa->id, "texto" => $placa->id];
        }

        return $placas;
        
    }

}
