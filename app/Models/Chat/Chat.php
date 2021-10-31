<?php

namespace App\Models\Chat;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperChat
 */
class Chat extends Model
{
    use HasFactory;

    // relationship method
    public function participants()
    {
        return $this->belongsToMany(User::class, 'participants');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // helper method

    public function getLatestMessageAttribute()
    {
        return $this->messages()->latest()->first();
    }

    public function isUnreadForUser(string $userId)
    {
        return (boolean)$this->messages()->whereNull('last_read')->where('user_id', '<>', $userId)->count();
    }

    public function markAsReadForUser(string $userId)
    {
        $this->messages()->whereNull('last_read')->where('user_id', '<>', $userId)->update([
            'last_read' => Carbon::now()
        ]);
    }
}
