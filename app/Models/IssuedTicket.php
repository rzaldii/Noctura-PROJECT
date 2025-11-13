<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssuedTicket extends Model
{
    use HasFactory;

    protected $table = 'issued_tickets';
    public $timestamps = false;

    protected $fillable = [
        'order_detail_id',
        'ticket_code',
        'issued_at'
    ];

    public function orderDetails()
    {
        return $this->belongsTo(OrderDetail::class);
    }
}
