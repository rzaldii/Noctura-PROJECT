<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'organizer_id',
        'category_id',
        'title',
        'description',
        'event_type',
        'address',
        'city',
        'province',
        'postal_code',
        'latitude',
        'longitude',
        'start_time',
        'end_time',
        'image_path',
        'status'
    ];

    public function organizers()
    {
        return $this->belongsTo(Organizer::class, 'organizer_id');
    }

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class,);
    }

}
