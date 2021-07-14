<?php

namespace App\Models\House;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;

    /**
     * Estate relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function estate(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Estate::class);
    }
}
