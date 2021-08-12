<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Movie;

class MovieTest extends DuskTestCase
{

    /**
     * A Dusk test example.
     *
     * @return void
     */
    
    public function testShowMovie()
    {
        $this->browse(function (Browser $browser, $movie) {
            $browser->visit('/dashboard/movie/create')
                ->type('title', $movie->title);

        });
    }

    
    /**
     * A Dusk test example.
     *
     * @return void
     */
    /*
    public function testCreateMovie()
    {
        $movie = Movie::factory()->count(50)->create();
        dd($movie);
        $this->browse(function (Browser $browser, $movie) {
            $browser->visit('/dashboard/movie/create')
                ->type('title', $movie->title);

        });
    }*/
}
