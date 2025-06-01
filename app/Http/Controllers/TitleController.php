<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TitleController extends Controller
{
    public function index(Request $request)
    {
        $apiKey   = config('services.omdb.key');
        $keyword  = $request->input('search', 'batman');
        $page     = $request->input('page', 1);
        $year     = $request->input('year');

        $titles        = [];
        $error         = null;
        $totalResults  = 0;

        if ($request->has('search') && trim($keyword) === '') {
            $error = 'Please enter a movie or series title to search';
        } else {
            $params = [
                'apikey' => $apiKey,
                's'      => $keyword,
                'page'   => $page,
            ];

            if ($year) {
                $params['y'] = $year;
            }

            $response = Http::get('http://www.omdbapi.com/', $params);
            $data     = $response->json();

            if (isset($data['Search'])) {
                foreach ($data['Search'] as $item) {
                    $detail = Http::get('http://www.omdbapi.com/', [
                        'apikey' => $apiKey,
                        'i'      => $item['imdbID'],
                    ]);

                    $titles[] = $detail->json();
                }
            }

            $error         = $data['Error'] ?? null;
            $totalResults  = isset($data['totalResults']) ? (int) $data['totalResults'] : 0;
        }

        return view('dashboard-index', compact(
            'titles',
            'error',
            'keyword',
            'page',
            'totalResults',
            'year'
        ));
    }

    public function loadMore(Request $request)
    {
        $apiKey  = config('services.omdb.key');
        $keyword = $request->input('search', 'batman');
        $page    = $request->input('page', 1);
        $year    = $request->input('year');

        $titles = [];

        $params = [
            'apikey' => $apiKey,
            's'      => $keyword,
            'page'   => $page,
        ];

        if ($year) {
            $params['y'] = $year;
        }

        $response = Http::get('http://www.omdbapi.com/', $params);
        $data     = $response->json();

        if (isset($data['Search'])) {
            foreach ($data['Search'] as $item) {
                $detail = Http::get('http://www.omdbapi.com/', [
                    'apikey' => $apiKey,
                    'i'      => $item['imdbID'],
                ]);
                $titles[] = $detail->json();
            }
        }

        return response()->json($titles);
    }


    public function show($imdbID)
    {
        $apiKey = config('services.omdb.key');

        $response = Http::get('http://www.omdbapi.com/', [
            'apikey' => $apiKey,
            'i' => $imdbID,
            'plot' => 'full'
        ]);

        $data = $response->json();

        if ($data['Response'] === 'False') {
            abort(404, 'Movie or series not found');
        }

        return view('dashboard-show', ['title' => $data]);
    }
}
