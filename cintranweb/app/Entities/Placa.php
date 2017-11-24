<?php

namespace cintran\Entities;

use Illuminate\Database\Eloquent\Model;

class Placa extends Model
{
    public $timestamps = false;
    protected $fillable = ['id', 'latitude', 'longitude'];
    protected $guardable = ['status'];
}
