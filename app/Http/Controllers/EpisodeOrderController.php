<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Episode;
use App\Models\Seasons;

class EpisodeOrderController extends Controller
{
    public function edit($id)
    {
        $episodes = Episode::where('season_id', '=', $id)
            ->orderBy('episodes.order', 'asc')
            ->select([
                'id', 
                'title', 
                'order', 
            ])
            ->get();

        return view('episodes.order', [
            'content' => $episodes,
            'id' => $id
        ]);
    }

    public function update(Request $request, $id)
    {
        //Iterate throughout the order list and add validation rules to all of them

        //Add the first item to the array
        $orderItem = 0;

        $validationArray = [];

        //Add validation rules
        for($i=0;$i<$request->countEpisodes;$i++)
        {
            $validationArray['order' . $i] = 'required|string';
            $validationArray['item' . $i] = 'required|numeric';
        }

        $validated = $request->validate($validationArray);

        //Add seasons id to seasons array
        $episodesIds = [];

        for($i=0;$i<$request->countEpisodes;$i++)
        {
            array_push($episodesIds, $request['item' . $i]);
        }
        //Get all the seasons that are being modified
        $episodes = Episode::whereIn('id', $episodesIds)->orderBy('order', 'ASC')->get();

        //Update order and save to the database
        foreach($episodes as $key => $episode)
        {
            $episode->order = $request['order' . $key];
            $episode->save();
        }

        return redirect()->route('seasonDashboard');
    }
}
