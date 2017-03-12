<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'discussion_id'];
}
