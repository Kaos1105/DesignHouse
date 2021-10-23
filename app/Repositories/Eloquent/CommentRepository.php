<?php

namespace App\Repositories\Eloquent;

use App\Http\Resources\DesignResource;
use App\Models\Comment;
use App\Models\Design;
use App\Models\User;
use App\Repositories\Contracts\IComment;
use App\Repositories\Contracts\IDesign;
use Illuminate\Database\Eloquent\Model;

class CommentRepository extends BaseRepository implements IComment
{
    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }
}