<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Marketplace extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'last_status',
        'tags',
        'member_id',
        'name',
        'discord_id',
    ];


    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
