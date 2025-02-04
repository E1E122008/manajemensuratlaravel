<?php

namespace App\Enums;

enum ConfigEnum: string
{
    case DEFAULT_PASSWORD = 'default_password';
    case PAGE_SIZE = 'page_size';
    case INSTITUTION_NAME = 'institution_name';
    case INSTITUTION_ADDRESS = 'institution_address';
    case INSTITUTION_PHONE = 'institution_phone';
    case INSTITUTION_EMAIL = 'institution_email';
} 