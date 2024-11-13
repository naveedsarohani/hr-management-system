<?php

namespace App\Providers;

use DateTime;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('flexible_time', function ($attribute, $value, $parameters) {
            $value = trim(strtoupper($value));
            $formats = ['h:i A', 'h:ia', 'ha'];

            if (strpos($value, ':') === false) {
                return false;
            }

            foreach ($formats as $format) {
                if (DateTime::createFromFormat($format, $value) !== false) {
                    return true;
                }
            }
            return false;
        }, 'The :attribute must be in format HH:MM AM/PM (e.g., 01:30 PM or 1:30A)');
    }
}
