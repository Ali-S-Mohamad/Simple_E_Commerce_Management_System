<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'product_id',
        'status',
        'total_price'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected static function booted()
    {
        static::created(function ($order) {
            $product = Product::find($order->product_id);
            if ($product) {
                $product->decrement('quantity', 1);
                $amount = $product->quantity;
                if($amount == 0){
                    $product->status = 'archived';
                }
                $product->save();
            }

        });
    }
    public function scopeFilter(Builder $builder, $filters)
    {

        $builder->when($filters['name'] ?? false, function ($builder, $value) {
            $builder->where('orders.product.name', 'LIKE', "%{$value}%");
        });

        $builder->when($filters['status'] ?? false, function ($builder, $value) {
            $builder->where('orders.status', '=', $value);
        });

        $builder->when($filters['user'] ?? false, function ($builder, $value) {
            $builder->where('orders.user_id', '=', $value);
        });

    }
}
