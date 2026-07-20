<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['customer_id', 'rating', 'review', 'is_published'])]
class Testimonial extends Model
{
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
