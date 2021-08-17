<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Video;
use File;
use App\Models\User;

class VideoTest extends TestCase
{
    use RefreshDatabase;

    public function test_no_premium_no_auth_no_logged_in_user_video()
    {
        $file = Storage::disk('local')->put('/', UploadedFile::fake()->create('video.mp4', 100));

        $video = Video::factory()->create([
            'name' => $file,
            'storage' => 'local',
            'premium' => 0,
            'auth' => 0
        ]);

        $response = $this->get("/resource/video/local/$file");

        $response->assertStatus(200);

        Storage::disk('local')->delete($file);
    }

    public function test_no_premium_auth_no_logged_in_user_video()
    {
        $file = Storage::disk('local')->put('/', UploadedFile::fake()->create('video.mp4', 100));

        $video = Video::factory()->create([
            'name' => $file,
            'storage' => 'local',
            'premium' => 0,
            'auth' => 1
        ]);

        $response = $this->get("/resource/video/local/$file");

        $response->assertRedirect("/login");

        Storage::disk('local')->delete($file);
    }

    public function test_premium_auth_no_logged_in_user_video()
    {
        $file = Storage::disk('local')->put('/', UploadedFile::fake()->create('video.mp4', 100));

        $video = Video::factory()->create([
            'name' => $file,
            'storage' => 'local',
            'premium' => 1,
            'auth' => 1
        ]);

        $response = $this->get("/resource/video/local/$file");

        $response->assertRedirect("/subscribe");

        Storage::disk('local')->delete($file);
    }

    public function test_no_premium_auth_logged_in_user_video()
    {
        $user = User::factory()->create();
        $file = Storage::disk('local')->put('/', UploadedFile::fake()->create('video.mp4', 100));

        $video = Video::factory()->create([
            'name' => $file,
            'storage' => 'local',
            'premium' => 0,
            'auth' => 1
        ]);

        $response = $this->actingAs($user)->get("/resource/video/local/$file");

        $response->assertStatus(200);

        Storage::disk('local')->delete($file);
    }
}
