<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reminder extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'description',
        'mention_role',
        'scheduled_at',
        'repeats',
    ];

    protected $with = [
        'guild',
        'channel',
    ];


    public function guild(): BelongsTo
    {
        return $this->belongsTo(Guild::class);
    }

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }
}
