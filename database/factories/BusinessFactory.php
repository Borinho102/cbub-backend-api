<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\BusinessUser;
use App\Services\Utils\Initials;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        return [
            'name' => $name,
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->unique()->phoneNumber(),
            'initials' => Initials::generate($name),
            'slug' => generateSlug(new Business, $name),
            'address' => fake()->address(),
            'about' => fake()->sentences(1, true),
            'category_id' => BusinessCategory::inRandomOrder()->first()->id
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure()
    {
        return $this->afterCreating(function (Business $business) {
            $email = fake()->unique()->safeEmail();
            $owner = BusinessUser::create([
                'name' => fake()->name(),
                'email' => $email,
                'username' => generateUsername(new BusinessUser, explode('@', $email)[0]),
                'phone' => fake()->unique()->phoneNumber(),
                'business_id' => $business->id,
                'password' => bcrypt('password')
            ]);

            $owner->syncRoles(['business_admin', 'business_owner']);

            $business
                ->addMedia(public_path('images/business_placeholder.png'))
                ->preservingOriginal()
                ->toMediaCollection('logo');
        });
    }
}
