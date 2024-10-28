<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'name', 'slug', 'description', 'image','price', 'quantity', 'status',
    ];

    protected $hidden=[
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function orders(){
        return $this->hasMany(Order::class);
    }
    public static function rules($id = 0)
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('products', 'name')->ignore($id),
                // "unique:categories,name,$id"
            ],
            'image' => [
                'image',
                'max:1048576',
                'dimensions:min_width=100,min_height=100',
            ],
            'status' => 'required|in:active,draft,archived',
        ];
    }



    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['name'] ?? false, function($builder, $value) {
            $builder->where('products.name', 'LIKE', "%{$value}%");
        });

        $builder->when($filters['status'] ?? false, function($builder, $value) {
            $builder->where('products.status', '=', $value);
        });

    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function scopeApiFilter(Builder $builder, $filters)
    {
        $options = array_merge([
            'category_id' => null,
            'status' => 'active',
        ], $filters);

        $builder->when($options['status'], function ($query, $status) {
            return $query->where('status', $status);
        });

        $builder->when($options['category_id'], function($builder, $value) {
            $builder->whereRaw('id IN (SELECT product_id FROM category_product WHERE category_id = ?)', [$value]);
            // $builder->whereExists(function($query) use ($value) {
            //     $query->select(1)
            //         ->from('category_product')
            //         ->whereRaw('product_id = products.id')
            //         ->where('category_id', $value);
            // });
        });
    }
}
