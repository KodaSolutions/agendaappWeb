<?php
namespace App\Traits;

trait GeneratesUserIdentification 
{
    public static function bootGeneratesUserIdentification(){
        static::creating(function ($model) {
            if (!$model->identification) {
                $model->identification = self::generateUniqueIdentification();
            }
        });
    }
    public static function generateUniqueIdentification(){
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        do {
            $identification = '';
            for ($i = 0; $i < 3; $i++) {
                $identification .= $characters[rand(0, strlen($characters) - 1)];
            }
        } while (self::where('identification', $identification)->exists());

        return $identification;
    }
}