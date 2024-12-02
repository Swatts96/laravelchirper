<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Exception\CommonMarkException;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     * @throws CommonMarkException
     */


    public function index(): View
    {
        $chirps = Chirp::with('user')->latest()->get();

        // Convert markdown to HTML for each chirp
        $converter = new CommonMarkConverter();
        foreach ($chirps as $chirp) {
            $chirp->message = $converter->convertToHtml($chirp->message);
        }

        return view('chirps.index', [
            'chirps' => $chirps,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $request->user()->chirp()->create($validated);

        return redirect()->route('chirps.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        return view('chirps.show', [
            'chirp' => $chirp,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp): View
    {
        Gate::authorize('update', $chirp);

        return view('chirps.edit', [
            'chirp' => $chirp,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        //
        Gate::authorize('update', $chirp);

        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $chirp->update($validated);

        return redirect(route('chirps.index'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
        Gate::authorize('delete', $chirp);

        $chirp->delete();

        return redirect(route('chirps.index'));
    }
}
