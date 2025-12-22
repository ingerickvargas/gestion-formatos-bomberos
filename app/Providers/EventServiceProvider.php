<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        protected $listen = [
		\Illuminate\Auth\Events\Login::class => [
			\App\Listeners\LogSuccessfulLogin::class,
		],
		\Illuminate\Auth\Events\Failed::class => [
			\App\Listeners\LogFailedLogin::class,
		],
		\Illuminate\Auth\Events\Logout::class => [
			\App\Listeners\LogLogout::class,
		],
		\Illuminate\Auth\Events\Lockout::class => [
			\App\Listeners\LogLockout::class,
		],];
	}

    public function boot(): void
    {
        //
    }
}

