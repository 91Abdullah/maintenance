<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Faker\Provider\fr_FR\Address;

class FakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $agentCount = User::all()->count() >= 100 ? -1 : 100;
        $outletCount = \App\Outlet::all()->count() >= 100 ? -1 : 100;
        $customerCount = \App\Customer::all()->count() >= 100 ? -1 : 100;
        $statusCount = \App\TicketStatus::all()->count() >= 5 ? -1 : 5;
        $issueCount = \App\Issue::all()->count() >= 5 ? -1 : 5;
        $mainUsersCount = \App\MaintenanceUser::all()->count() >= 30 ? -1 : 30;
        $departCount = \App\Department::all()->count() >= 10 ? -1 : 10;
        $roles = Role::whereNotIn('name', ['admin', 'superadmin'])->get();

        $faker = \Faker\Factory::create();
        $role = Role::where('name', 'agent')->first();

        for ($i = 0; $i <= $agentCount; $i++) {
            $name = $faker->name;
            $user = User::create([
                'name' => $name,
                'email' => $faker->email,
                'username' => lcfirst($name),
                'password' => \Illuminate\Support\Facades\Hash::make(lcfirst($name))
            ]);
            $user->roles()->attach($role);
        }

        for ($i = 0; $i <= $outletCount; $i++) {
            \App\Outlet::create([
                'name' => $faker->streetName,
                'city' => \Illuminate\Support\Arr::random(['Karachi', 'Lahore', 'Islamabad', 'Rawalpindi', 'Quetta', 'Peshawar'])
            ]);
        }

        for ($i = 1; $i <= $departCount; $i++) {
            \App\Department::create([
                'name' => Address::departmentName(),
                'city' => \Illuminate\Support\Arr::random(['Karachi', 'Lahore', 'Islamabad', 'Rawalpindi', 'Quetta', 'Peshawar'])
            ]);
        }

        for ($i = 0; $i <= $customerCount; $i++) {
            \App\Customer::create([
                'name' => $faker->name,
                'number' => $faker->phoneNumber
            ]);
        }

        for ($i = 0; $i <= $statusCount; $i++) {
            \App\TicketStatus::create([
                'name' => \Illuminate\Support\Arr::random(['Open', 'Closed', 'Pending', 'Re-opened', 'Following', 'Forwarded'])
            ]);
        }

        for ($i = 0; $i <= $issueCount; $i++) {
            \App\Issue::create([
                'name' => \Illuminate\Support\Arr::random(['Link Down', 'Other', 'Internet Down', 'Oven Not Working', 'Electricity Issue', 'Website Down'])
            ]);
        }

        for ($i = 1; $i <= $mainUsersCount; $i++) {
            $depart = \App\Department::findOrFail(\Illuminate\Support\Arr::random(\App\Department::pluck('id')->toArray()));
            $depart->maintenance_users()->create([
                'name' => $faker->name,
                'number' => $faker->phoneNumber,
                'city' => \Illuminate\Support\Arr::random(['Karachi', 'Lahore', 'Islamabad', 'Rawalpindi', 'Quetta', 'Peshawar'])
            ]);
        }
    }
}
