<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    public $timestamps=true;

    protected $table="likes";

    protected $fillable=[
        //'id',
        'product_id',
        'user_id',

    ];
    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
}
