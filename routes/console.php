<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

if (app()->environment(['local', 'testing'])) {
    Artisan::command('user:ensure {email} {password}', function (string $email, string $password) {
        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => str($email)->before('@')->title()->value() ?: 'User',
                'password' => $password,
            ]
        );
        $user->forceFill(['email_verified_at' => now()])->save();

        $this->info("User #{$user->id} ({$user->email}) is ready; e-mail marked verified.");
    })->purpose('Create or update a user and verify e-mail (local/testing only)');
}
