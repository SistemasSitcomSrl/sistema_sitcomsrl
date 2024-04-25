<?php
if (!function_exists('getUserCount')) {
    function getUserCount()
    {
        return \App\Models\User::count();
    }
}