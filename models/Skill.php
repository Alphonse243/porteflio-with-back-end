<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'level',
        'category'
    ];

    public static function getAll()
    {
        return self::orderBy('level', 'desc')->get();
    }
}
