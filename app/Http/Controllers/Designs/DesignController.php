<?php

namespace App\Http\Controllers\Designs;

use App\Http\Controllers\Controller;
use App\Http\Resources\DesignResource;
use App\Models\Design;
use App\Repositories\Contracts\IDesign;
use App\Repositories\Eloquent\Criterion\ForUser;
use App\Repositories\Eloquent\Criterion\IsLive;
use App\Repositories\Eloquent\Criterion\LatestFirst;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DesignController extends Controller
{
    protected IDesign $designRepo;

    public function __construct(IDesign $designRepo)
    {
        $this->designRepo = $designRepo;
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $designs = $this->designRepo->withCriteria(new LatestFirst(), new IsLive(), new ForUser(1))->all();
        return DesignResource::collection($designs);
    }

    //
    public function update(Request $request, Design $design): DesignResource
    {
        $data = $request->validate([
            'title' => ['required', Rule::unique('designs')->ignore($design->id)],
            'description' => ['required', 'string', 'min:20', 'max:140'],
            'tags' => ['required']
        ]);
        $this->authorize('update', $design);
        $this->designRepo->update($design, $data + [
                'slug' => Str::slug($data['title']),
                'is_live' => !$design->upload_successful ? false : $request->input('is_live')
            ]);

        //apply the tag
        $this->designRepo->applyTags($design, $data['tags']);

        return new DesignResource($design);
    }

    public function destroy(Design $design)
    {
        $this->authorize('delete', $design);

        //delete the file associated to the record
        foreach (['thumbnail', 'large', 'original'] as $size) {
            if (Storage::disk($design->disk)->exists("uploads/designs/{$size}/{$design->image}")) {
                Storage::disk($design->disk)->delete("uploads/designs/{$size}/{$design->image}");
            }
        }

        $this->designRepo->delete($design);

        return response()->json(['message' => 'Record deleted'], 200);
    }

    public function findDesign($id)
    {
        $design = $this->designRepo->find($id);
        return new DesignResource($design);
    }
}
