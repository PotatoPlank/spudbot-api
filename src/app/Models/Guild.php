<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guild extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'discord_id',
        'channel_announce_id',
        'channel_thread_announce_id',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function channels(): HasMany
    {
        return $this->hasMany(Channel::class);
    }

    public function threads(): HasMany
    {
        return $this->hasMany(Thread::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function reminders(): HasMany
    {
        return $this->hasMany(Reminder::class);
    }
}
