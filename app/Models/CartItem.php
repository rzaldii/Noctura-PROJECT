<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_items';
    public $timestamps = false;

    protected $fillable = [
        'cart_id',
        'ticket_id',
        'quantity'
    ];

    public function carts()
    {
        return $this->belongsTo(Cart::class);
    }

    public function tickets()
    {
        return $this->belongsTo(Ticket::class);
    }
}
