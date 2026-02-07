<?php

if (! function_exists('formatCurrency')) {
    function formatCurrency(float $amount): string
    {
        return $amount . ' €';
    }
}
