<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'discord_id',
        'total_comments',
        'username',
        'verifiedBy',
    ];

    public function guild(): BelongsTo
    {
        return $this->belongsTo(Guild::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'verified_by');
    }

    public function eventAttendance(): HasMany
    {
        return $this->hasMany(EventAttendance::class);
    }
}
