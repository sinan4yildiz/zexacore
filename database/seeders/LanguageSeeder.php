<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    static $table = 'languages';

    public function run()
    {
        DB::table(static::$table)->truncate();

        $data = [
            [
                'name'   => 'English',
                'native' => 'English',
                'code'   => 'en-gb',
                'locale' => 'en_GB.UTF-8, en_GB@GBP, en_GB, english',
            ],
            [
                'name'   => 'Turkish',
                'native' => 'Türkçe',
                'code'   => 'tr-tr',
                'locale' => 'tr_TR.UTF-8, tr_TR@TRY, tr_TR, turkish',
            ],
            [
                'name'   => 'German',
                'native' => 'Deutsch',
                'code'   => 'de-de',
                'locale' => 'de_DE.UTF-8, de_DE@EUR, de_DE, german',
            ],
            [
                'name'      => 'French',
                'native'    => 'Français',
                'code'      => 'fr-fr',
                'locale'    => 'fr_FR.UTF-8, fr_FR@EUR, fr_FR, french',
                'is_active' => false
            ],
            [
                'name'      => 'Ukrainian',
                'native'    => 'Українська',
                'code'      => 'ua-ua',
                'locale'    => 'ua_UA.UTF-8, ua_UA@UAH, ua_UA, ukrainian',
                'is_active' => false
            ],
            [
                'name'      => 'Russian',
                'native'    => 'Русский',
                'code'      => 'ru-ru',
                'locale'    => 'ru_RU.UTF-8, ru_RU@RUB, ru_RU, russian',
                'is_active' => false
            ],
        ];

        foreach ($data as $item) {
            DB::table(static::$table)->insert($item);
        }


    }
}
