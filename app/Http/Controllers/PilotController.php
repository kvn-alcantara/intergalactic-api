<?php

namespace App\Http\Controllers;

use App\Http\Resources\PilotCollection;
use App\Http\Resources\PilotResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StorePilotRequest;
use App\Http\Requests\UpdatePilotRequest;
use App\Models\Pilot;

class PilotController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        // $this->authorizeResource(Pilot::class, 'pilot');
    }

    /**
     * Display a listing of the resource.
     *
     * @return PilotCollection
     */
    public function index(): PilotCollection
    {
        $pilots = Pilot::with('ship')->paginate();

        return new PilotCollection($pilots);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePilotRequest $request
     * @return PilotResource
     */
    public function store(StorePilotRequest $request): PilotResource
    {
        $pilot = Pilot::create($request->validated());

        $pilot->loadMissing('ship');

        return new PilotResource($pilot);
    }

    /**
     * Display the specified resource.
     *
     * @param Pilot $pilot
     * @return PilotResource
     */
    public function show(Pilot $pilot): PilotResource
    {
        $pilot->loadMissing('ship');

        return new PilotResource($pilot);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePilotRequest $request
     * @param Pilot $pilot
     * @return PilotResource
     */
    public function update(UpdatePilotRequest $request, Pilot $pilot): PilotResource
    {
        $pilot->update($request->validated());

        $pilot->loadMissing('ship');

        return new PilotResource($pilot);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Pilot $pilot
     * @return JsonResponse
     */
    public function destroy(Pilot $pilot): JsonResponse
    {
        $pilot->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
