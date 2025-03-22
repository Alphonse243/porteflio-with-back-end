<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'title',
        'company',
        'description',
        'start_date',
        'end_date'
    ];

    public static function getAll()
    {
        return self::orderBy('start_date', 'desc')->get();
    }
}
