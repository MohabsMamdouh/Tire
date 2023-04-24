<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Customer;
use Spatie\Permission\Contracts\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (Customer $customer) {
            return $customer->assignRole('customer');
        });
    }

    /**
     * Syncs role/s of user with passed role/s.
     *
     * @param array|Role|string ...$roles
     * @return CustomerFactory
     */
    private function assignRole(...$roles): CustomerFactory
    {
        return $this->afterCreating(function (Customer $customer) use ($roles) {
            return $customer->syncRoles($roles);
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
            'customer_fname' => fake()->name(),
            'customer_username' => fake()->username(),
            'email' => fake()->unique()->safeEmail(),
            'customer_address' => fake()->streetAddress(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
            'customer_phone' => fake()->phoneNumber(),
        ];
    }


     /**
     * Indicate that the user is an customer.
     *
     * @return CustomerFactory
     */
    public function customer(): CustomerFactory
    {
        return $this->assignRole('customer');
    }
}
