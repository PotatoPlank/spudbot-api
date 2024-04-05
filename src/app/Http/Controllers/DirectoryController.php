<?php

namespace App\Http\Controllers;

use App\Http\Requests\Directory\DirectoryCreateRequest;
use App\Http\Requests\Directory\DirectoryRequest;
use App\Http\Resources\DirectoryResource;
use App\Models\Channel;
use App\Models\Directory;

class DirectoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DirectoryRequest $request)
    {
        $directory = Directory::with(['forumChannel', 'directoryChannel']);
        if ($request->has('embed_id')) {
            $directory->whereEmbedId($request->validated('embed_id'));
        }
        if ($request->has('forum_channel')) {
            $directory->whereForumChannelId(
                Channel::whereExternalId($request->validated('forum_channel'))->first()?->id
            );
        }
        return DirectoryResource::collection($directory->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DirectoryCreateRequest $request)
    {
        $directory = new Directory();
        $directory->directoryChannel()->associate(
            Channel::whereExternalId($request->validated('directory_channel'))->first()
        );
        $directory->forumChannel()->associate(
            Channel::whereExternalId($request->validated('forum_channel'))->first()
        );
        $directory->embed_id = $request->validated('embed_id');
        $directory->save();

        return new DirectoryResource($directory->load(['forumChannel', 'directoryChannel']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Directory $directory)
    {
        return new DirectoryResource($directory->load(['forumChannel', 'directoryChannel']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DirectoryRequest $request, Directory $directory)
    {
        return response([
            'message' => 'Directories cannot be updated.',
        ], 302);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Directory $directory)
    {
        $directory->delete();

        return response(status: 204);
    }
}
