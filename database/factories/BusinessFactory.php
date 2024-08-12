<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\BusinessUser;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;
use MatanYadaev\EloquentSpatial\Enums\Srid;
use MatanYadaev\EloquentSpatial\Objects\Point;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Business>
 */
class BusinessFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->company();
        $shops = random_int(1, 5);
        return [
            'name' => $name,
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->unique()->phoneNumber(),
            'slug' => generateSlug(new Business, $name),
            'address' => fake()->address(),
            'about' => fake()->sentences(1, true),
            'category_id' => BusinessCategory::inRandomOrder()->first()->id,
            'number_of_shops' => $shops,
            'max_shops' => $shops
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure()
    {
        return $this->afterCreating(function (Business $business) {
            $name = fake()->unique()->company();

            $owner = BusinessUser::create([
                'name' => fake()->name(),
                'email' => $business->email,
                'username' => generateUsername(new BusinessUser, explode('@', $business->email)[0]),
                'phone' => fake()->unique()->phoneNumber(),
                'business_id' => $business->id,
                'password' => bcrypt('password')
            ]);

            $owner->syncRoles(['business_admin', 'business_owner']);

            Shop::create([
                'name' => $name,
                'email' => $business->email,
                'phone' => $business->phone,
                'slug' => generateSlug(new Shop, $name),
                'address' => fake()->address(),
                'about' => fake()->sentences(1, true),
                'business_id' => $business->id,
                'owner_id' => $owner->id,
                'location' => new Point(fake()->latitude(2, 13), fake()->longitude(9, 16), Srid::WGS84)
            ]);
        });
    }
}
