<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'description',
        'completed',
        'best_before'
        ];

    protected $dates = [
        'created_at', 'updated_at', 'best_before'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
