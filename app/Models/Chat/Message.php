<?php

namespace App\Models\Chat;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * @mixin IdeHelperMessage
 */
class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'chat_id', 'body', 'last_read'
    ];

    protected $touches = ['chat'];

    public function getBodyAttribute($value)
    {
        if ($this->trashed()) {
            if (!Auth::check()) return null;

            return Auth::id() === $this->sender->id ? 'You deleted this message' : "{$this->sender->name} deleted this message";
        }
        return $value;
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
