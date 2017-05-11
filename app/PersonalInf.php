<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalInf extends Model
{
    protected $table = 'personal_info';
    protected $primaryKey = 'rfc_p';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
         'foto','nombre','correo','telefono','curriculum','dir'
    ];
    
     protected $hidden = [];
}
