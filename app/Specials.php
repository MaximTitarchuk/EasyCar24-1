<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specials extends Model
{
    protected $table = 'specials';
    public $timestamps = true;
    protected $fillable = ['date_from', 'date_to', 'sum_from', 'sum_to', 'percent', 'content'];
}
