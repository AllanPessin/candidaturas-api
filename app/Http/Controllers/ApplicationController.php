<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreApplicationRequest;
use App\Http\Requests\Update\UpdateApplicationRequest;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $applications = Application::when($request->search, function ($query) use ($request) {
            $query->where('position', 'like', '%' . $request->search . '%');
        })
            ->paginate(10);

        return ApplicationResource::collection($applications);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicationRequest $request)
    {
        $validated = $request->validated();

        Application::create($validated);

        return response()->json([
            'message' => 'Application created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        return new ApplicationResource($application);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApplicationRequest $request, Application $application)
    {
        $validated = $request->validated();
        $application->update($validated);

        return new ApplicationResource($application);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        $application->delete();

        return response()->json([
            'message' => 'Application deleted successfully',
        ]);
    }
}
