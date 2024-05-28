<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marketplace extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'last_status',
        'tags',
        'member',
    ];
}
