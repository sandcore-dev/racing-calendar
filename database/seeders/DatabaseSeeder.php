<?php

namespace Database\Seeders;

use App\Models\Championship;
use App\Models\Circuit;
use App\Models\Country;
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
                TemplateSession::factory(),
                'sessions'
            )
            ->count(5)
            ->create();

        Championship::factory()
            ->count(5)
            ->has(
                Season::factory()
                    ->has(
                        Race::factory()
                            ->for(
                                Circuit::factory()
                                    ->for(
                                        Country::factory()
                                    )
                            )
                            ->for(
                                Location::factory()
                            )
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
            )
            ->create();
    }
}
