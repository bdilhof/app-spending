<?php

if (! function_exists('formatCurrency')) {
    function formatCurrency(int $amount): string
    {
        return $amount . ' €';
    }
}
