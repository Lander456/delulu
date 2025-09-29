<?php

namespace App\Enums;

enum RolesEnum: string
{
    case SYSADMIN = 'sysadmin';
    case ADMIN = 'admin';
    case CAMPAIGN_LEADER = 'campaign_leader';
    case COORDINATOR = 'coordinator';
    case WORKER = 'worker';

    public static function getAdminRoles(): array
    {
        $roles = RolesEnum::getCampaignLeaderRoles();
        $roles[] = RolesEnum::ADMIN->value;

        return $roles;
    }

    public static function getCampaignLeaderRoles(): array
    {
        $roles = RolesEnum::getCoordinatorRoles();
        $roles[] = RolesEnum::CAMPAIGN_LEADER->value;

        return $roles;
    }

    public static function getCoordinatorRoles(): array
    {
        $roles = RolesEnum::getWorkerRoles();
        $roles[] = RolesEnum::COORDINATOR->value;

        return $roles;
    }

    public static function getWorkerRoles(): array
    {
        return [RolesEnum::WORKER->value];
    }
}
