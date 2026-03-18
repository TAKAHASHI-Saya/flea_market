<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'condition_id',
        'product_name',
        'product_image',
        'brand',
        'product_detail',
        'sales_price',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function purchase(){
        return $this->hasOne(Purchase::class);
    }
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
    public function condition(){
        return $this->belongsTo(Condition::class);
    }
    public function likes(){
        return $this->hasMany(Like::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function conditions(){
        return $this->hasMany(Condition::class);
    }

    public function scopeKeywordSearch($query, $keyword)
    {
        if(!empty($keyword)){
            $query->where('product_name', 'like', '%' . $keyword . '%');
        }
        return $query;
    }
}
