<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'referral_type_id', 'referral_code', 'referral_description'];

    public function user()
    {
        return $this->hasOne(User::class, 'user_id');
    }

    public function referral_type()
    {
        return $this->hasOne(ReferralType::class, 'referral_type_id');
    }
}
