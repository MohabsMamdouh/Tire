<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\User;
use Spatie\Permission\Contracts\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (User $user) {
            return $user->assignRole('user');
        });
    }

    /**
     * Syncs role/s of user with passed role/s.
     *
     * @param array|Role|string ...$roles
     * @return UserFactory
     */
    private function assignRole(...$roles): UserFactory
    {
        return $this->afterCreating(function (User $user) use ($roles) {
            return $user->syncRoles($roles);
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'fname' => fake()->name(),
            'username' => fake()->username(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'phone' => fake()->phoneNumber(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user is an super_admin.
     *
     * @return UserFactory
     */
    public function super_admin(): UserFactory
    {
        return $this->assignRole('super_admin');
    }


    /**
     * Indicate that the user is an admin.
     *
     * @return UserFactory
     */
    public function admin(): UserFactory
    {
        return $this->assignRole('admin');
    }


    /**
     * Indicate that the user is an mechanic.
     *
     * @return UserFactory
     */
    public function mechanic(): UserFactory
    {
        return $this->assignRole('mechanic');
    }
}
