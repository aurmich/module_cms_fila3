<?php

namespace Modules\SaluteOra\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        return view('reporting::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        return view('reporting::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\Illuminate\Http\Request $request): \Illuminate\Http\RedirectResponse
    {
        // Implementation of store method
        return redirect()->back();
    }

    /**
     * Show the specified resource.
     */
    public function show(int $id): \Illuminate\Contracts\View\View
    {
        return view('reporting::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): \Illuminate\Contracts\View\View
    {
        return view('reporting::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\Illuminate\Http\Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        // Implementation of update method
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        // Implementation of destroy method
        return redirect()->back();
    }
}
