<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['title', 'body', 'user_id', 'last_user_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
