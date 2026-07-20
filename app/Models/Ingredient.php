<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'unit', 'cost_per_unit', 'stock_quantity'])]
class Ingredient extends Model
{
}
