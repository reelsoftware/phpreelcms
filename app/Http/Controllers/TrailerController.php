<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Seasons;
use App\Handler\Content\ContentHandler;
use App\Handler\Theme\Theme;


class TrailerController extends Controller
{
    public function showSeason($id)
    {
        //TO DO Check if the series is public or not
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

        return Theme::view('trailer.show', [
            'item' => $trailer,
        ]);
    }

    public function showMovie($id)
    {
        $trailer = ContentHandler::getMovieTrailer($id);

        if($trailer == null)
            return abort(404);

        return Theme::view('trailer.show', [
            'item' => $trailer,
        ]);
    }
}
