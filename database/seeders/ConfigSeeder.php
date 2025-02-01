<?php

namespace Database\Seeders;

use App\Models\Config;
use App\Enums\Config as ConfigEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $configs = [
            [
                'code' => ConfigEnum::DEFAULT_PASSWORD->value,
                'value' => 'admin'
            ],
            [
                'code' => ConfigEnum::PAGE_SIZE->value,
                'value' => '5'
            ],
            [
                'code' => ConfigEnum::APP_NAME->value,
                'value' => 'Aplikasi Surat Menyurat'
            ],
            [
                'code' => ConfigEnum::INSTITUTION_NAME->value,
                'value' => '404nfid'
            ],
            [
                'code' => ConfigEnum::INSTITUTION_ADDRESS->value,
                'value' => 'Jl. Padat Karya'
            ],
            [
                'code' => ConfigEnum::INSTITUTION_PHONE->value,
                'value' => '082121212121'
            ],
            [
                'code' => ConfigEnum::INSTITUTION_EMAIL->value,
                'value' => 'admin@admin.com'
            ],
            [
                'code' => ConfigEnum::LANGUAGE->value,
                'value' => 'id'
            ],
            [
                'code' => ConfigEnum::PIC->value,
                'value' => 'M. Iqbal Effendi'
            ]
        ];

        foreach ($configs as $config) {
            Config::updateOrCreate(
                ['code' => $config['code']],
                ['value' => $config['value']]
            );
        }
    }
}
