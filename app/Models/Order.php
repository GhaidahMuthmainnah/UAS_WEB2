<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['customer_id', 'order_date', 'total_amount', 'status'])]
class Order extends Model
{
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function event()
    {
        return $this->hasOne(Event::class);
    }

    public function deliverySchedule()
    {
        return $this->hasOne(DeliverySchedule::class);
    }

    public function expenseRecords()
    {
        return $this->hasMany(ExpenseRecord::class);
    }
}
