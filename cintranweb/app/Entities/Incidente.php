<?php

namespace cintran\Entities;

use Illuminate\Database\Eloquent\Model;

class Incidente extends Model{
    protected $fillable = ['placa_id', 'tipo', 'resolvido'];
    protected $guardable = ['id'];
}
