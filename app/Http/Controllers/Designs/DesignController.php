<?php

namespace App\Http\Controllers\Designs;

use App\Http\Controllers\Controller;
use App\Http\Resources\DesignResource;
use App\Models\Design;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DesignController extends Controller
{
    //
    public function update(Request $request, Design $design): DesignResource
    {
        $data = $request->validate([
            'title' => ['required', Rule::unique('designs')->ignore($design->id)],
            'description' => ['required', 'string', 'min:20', 'max:140'],
            'tags' => ['required']
        ]);
        $this->authorize('update', $design);
        $design->update($data + [
                'slug' => Str::slug($data['title']),
                'is_live' => !$design->upload_successful ? false : $request->input('is_live')
            ]);

        //apply the tag
        $design->retag($data['tags']);

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

        $design->delete();

        return response()->json(['message' => 'Record deleted'], 200);
    }
}
