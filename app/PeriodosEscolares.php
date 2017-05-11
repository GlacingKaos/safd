<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeriodosEscolares extends Model
{
    protected $table = 'periodos_escolares';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
         'periodo'
    ];
    
     protected $hidden = [];
}
