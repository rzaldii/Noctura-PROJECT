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

    public function orders()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function tickets()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'id');
    }

    public function issuedTickets()
    {
        return $this->hasMany(IssuedTicket::class);
    }
}
