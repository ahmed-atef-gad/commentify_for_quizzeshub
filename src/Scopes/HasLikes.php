<?php

namespace Usamamuneerchaudhary\Commentify\Scopes;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Usamamuneerchaudhary\Commentify\Models\CommentLike;
use Usamamuneerchaudhary\Commentify\Models\User;

// trait HasLikes
// {
//     /**
//      * @return HasMany
//      */
//     public function likes(): HasMany
//     {
//         return $this->hasMany(CommentLike::class);
//     }

//     /**
//      * @return false|int
//      */
//     public function isLiked(): bool|int
//     {
//         $ip = request()->ip();
//         $userAgent = request()->userAgent();
//         if (auth()->user()) {
//             return User::with('likes')->whereHas('likes', function ($q) {
//                 $q->where('comment_id', $this->id);
//             })->count();
//         }

//         if ($ip && $userAgent) {
//             return $this->likes()->forIp($ip)->forUserAgent($userAgent)->count();
//         }

//         return false;
//     }

//     /**
//      * @return bool
//      */
//     public function removeLike(): bool
//     {
//         $ip = request()->ip();
//         $userAgent = request()->userAgent();
//         if (auth()->user()) {
//             return $this->likes()->where('user_id', auth()->user()->id)->where('comment_id', $this->id)->delete();
//         }

//         if ($ip && $userAgent) {
//             return $this->likes()->forIp($ip)->forUserAgent($userAgent)->delete();
//         }

//         return false;
//     }
// }


trait HasLikes
{
    /**
     * Define the relationship between a comment and its likes.
     *
     * @return HasMany
     */
    public function likes(): HasMany
    {
        return $this->hasMany(CommentLike::class);
    }

    /**
     * Check if the current user (or guest via IP and user agent) has liked the comment.
     *
     * @return bool
     */
    public function isLiked(): bool
    {
        $ip = request()->ip();
        $userAgent = request()->userAgent();

        // For authenticated users
        if (auth()->check()) {
            return $this->likes()->where('user_id', auth()->id())->exists();
        }

        // For guests (using IP and user agent)
        if ($ip && $userAgent) {
            return $this->likes()->where('ip', $ip)->where('user_agent', $userAgent)->exists();
        }

        return false;
    }

    /**
     * Remove the like from the comment (either by authenticated user or guest).
     *
     * @return bool
     */
    public function removeLike(): bool
    {
        $ip = request()->ip();
        $userAgent = request()->userAgent();

        // Remove like for authenticated user
        if (auth()->check()) {
            return $this->likes()->where('user_id', auth()->id())->delete() > 0;
        }

        // Remove like for guest (by IP and user agent)
        if ($ip && $userAgent) {
            return $this->likes()->where('ip', $ip)->where('user_agent', $userAgent)->delete() > 0;
        }

        return false;
    }
}
