<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Directory extends Model
{
    use HasFactory, HasUuid;

    protected $hidden = [
        'id',
    ];

    protected $with = [
        'directoryChannel',
        'forumChannel',
    ];

    public function directoryChannel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }

    public function forumChannel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }
}
