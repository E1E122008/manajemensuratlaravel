<?php

namespace App\Enums;

class Config
{
    public const DEFAULT_PASSWORD = 'default_password';
    public const PAGE_SIZE = 'page_size';
    public const APP_NAME = 'app_name';
    public const INSTITUTION_NAME = 'institution_name';
    public const INSTITUTION_ADDRESS = 'institution_address';
    public const INSTITUTION_PHONE = 'institution_phone';
    public const INSTITUTION_EMAIL = 'institution_email';
    public const LANGUAGE = 'language';
    public const PIC = 'pic';

    public static function getValues(): array
    {
        return [
            self::DEFAULT_PASSWORD,
            self::PAGE_SIZE,
            self::APP_NAME,
            self::INSTITUTION_NAME,
            self::INSTITUTION_ADDRESS,
            self::INSTITUTION_PHONE,
            self::INSTITUTION_EMAIL,
            self::LANGUAGE,
            self::PIC
        ];
    }
}
