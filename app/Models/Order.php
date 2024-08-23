<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $guarded = [];
    public function customer() : BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function postOrder() : BelongsTo
    {
        return $this->belongsTo(PostOrder::class, 'order_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
