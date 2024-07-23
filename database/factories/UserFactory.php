<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Country;
use App\Models\DeliveryAddress;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $email = fake()->unique()->safeEmail();
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'username' => explode('@', $email)[0],
            'email' => $email,
            'phone' => fake()->unique()->phoneNumber(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

     /**
     * Configure the model factory.
     */
    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            $country = Country::find(1);
            for ($i = 0; $i < 3; $i++) {
                DeliveryAddress::create([
                    'user_id' => $user->id,
                    'full_name' => fake()->name(),
                    'address' => fake()->address(),
                    'phone' => fake()->phoneNumber(),
                    'lat' => fake()->latitude(),
                    'lng' => fake()->longitude(),
                    'country_id' => $country->id,
                    'city_id' => City::where('country_id', $country->id)
                        ->inRandomOrder()->first()->id
                ]);
            }
        });
    }
}
