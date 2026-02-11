<?php

use Carbon\Carbon;

if (! function_exists('formatCurrency')) {
    function formatCurrency(float $amount): string
    {
        return number_format($amount, 2, ',', ' ').' €';
    }
}

if (! function_exists('humanDate')) {
    function humanDate($date): string
    {
        $date = Carbon::parse($date);

        if ($date->isToday()) {
            return 'Dnes';
        }

        if ($date->isYesterday()) {
            return 'Včera';
        }

        if ($date->gt(now()->subDays(7))) {
            return $date->diffForHumans();
        }

        return $date->format('d. m. Y');
    }
}
