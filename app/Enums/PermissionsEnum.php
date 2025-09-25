<?php

namespace App\Enums;

enum PermissionsEnum: string
{
    case ADMIN_THEMES = 'admin themes';
    case ADMIN_CAMPAIGNS = 'admin campaigns';
    case ADMIN_USERS = 'admin users';
    case ADMIN_STEPS = 'admin steps';
    case ADMIN_WORKERS = 'admin workers';
}
