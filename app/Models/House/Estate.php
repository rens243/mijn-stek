<?php

namespace App\Models\House;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Houses relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function houses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(House::class);
    }
}
