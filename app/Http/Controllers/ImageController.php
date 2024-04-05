<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function show(int $id)
    {
        $image = Image::find($id);

        if (!$image) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        return Storage::disk('public')->response($image->path);
    }

    public function showProjectCollection(Project $project)
    {
        return $project->images;
    }

    public function showProjectCover(Project $project)
    {
        return Storage::disk('public')->response($project->getCover()->path);
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'project_slug' => 'required',
            'image' => 'required|image'
        ]);

        // Check if the project exists
        $project = Project::where('slug', $request->project_slug)->first();

        if (!$project) {
            return response()->json(['error' => 'Project not found'], 404);
        }

        // Check if the image is valid
        if (!$request->hasFile('image') || !$request->file('image')->isValid()) {
            return response()->json(['error' => 'Invalid image'], 400);
        }

        // Save the image
        $image = $request->file('image');
        $imagePath = $image->store('images', 'public');

        // Create the image, associate it with the project, and store it in the database
        $newImage = new Image();
        $newImage->project_id = $project->id;
        $newImage->path = $imagePath;
        $newImage->save();

        return $newImage;
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'is_cover' => 'required|boolean'
        ]);

        $image = Image::find($id);

        if (!$image) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        if($request->is_cover === true) {
            // Check if another image is already marked as cover
            $coverImage = $image->project->images->firstWhere('is_cover', true);

            // If another image is marked as cover, unmark it
            if ($coverImage) {
                $coverImage->is_cover = false;
                $coverImage->save();
            }
        }

        $image->is_cover = $request->is_cover;        
        $image->save();

        return response()->json(['message' => 'Image updated successfully'], 200);
    }

    public function destroy(int $id)
    {
        $image = Image::find($id);

        if (!$image) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        Storage::disk('public')->delete($image->path);
        $image->delete();

        return response()->json(['message' => 'Image deleted successfully'], 200);
    }
}
