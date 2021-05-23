<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Seasons;


class TrailerController extends Controller
{
    public function showSeason($id)
    {
        $trailer = Seasons::where('seasons.id', '=', $id)
            ->join('series', 'seasons.series_id', '=', 'series.id')
            ->join('videos', 'videos.id', '=', 'seasons.trailer')
            ->first([
                'series.title as series_title',
                'seasons.title as season_title',
                'series.id as series_id',
                'videos.name as video_name',
                'videos.storage as video_storage',
            ]);

        if($trailer == null)
            return abort(404);

        return view('trailer.show', [
            'trailer' => $trailer,
        ]);
    }

    public function showMovie($id)
    {
        $trailer = Movie::where([['movies.public', '=', '1'], ['movies.id', '=', $id]])
            ->join('videos', 'videos.id', '=', 'movies.trailer')
            ->select(
                'movies.id as id',
                'movies.title as title',
                'videos.name as video_name',
                'videos.storage as video_storage',
            )
            ->first();

        if($trailer == null)
            return abort(404);

        return view('trailer.show', [
            'trailer' => $trailer,
        ]);
    }
}
