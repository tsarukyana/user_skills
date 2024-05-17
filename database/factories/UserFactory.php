<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;
use App\Decorators\PhpSkillDecorator;
use App\Decorators\JsSkillDecorator;
use App\Decorators\GolangSkillDecorator;
use App\Decorators\JavaSkillDecorator;

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
        $user = new User([
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $decorators = [
            PhpSkillDecorator::class,
            JsSkillDecorator::class,
            GolangSkillDecorator::class,
            JavaSkillDecorator::class,
        ];

        shuffle($decorators);
        $numberOfDecorators = rand(1, count($decorators));

        for ($i = 0; $i < $numberOfDecorators; $i++) {
            $decorator = new $decorators[$i]($user);
            $user->description .= $decorator->getDescription();
        }

        // Split the string into an array of words
        // Use array_unique to remove duplicates while preserving the order
        // Join the words back into a single string
        $user->description = implode(' ', array_unique(explode(' ', trim($user->description))));

        $definition = $user->toArray();
        $definition['password'] = $user->password; // important
        return $definition;
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
}
