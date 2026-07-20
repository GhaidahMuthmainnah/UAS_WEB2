<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['order_id', 'event_name', 'event_date', 'location', 'num_guests'])]
class Event extends Model
{
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
