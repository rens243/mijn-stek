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
     * Creating a color from name
     *
     * @return string
     */
    public function getHexColorAttribute()
    {
        return substr(md5($this->name), 0, 6);
    }

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
