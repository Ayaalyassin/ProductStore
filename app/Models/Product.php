<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table ="products";

    //public $with=['category'];


    public $timestamps=true;
    protected $fillable=[
        'user_id',
        'name',
        'price',
        'description',
        'expiration_date',
        'image_url',
        'quantity',
        'category_id',
        'discount_value',
        'date',
        'views',

    ];

    public $withCount=['comments','likes'];

    public function likes()
    {
        return $this->hasMany('App\Models\Like','product_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category','category_id');
    }

    public function discounts()
    {
        return $this->hasMany('App\Models\Discount','product_id')->orderBy('date');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment','product_id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }



    protected $primaryKey='id';

}
