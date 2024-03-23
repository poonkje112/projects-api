<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
    }

    public function show(Member $member)
    {
        return Member::with('projects')->find($member->id);
    }

    public function store(Request $request)
    {
        return Member::create($request->all());
    }

    public function update(Request $request, Member $member)
    {
        return $member->update($request->all());
    }

    public function destroy(Member $member)
    {
        return $member->delete();
    }
}
