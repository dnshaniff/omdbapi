<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = auth()->user()->favorites()->pluck('imdb_id');

        $titles = [];
        $apiKey = config('services.omdb.key');

        foreach ($favorites as $imdbID) {
            $response = Http::get('http://www.omdbapi.com/', [
                'apikey' => $apiKey,
                'i' => $imdbID,
            ]);

            if ($response->ok() && $response['Response'] === 'True') {
                $titles[] = $response->json();
            }
        }

        return view('favorites-index', compact('titles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'imdb_id' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        $exists = Favorite::where('user_id', $user->id)
            ->where('imdb_id', $request->imdb_id)
            ->exists();

        if (! $exists) {
            Favorite::create([
                'user_id' => $user->id,
                'imdb_id' => $request->imdb_id,
            ]);
        }

        return back()->with('success', __('messages.dashboard.favorite_added'));
    }

    public function destroy(string $imdbID)
    {
        $user = Auth::user();

        Favorite::where('user_id', $user->id)
            ->where('imdb_id', $imdbID)
            ->delete();

        return back()->with('success', __('messages.dashboard.favorite_removed'));
    }
}
