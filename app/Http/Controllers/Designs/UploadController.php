<?php

namespace App\Http\Controllers\Designs;

use App\Http\Controllers\Controller;
use App\Jobs\UploadImage;
use App\Models\Design;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    //
    public function upload(Request $request)
    {
        $request->validate(['image' => ['required', 'image', 'max:2048']]);
        //get the image
        $image = $request->file('image');
        $image_path = $image->getPathname();

        // get the original file name and replace any spaces with _
        // Business card.png = timestamp()_card.png
        $filename = time() . "_" . preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));

        // move the image to the temporary location (tmp)
        $tmp = $image->storeAs('uploads/original', $filename, 'tmp');

        //create the database record the design
        $design = Auth::user()->designs()->create([
            'image' => $filename,
            'disk' => config('site.upload_disk')
        ]);

        // dispatch a job to handle the image manipulation
        /** @var Design $design */
        $this->dispatch(new UploadImage($design));

        return response()->json($design, 200);
    }
}
