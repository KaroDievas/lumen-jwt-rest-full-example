<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    protected $table = 'toDo';

    protected $fillable = ['name','userId'];
}