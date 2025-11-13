<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    use HasFactory;

    protected $table = 'organizers';

    protected $fillable = [
        'username',
        'email',
        'password',
        'organization_name',
        'description',
        'image_path'
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
