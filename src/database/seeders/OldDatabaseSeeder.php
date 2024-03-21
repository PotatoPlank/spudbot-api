<?php

namespace Database\Seeders;

use App\Models\Channel;
use App\Models\Directory;
use App\Models\Event;
use App\Models\EventAttendance;
use App\Models\Guild;
use App\Models\Member;
use App\Models\Reminder;
use App\Models\Thread;
use Illuminate\Database\Connection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OldDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conn = DB::connection('aws');
        $this->guilds($conn);
        $this->members($conn);
        $this->channels($conn);
        $this->threads($conn);
        $this->directories($conn);
        $this->reminders($conn);
        $this->events($conn);
        $this->eventAttendance($conn);
    }

    protected function threads(Connection $connection)
    {
        $threads = $connection->select('SELECT * FROM threads ORDER BY threads.id');
        if (!empty($threads)) {
            foreach ($threads as $thread) {
                if ($thread->channel_id !== null && !Thread::whereId($thread->id)->exists()) {
                    $t = new Thread();
                    $t->id = $thread->id;
                    $t->discord_id = $thread->discord_id;
                    $t->guild_id = $thread->guild_id;
                    $t->channel_id = $thread->channel_id;
                    $t->tag = $thread->tag ?? '';
                    $t->created_at = $thread->created_at;
                    $t->updated_at = $thread->modified_at;
                    $t->save();
                }
            }
        }
        $this->resetSequence($connection, 'threads');
    }

    protected function channels(Connection $connection)
    {
        $channels = $connection
            ->select('SELECT * FROM channels ORDER BY channels.id');
        if (!empty($channels)) {
            foreach ($channels as $channel) {
                if (!Channel::whereId($channel->id)->exists()) {
                    $c = new Channel();
                    $c->id = $channel->id;
                    $c->discord_id = $channel->discord_id;
                    $c->guild_id = $channel->guild_id;
                    $c->created_at = $channel->created_at;
                    $c->updated_at = $channel->modified_at;
                    $c->save();
                }
            }
        }
        $this->resetSequence($connection, 'channels');
    }

    protected function members(Connection $connection)
    {
        $members = $connection
            ->select('SELECT * FROM members ORDER by members.id');
        if (!empty($members)) {
            foreach ($members as $member) {
                if (!Member::whereId($member->id)->exists()) {
                    $m = new Member();
                    $m->id = $member->id;
                    $m->discord_id = $member->discord_id;
                    $m->guild_id = $member->guild_id;
                    $m->total_comments = $member->total_comments;
                    $m->username = $member->username ?? 'Unknown';
                    $m->verified_by = $member->verified_by;
                    $m->created_at = $member->created_at;
                    $m->updated_at = $member->modified_at;
                    $m->save();
                }
            }
        }
        $this->resetSequence($connection, 'members');
    }

    protected function guilds(Connection $connection)
    {
        $guilds = $connection
            ->select('SELECT * FROM guilds ORDER BY guilds.id');
        if (!empty($guilds)) {
            foreach ($guilds as $guild) {
                if (!Guild::whereId($guild->id)->exists()) {
                    $g = new Guild();
                    $g->id = $guild->id;
                    $g->discord_id = $guild->discord_id;
                    $g->channel_announce_id = $guild->output_channel_id;
                    $g->channel_thread_announce_id = $guild->output_thread_id;
                    $g->created_at = $guild->created_at;
                    $g->updated_at = $guild->modified_at;
                    $g->save();
                }
            }
        }
        $this->resetSequence($connection, 'guilds');
    }

    protected function reminders(Connection $connection)
    {
        $reminders = $connection
            ->select('SELECT * FROM reminders ORDER BY reminders.id');
        if (!empty($reminders)) {
            foreach ($reminders as $reminder) {
                if (!Reminder::whereId($reminder->id)->exists()) {
                    $r = new Reminder();
                    $r->id = $reminder->id;
                    $r->description = $reminder->description;
                    $r->mention_role = $reminder->mention_role;
                    $r->scheduled_at = $reminder->scheduled_at;
                    $r->repeats = $reminder->repeats;
                    $r->channel_id = $reminder->channel_id;
                    $r->guild_id = $reminder->guild_id;
                    $r->created_at = $reminder->created_at;
                    $r->updated_at = $reminder->modified_at;
                    $r->save();
                }
            }
        }
        $this->resetSequence($connection, 'reminders');
    }

    protected function events(Connection $connection)
    {
        $events = $connection
            ->select('SELECT * FROM events ORDER BY events.id');
        if (!empty($events)) {
            foreach ($events as $event) {
                if (!Event::whereId($event->id)->exists()) {
                    $e = new Event();
                    $e->id = $event->id;
                    $e->guild_id = $event->guild_id;
                    $e->discord_channel_id = $event->channel_id;
                    $e->name = $event->name;
                    $e->type = $event->type;
                    $e->sesh_message_id = $event->sesh_id;
                    $e->native_event_id = $event->native_id;
                    $e->created_at = $event->created_at;
                    $e->updated_at = $event->modified_at;
                    $e->save();
                }
            }
        }
        $this->resetSequence($connection, 'events');
    }

    protected function eventAttendance(Connection $connection)
    {
        $attendances = $connection
            ->select('SELECT * FROM event_attendance ORDER BY event_attendance.id');
        if (!empty($attendances)) {
            foreach ($attendances as $attendance) {
                if (!EventAttendance::whereId($attendance->id)->exists()) {
                    $e = new EventAttendance();
                    $e->id = $attendance->id;
                    $e->event_id = $attendance->event_id;
                    $e->member_id = $attendance->member_id;
                    $e->status = $attendance->status;
                    $e->no_show = (bool)$attendance->no_show;
                    $e->created_at = $attendance->created_at;
                    $e->updated_at = $attendance->modified_at;
                    $e->save();
                }
            }
        }
        $this->resetSequence($connection, 'event_attendances');
    }

    protected function directories(Connection $connection)
    {
        $directories = $connection
            ->select('SELECT * FROM directories ORDER BY directories.id');
        if (!empty($directories)) {
            foreach ($directories as $directory) {
                if (!Directory::whereId($directory->id)->exists()) {
                    $d = new Directory();
                    $d->id = $directory->id;
                    $d->directory_channel_id = $directory->directory_channel_id;
                    $d->forum_channel_id = $directory->forum_channel_id;
                    $d->embed_id = $directory->embed_id;
                    $d->created_at = $directory->created_at;
                    $d->updated_at = $directory->modified_at;
                    $d->save();
                }
            }
        }
        $this->resetSequence($connection, 'directories');
    }

    protected function resetSequence(Connection $connection, string $table, string $column = 'id'): void
    {
        $max = $connection->select('SELECT MAX($column) as next_val FROM $table)');
        if (!$max || (int)$max->next_val <= 0) {
            throw new \BadMethodCallException("Unable to get next value for $table");
        }
        $query = "ALTER TABLE $table
    ALTER COLUMN $column RESTART SET START {$max->next_val};
";
        $connection->select($query);
    }
}
