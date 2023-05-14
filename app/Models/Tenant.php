<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    /**
     * The defailt(disabled) tenant status constant value.
     *
     * @var const
     */
    const USER_DISABLED = 'disabled';

    /**
     * Active tenant status constant value.
     *
     * @var const
     */
    const USER_ACTIVE = 'active';


    /**
     * Returns the class table name.
     *
     * @return string
     */
    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}