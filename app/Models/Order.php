<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'customer_id',
        'total_amount',
        'status',
        'payment_proof',
        'payment_proof_uploaded_at'
    ];

    protected $casts = [
        'payment_proof_uploaded_at' => 'datetime',
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // Accessor untuk Status Badge (untuk view)
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">Pending</span>',
            'approved' => '<span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">Lunas</span>',
            'cancelled' => '<span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">Dibatalkan</span>',
        ];

        return $badges[$this->status] ?? '<span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-semibold">' . ucfirst($this->status) . '</span>';
    }
}
