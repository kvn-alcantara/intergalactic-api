<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShipRequest;
use App\Http\Requests\UpdateShipRequest;
use App\Http\Resources\ShipCollection;
use App\Http\Resources\ShipResource;
use App\Models\Ship;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShipController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        // $this->authorizeResource(Ship::class, 'ship');
    }

    /**
     * Display a listing of the resource.
     *
     * @return ShipCollection
     */
    public function index(): ShipCollection
    {
        $ships = Ship::with('pilot')->paginate();

        return new ShipCollection($ships);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreShipRequest $request
     * @return ShipResource
     */
    public function store(StoreShipRequest $request): ShipResource
    {
        $ship = Ship::create($request->validated());

        $ship->loadMissing('pilot');

        return new ShipResource($ship);
    }

    /**
     * Display the specified resource.
     *
     * @param Ship $ship
     * @return ShipResource
     */
    public function show(Ship $ship): ShipResource
    {
        $ship->loadMissing('pilot');

        return new ShipResource($ship);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateShipRequest $request
     * @param Ship $ship
     * @return ShipResource
     */
    public function update(UpdateShipRequest $request, Ship $ship): ShipResource
    {
        $ship->update($request->validated());

        $ship->loadMissing('pilot');

        return new ShipResource($ship);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Ship $ship
     * @return JsonResponse
     */
    public function destroy(Ship $ship): JsonResponse
    {
        $ship->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
