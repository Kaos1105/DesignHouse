<?php

namespace App\Http\Controllers\Designs;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Design;
use App\Repositories\Contracts\IComment;
use App\Repositories\Contracts\IDesign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //
    protected IComment $commentRepo;

    public function __construct(IComment $commentRepo, IDesign $designRepo)
    {
        $this->commentRepo = $commentRepo;
        $this->designRepo = $designRepo;
    }

    public function store(Request $request, Design $design)
    {
        $data = $request->validate([
            'body' => 'required',
        ]);

        $comment = $this->designRepo->addComment($design, [
            'body' => $data['body'],
            'user_id' => auth()->id()
        ]);

        return new CommentResource($comment);
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $data = $request->validate([
            'body' => 'required'
        ]);

        $this->commentRepo->update($comment, $data);

        return new CommentResource($comment);
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $this->commentRepo->delete($comment);

        return response()->json(['message' => 'Item deleted']);
    }
}
