<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'ticket_id',
        'quantity',
        'unit_price',
        'subtotal'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function ticket()  // ← SINGULAR, BUKAN tickets()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function issuedTickets()
    {
        return $this->hasMany(IssuedTicket::class, 'order_detail_id');
    }
}
