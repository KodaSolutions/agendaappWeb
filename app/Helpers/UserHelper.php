<?php
namespace App\Helpers;

class UserHelper 
{
    public static function generateUserIdentification(){
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $identificacion = '';
        for ($i = 0; $i < 3; $i++) {
            $identificacion .= $characters[rand(0, strlen($characters) - 1)];
        }
        $timestamp = now()->format('mdHis');
        $fullIdentification = $identificacion . $timestamp;
        while (\App\Models\User::where('identification', $fullIdentification)->exists()) {
            $identificacion = '';
            for ($i = 0; $i < 3; $i++) {
                $identificacion .= $characters[rand(0, strlen($characters) - 1)];
            }
            $fullIdentification = $identificacion . $timestamp;
        }
        
        return $fullIdentification;
    }
}