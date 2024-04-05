<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        return Member::all();
    }

    public function show(Member $member)
    {
        return Member::with('projects')->find($member->id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'portfolio' => 'nullable|url'
        ]);

        return Member::create($request->all());
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required',
            'portfolio' => 'nullable|url'
        ]);
        return $member->update($request->all());
    }

    public function destroy(Member $member)
    {
        return $member->delete();
    }
}
