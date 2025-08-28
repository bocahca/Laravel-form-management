<?php

    namespace Database\Seeders;

    use App\Models\User;
    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\Hash;

    class UserSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run(): void
        {
            $email = env('ADMIN_EMAIL');
            $password = env('ADMIN_PASSWORD');
            if ($email && $password) {
                User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => 'Admin',
                        'password' => bcrypt($password),
                    ]
                );
            } else {
                $this->command->error('Please set ADMIN_EMAIL and ADMIN_PASSWORD in your .env file.');
                return;
            }
        }
    }
