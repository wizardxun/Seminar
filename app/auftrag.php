<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class auftrag extends Model
{
    protected $table = 'auftrag';
    protected $primaryKey = 'auftragID';
     protected $fillable = [
        'ag', 'empfEmail', 'punkte', 'absPLZ', 'punkte', 'absAdr','empfName', 'empfPLZ', 'empfAdr', 'absName', 'anName' , 'code' , 'lb' , 'ab' ,
    ];
}
