<?php

namespace App\Enums;

use Spatie\Permission\Exceptions\PermissionDoesNotExist;

enum PermissionsEnum: string
{

    case CREATE_USERS = 'create_users';
    case EDIT_USERS = 'edit_users';
    case VIEW_USERS = 'view_users';
    case DELETE_USERS = 'delete_users';
    case CREATE_THEMES = 'create_themes';
    case EDIT_THEMES = 'edit_themes';
    case DELETE_THEMES = 'delete_themes';
    case CREATE_CAMPAIGNS = 'create_campaigns';
    case EDIT_CAMPAIGNS = 'edit_campaigns';
    case DELETE_CAMPAIGNS = 'delete_campaigns';
    case CREATE_STEPS = 'create_steps';
    case EDIT_STEPS = 'edit_steps';
    case DELETE_STEPS = 'delete_steps';
    case CREATE_ACTIVITIES = 'create_activities';
    case EDIT_ACTIVITIES = 'edit_activities';
    case DELETE_ACTIVITIES = 'delete_activities';
    case ASSIGN_COORDINATORS = 'assign_coordinators';
    case ASSIGN_WORKERS = 'assign_workers';
    case APPROVE_WORKERS = 'approve_workers';
    case VIEW_ASSIGNED_WORKERS = 'view_assigned_workers';
    case ASSIGN_LEADERS = 'assign_leaders';
    case CREATE_AREAS_OF_INTEREST = 'create_areas_of_interest';
    case EDIT_AREAS_OF_INTEREST = 'edit_areas_of_interest';
    case DELETE_AREAS_OF_INTEREST = 'delete_areas_of_interest';
    case VIEW_INFORMATION_SOURCES = 'view_information_sources';
    case CREATE_INFORMATION_SOURCES = 'create_information_sources';
    case EDIT_INFORMATION_SOURCES = 'edit_information_sources';
    case DELETE_INFORMATION_SOURCES = 'delete_information_sources';
    case VIEW_DEMOGRAPHICS = 'view_demographics';
    case CREATE_DEMOGRAPHICS = 'create_demographics';
    case EDIT_DEMOGRAPHICS = 'edit_demographics';
    case DELETE_DEMOGRAPHICS = 'delete_demographics';
    case VIEW_ACTIVITIES = 'view_activities';
    case VIEW_STEPS = 'view_steps';
    case VIEW_CAMPAIGNS = 'view_campaigns';
    case VIEW_THEMES = 'view_themes';
    case VIEW_AREAS_OF_INTEREST = 'view_areas_of_interest';

    public static function getDemographicPerms(): array
    {
        return [
            PermissionsEnum::CREATE_DEMOGRAPHICS->value,
            PermissionsEnum::VIEW_DEMOGRAPHICS->value,
            PermissionsEnum::EDIT_DEMOGRAPHICS->value,
            PermissionsEnum::DELETE_DEMOGRAPHICS->value,
        ];
    }

    public static function getInformationSourcesPerms(): array
    {
        return [
            PermissionsEnum::CREATE_INFORMATION_SOURCES->value,
            PermissionsEnum::VIEW_INFORMATION_SOURCES->value,
            PermissionsEnum::EDIT_INFORMATION_SOURCES->value,
            PermissionsEnum::DELETE_INFORMATION_SOURCES->value,
        ];
    }

    public static function getActivitiesPerms(): array
    {
        return [
            PermissionsEnum::VIEW_ACTIVITIES->value,
            PermissionsEnum::CREATE_ACTIVITIES->value,
            PermissionsEnum::DELETE_ACTIVITIES->value,
            PermissionsEnum::EDIT_ACTIVITIES->value
        ];
    }

    public static function getStepsPerms(): array
    {
        return [
            PermissionsEnum::VIEW_STEPS->value,
            PermissionsEnum::CREATE_STEPS->value,
            PermissionsEnum::EDIT_STEPS->value,
            PermissionsEnum::DELETE_STEPS->value,
        ];
    }

    public static function getCampaignsPerms(): array
    {
        return [
            PermissionsEnum::VIEW_CAMPAIGNS->value,
            PermissionsEnum::CREATE_CAMPAIGNS->value,
            PermissionsEnum::EDIT_CAMPAIGNS->value,
            PermissionsEnum::DELETE_CAMPAIGNS->value,
        ];
    }

    public static function getThemesPerms(): array
    {
        return [
            PermissionsEnum::VIEW_THEMES->value,
            PermissionsEnum::CREATE_THEMES->value,
            PermissionsEnum::EDIT_THEMES->value,
            PermissionsEnum::DELETE_THEMES->value
        ];
    }

    public static function getUsersPerms(): array
    {
        return [
            PermissionsEnum::CREATE_USERS->value,
            PermissionsEnum::EDIT_USERS->value,
            PermissionsEnum::DELETE_USERS->value
        ];
    }

    public static function getAreasOfInterestPerms(): array
    {
        return [
            PermissionsEnum::VIEW_AREAS_OF_INTEREST->value,
            PermissionsEnum::CREATE_AREAS_OF_INTEREST->value,
            PermissionsEnum::EDIT_AREAS_OF_INTEREST->value,
            PermissionsEnum::DELETE_AREAS_OF_INTEREST->value
        ];
    }
}
