<?php

namespace App\Models\Traits;

use App\Models\Like;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * The attributes that should be cast.
 *
 * @mixin Model
 */
trait Likeable
{
    public static function bootLikeable()
    {
        static::deleting(function ($model) {
            $model->removeLikes();
        });
    }

    //delete like when model is being deleted
    public function removeLikes()
    {
        if ($this->likes()->count()) {
            $this->likes()->delete();
        }
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function like()
    {
        if (!Auth::check()) {
            return;
        }
        // check if the current user has already liked the model
        if ($this->isLikedByUser(Auth::id())) {
            return;
        }

        $this->likes()->create([
            'user_id' => Auth::id()
        ]);
    }

    public function unlike()
    {
        if (!Auth::check()) return;

        if (!$this->isLikedByUser(Auth::id())) return;

        $this->likes()->where('user_id', Auth::id())->delete();
    }

    public function isLikedByUser(string $user_id): bool
    {
        return (bool)$this->likes()->where('user_id', $user_id)->count();
    }

}