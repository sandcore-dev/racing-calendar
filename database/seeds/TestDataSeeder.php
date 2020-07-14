<?php

use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserDataSeeder::class);
        
        $this->seedORM();
    }
    
    /**
     * Seed random data through ORM.
     */
    protected function seedORM()
    {
        $populator = populator();
        
        $populator
            ->add(App\Championship::class, 3)
            ->add(App\Season::class, 3)
            ->add(App\Country::class, 22)
            ->add(App\Circuit::class, 22)
            ->add(App\Location::class, 8)
            ->add(App\Race::class, 22)
            ->seed();
    }
}
