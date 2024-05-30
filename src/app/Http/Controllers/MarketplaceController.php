<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarketplaceRequest;
use App\Http\Requests\StoreMarketplaceRequest;
use App\Http\Requests\UpdateMarketplaceRequest;
use App\Http\Resources\MarketplaceResource;
use App\Models\Marketplace;
use App\Models\Member;

class MarketplaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MarketplaceRequest $request)
    {
        $marketplaces = Marketplace::with(['member',]);
        if ($request->has('discord_id')) {
            $marketplaces->whereDiscordId($request->validated('discord_id'));
        }
        if ($request->has('member')) {
            $marketplaces->whereMemberId(Member::whereExternalId($request->validated('member'))->first()?->id);
        }
        return MarketplaceResource::collection($marketplaces->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMarketplaceRequest $request)
    {
        $marketplace = new Marketplace();
        $marketplace->fill($request->validated());
        $marketplace->member()
            ->associate(Member::whereExternalId($request->validated('member'))->first());
        $marketplace->save();

        return new MarketplaceResource($marketplace->load(['member',]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Marketplace $marketplace)
    {
        return new MarketplaceResource($marketplace->load(['member',]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMarketplaceRequest $request, Marketplace $marketplace)
    {
        $marketplace->fill($request->validated());
        $marketplace->save();

        return new MarketplaceResource($marketplace->load(['member',]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Marketplace $marketplace)
    {
        $marketplace->delete();

        return response(status: 204);
    }
}
