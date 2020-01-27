<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Http\Resources\Group as GroupResource;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collection = Group::where('owner_id', auth()->user()->id)
            ->orderBy('name', 'asc')
            ->get();

        return GroupResource::collection($collection);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:groups,name',
            'users' => 'present|array',
            'users.*' => 'uuid|distinct|exists:users,id',
        ]);

        $group = new Group();
        $group->name = $validatedData['name'];
        $group->save();

        $group->users()->attach($validatedData['users']);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        if (!$this->isOwner($group)) {
            throw ModelNotFoundException;
        }

        return new GroupResource($group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        if (!$this->isOwner($group)) {
            return response()->json([
                'success' => false
            ]);
        }

        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('groups', 'name')->ignore($group->id)
            ],
            'users' => 'present|array',
            'users.*' => 'uuid|distinct|exists:users,id',
        ]);

        $group->name = $validatedData['name'];
        $group->save();

        $group->users()->sync($validatedData['users']);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        if (!$this->isOwner($group)) {
            return response()->json([
                'success' => false
            ]);
        }

        $group->delete();

        return response()->json([
            'success' => true
        ]);
    }

    private function isOwner(Group $group) {
        return $group->owner_id === auth()->user()->id;
    }
}
