<?php

namespace cintran\Entities;

use Illuminate\Database\Eloquent\Model;

class Dependencia extends Model
{
    public $timestamps = false;
    protected $fillable = ['placa', 'depende_de'];
}
