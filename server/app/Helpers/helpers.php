<?php

// A simple helper function which formats a large or small number
function formatNumber(int $number): string
{
    if ($number < 10) {
        return number_format($number, 4);
    } else {
        return number_format($number, 2);
    }
}
