<?php

namespace App\Enums;

enum RolesEnum: string
{
    case SYSADMIN = 'sysadmin';
    case ADMIN = 'admin';
    case CAMPAIGN_LEADER = 'campaign_leader';
    case COORDINATOR = 'coordinator';
    case WORKER = 'worker';
}
