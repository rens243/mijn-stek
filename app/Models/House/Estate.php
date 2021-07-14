<?php

namespace App\Models\House;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

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
