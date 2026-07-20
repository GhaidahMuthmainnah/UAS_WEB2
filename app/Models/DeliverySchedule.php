<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['order_id', 'delivery_time', 'status', 'driver_name'])]
class DeliverySchedule extends Model
{
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
