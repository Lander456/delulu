<?php

namespace App\Enums;

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
}
