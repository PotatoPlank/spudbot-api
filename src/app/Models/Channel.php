<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Channel extends Model
{
    use HasFactory, HasUuid;

    protected $hidden = [
        'id',
    ];

    protected $fillable = [
        'discord_id',
        'guild_id',
    ];

    protected $with = [
        'guild',
    ];

    public function guild(): BelongsTo
    {
        return $this->belongsTo(Guild::class);
    }
}
