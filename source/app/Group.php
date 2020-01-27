<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;
use App\User;

class Group extends Model
{
    use UsesUuid;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->owner_id = auth()->id();
        });
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'owner_id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
