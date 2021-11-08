<?php

namespace App\Repositories\Eloquent;

use App\Http\Resources\DesignResource;
use App\Models\Design;
use App\Models\User;
use App\Repositories\Contracts\IDesign;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DesignRepository extends BaseRepository implements IDesign
{
    public function __construct(Design $model)
    {
        parent::__construct($model);
    }

    public function applyTags(Design $design, array $data)
    {
        $design->retag($data);
    }

    public function allLive()
    {
        return Design::where('is_live', true)->get();
    }

    public function addComment(Design $design, array $data): Model
    {
        //create the comment for the design
        return $design->comments()->create($data);
    }

    public function like(Design $design)
    {
        if ($design->isLikedByUser(auth()->id())) {
            $design->unlike();
        } else {
            $design->like();
        }
    }

    public function isLikedByUser(Design $design): bool
    {
        return $design->isLikedByUser(auth()->id());
    }

    public function search(Request $request)
    {
        $query = $this->model->query();
        $query->where('is_live', true);

        // return only designs with comments
        if ($request->input('has_comments')) {
            $query->has('comments');
        }

        // return only designs assigned to teams
        if ($request->input('has_team')) {
            $query->has('team');
        }

        // search title and description for provided string
        if ($request->has('q')) {
            $query->where(function (Builder $builder) use ($request) {
                $builder->where('title', 'like', '%' . $request->query('q') . '%')
                    ->orWhere('description', 'like', '%' . $request->query('q') . '%');
            });
        }

        // order the query by likes or latest first
        if ($request->input('orderBy') == 'likes') {
            $query->withCount('likes')->orderByDesc('likes_count');
        } else {
            $query->latest();
        }

        return $query->get();
    }
}