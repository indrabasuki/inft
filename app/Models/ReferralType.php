<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralType extends Model
{
    use HasFactory;
    protected $fillable = ['type_name', 'type_description'];

    public function referral()
    {
        return $this->hasMany(Referral::class);
    }
}
