<?php

namespace App;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    public const ROLE_ADMIN = 'admin';
    public const ROLE_PRACTICING = 'practicing';
    public const ROLE_RESPONSABLE = 'responsable';
    public const ROLE_CANDIDATE = 'candidate';
}
