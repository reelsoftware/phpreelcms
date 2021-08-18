<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Movie;
use App\Models\User;

class MovieTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_free_no_auth_movie_no_logged_in_user()
    {
        $movie = Movie::factory()->create([
            'premium' => 0,
            'auth' => 0,
            'public' => 1
        ]);
        
        $response = $this->get("/movie/$movie->id");

        $response->assertStatus(200);
    }

    public function test_free_auth_movie_no_logged_in_user()
    {
        $movie = Movie::factory()->create([
            'premium' => 0,
            'auth' => 1,
            'public' => 1
        ]);
        
        $response = $this->get("/movie/$movie->id");

        $response->assertRedirect("/login");
    }

    public function test_subscription_auth_movie_no_logged_in_user()
    {
        $movie = Movie::factory()->create([
            'premium' => 1,
            'auth' => 1,
            'public' => 1
        ]);
        
        $response = $this->get("/movie/$movie->id");

        $response->assertRedirect("/subscribe");
    }

    public function test_private_movie_logged_in()
    {
        $user = User::factory()->create();

        $movie = Movie::factory()->create([
            'public' => 0
        ]);
        
        $response = $this->actingAs($user)->get("/movie/$movie->id");

        $response->assertStatus(404);
    }
}
