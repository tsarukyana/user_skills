<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Decorators\{PHPDecorator, JSDecorator, GoDecorator, JavaDecorator, UserWithSkill};

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
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ]);

        $skills = [PHPDecorator::class, JSDecorator::class, GoDecorator::class, JavaDecorator::class];

        $description = '';

        // Ensure that $randKeys is always an array
        $randKeys = array_rand($skills, rand(1, 4));
        if (!is_array($randKeys)) {
            $randKeys = [$randKeys];
        }

        foreach ($randKeys as $index) {
            $skillClass = $skills[$index];
            // The decorator pattern is using here
            $decoratedUser = new $skillClass(new UserWithSkill($user));
            $description .= $decoratedUser->getDescription();
        }

        $user->description = rtrim($description, ', ');

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
