<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

class StringHelper
{
    public static function randomString(int $length = 10, bool $russain = false): string
    {
        if ($russain) {
            return 'абвгдежзиклмнопрстуфхцчшщъыьэюяАБВГДЕЖЗИКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ';
        }

        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = mb_strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; ++$i) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public static function getStringMoreThan200Symbols(): string
    {
        return 'very large description more then two hundreds words check
        very large description more then two hundreds words check
        very large description more then two hundreds words check
        very large description more then two hundreds words check';
    }
}
