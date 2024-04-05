<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Member;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::all();
    }

    public function show(Project $project)
    {
        // Get project with members and tags
        return Project::with('members', 'tags')->find($project->id);
    }

    public function store(Request $request)
    {
        $project = new Project;

        // Validate the request
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'youtube' => 'nullable|regex:/^[a-zA-Z0-9_-]{11}$/',
            'git' => 'nullable|url',
            'live' => 'nullable|url'
        ]);

        $project->slug = strtolower(str_replace(' ', '-', $request->title));

        $project->fill($request->all());
        $project->save();

        return $project;
    }

    public function update(Request $request, Project $project)
    {
        // Validate the request
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'youtube' => 'nullable|regex:/^[a-zA-Z0-9_-]{11}$/',
            'git' => 'nullable|url',
            'live' => 'nullable|url'
        ]);

        return $project->update($request->all());
    }

    public function addMember(Project $project, Member $member)
    {
        if ($project->members->contains($member->id)) {
            return response()->json(['error' => 'Member already in project'], 400);
        }

        $project->members()->attach($member->id);

        return $this->show($project);
    }

    public function removeMember(Project $project, Member $member)
    {
        if (!$project->members->contains($member->id)) {
            return response()->json(['error' => 'Member not in project'], 400);
        }

        $project->members()->detach($member->id);

        return $this->show($project);
    }

    public function addTag(Project $project, Tag $tag)
    {
        if ($project->tags->contains($tag->id)) {
            return response()->json(['error' => 'Tag already attached to project'], 400);
        }

        $project->tags()->attach($tag->id);

        return $this->show($project);
    }

    public function removeTag(Project $project, Tag $tag)
    {
        if (!$project->tags->contains($tag->id)) {
            return response()->json(['error' => 'Tag not attached to project'], 400);
        }
        $project->tags()->detach($tag->id);

        return $this->show($project);
    }

    public function destroy(Project $project)
    {
        return $project->delete();
    }
}
