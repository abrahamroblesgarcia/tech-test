<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\User;
use App\Models\Track;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = User::factory()
            ->count(10)
            ->create();

        $users->each(function ($user) {
            Track::factory()
                ->count(10)
                ->for($user)->create();
        });

        $tracks = Track::inRandomOrder()->take(10)->get();
        $users = User::inRandomOrder()->take(10)->get();

        $tracks->each(function ($track) use ($users) {
            $users->each(function ($user) use ($track) {
                $l = new Like();
                $l->track()->associate($track);
                $l->user()->associate($user);
                $l->save();
            });
        });
    }
}
