<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $table="discounts";

    public $timestamps=true;
    protected $fillable=[
        'product_id',
        'discount_value',
        'date',

    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }
}
