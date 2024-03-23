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

        $project->title = $request->title;
        $project->slug = strtolower(str_replace(' ', '-', $request->title));
        $project->description = $request->description;

        $project->save();

        return $project;
    }

    public function update(Request $request, Project $project)
    {
        return $project->update($request->all());
    }

    public function addMember(Project $project, Member $member)
    {
        $project->members()->attach($member->id);

        return $this->show($project);
    }

    public function removeMember(Project $project, Member $member)
    {
        $project->members()->detach($member->id);

        return $this->show($project);
    }

    public function addTag(Project $project, Tag $tag)
    {
        $project->tags()->attach($tag->id);

        return $this->show($project);
    }

    public function removeTag(Project $project, Tag $tag)
    {
        $project->tags()->detach($tag->id);

        return $this->show($project);
    }

    public function destroy(Project $project)
    {
        return $project->delete();
    }
}
