<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMarketplaceRequest;
use App\Http\Requests\UpdateMarketplaceRequest;
use App\Http\Resources\MarketplaceResource;
use App\Models\Marketplace;

class MarketplaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return MarketplaceResource::collection(Marketplace::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMarketplaceRequest $request)
    {
        $marketplace = Marketplace::create($request->validated());

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
        $marketplace->last_status = $request->validated('last_status') ?? $marketplace->last_status;
        $marketplace->tags = $request->validated('tags') ?? $marketplace->tags;
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
