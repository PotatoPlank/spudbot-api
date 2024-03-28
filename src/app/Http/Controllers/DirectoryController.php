<?php

namespace App\Http\Controllers;

use App\Http\Resources\DirectoryResource;
use App\Models\Channel;
use App\Models\Directory;
use Illuminate\Http\Request;

class DirectoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $fields = $request->validate([
            'embed_id' => 'string',
            'forum_channel' => ['uuid', 'exists:App\Models\Channel,external_id',],
        ]);

        $directory = Directory::with(['forumChannel', 'directoryChannel']);
        if (isset($fields['embed_id'])) {
            $directory->whereEmbedId($fields['embed_id']);
        }
        if (isset($fields['forum_channel'])) {
            $directory->whereForumChannelId(Channel::whereExternalId($fields['forum_channel'])->first()?->id);
        }
        return DirectoryResource::collection($directory->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'embed_id' => 'string',
            'directory_channel' => ['required', 'uuid', 'exists:App\Models\Channel,external_id'],
            'forum_channel' => ['required', 'uuid', 'exists:App\Models\Channel,external_id'],
        ]);

        $directory = new Directory();
        $directory->directoryChannel()->associate(Channel::whereExternalId($fields['directory_channel'])->first());
        $directory->forumChannel()->associate(Channel::whereExternalId($fields['forum_channel'])->first());
        $directory->embed_id = $fields['embed_id'];
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
    public function update(Request $request, Directory $directory)
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
