<?php

namespace Database\Seeders;

use App\Models\Championship;
use App\Models\Location;
use App\Models\Race;
use App\Models\RaceSession;
use App\Models\Season;
use App\Models\Template;
use App\Models\TemplateSession;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->state(['email' => 'webmaster@localhost'])
            ->create();

        Template::factory()
            ->has(
                TemplateSession::factory()
                    ->count(5),
                'sessions'
            )
            ->count(5)
            ->create();

        $championshipFactory = Championship::factory()
            ->has(
                Season::factory()
                    ->has(
                        Race::factory()
                            ->has(
                                RaceSession::factory()
                                    ->count(5),
                                'sessions'
                            )
                            ->count(20)
                    )
                    ->has(
                        Location::factory()
                            ->count(10)
                    )
                    ->count(5)
            );

        $championshipFactory
            ->state(['domain' => parse_url(config('app.url'), PHP_URL_HOST)])
            ->create();

        $championshipFactory
            ->count(5)
            ->create();
    }
}
