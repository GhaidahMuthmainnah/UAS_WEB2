<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['order_id', 'category', 'amount', 'expense_date', 'description'])]
class ExpenseRecord extends Model
{
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
