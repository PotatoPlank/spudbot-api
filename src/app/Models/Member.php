<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    use HasFactory, HasUuid;
    protected $hidden = [
        'id',
        'guild_id',
        'verified_by',
    ];

    protected $with = [
      'guild',
      'verifiedBy',
    ];

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
}
