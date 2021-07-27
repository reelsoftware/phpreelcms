<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Seasons;
use App\Helpers\Content\ContentHandler;
use App\Helpers\Theme\Theme;

class TrailerController extends Controller
{
    public function showSeason($id)
    {
        //TO DO Check if the series is public or not
        $trailer = ContentHandler::getSeriesTrailer($id);

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
