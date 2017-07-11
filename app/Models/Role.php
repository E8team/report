<?php

namespace App\Models;

use Cache;
use Config;
use DB;
use Illuminate\Cache\TaggableStore;
use Zizaco\Entrust\Contracts\EntrustRoleInterface;
use Zizaco\Entrust\Traits\EntrustRoleTrait;

class Role extends BaseModel implements EntrustRoleInterface
{
    use EntrustRoleTrait;
    protected $hasDefaultValuesFields = ['order'];
    protected $fillable = ['name', 'display_name', 'description', 'order'];
    protected static $allowSortFields = ['id', 'name', 'display_name', 'order'];
    protected static $allowSearchFields = ['id', 'name', 'display_name', 'description'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = Config::get('entrust.roles_table');
    }

    public static function permissionRoleArrayWithCache()
    {
        if (Cache::getStore() instanceof TaggableStore) {
            return Cache::tag(Config::get('entrust.permission_role_table'))->rememberForever(
                'all_permission_role', function () {
                    return DB::table('permission_role')->get();
                }
            );
        } else {
            return DB::table('permission_role')->get();
        }
    }

    public function cachedPermissions()
    {
        $rolePrimaryKey = $this->primaryKey;
        $cacheKey = 'entrust_permissions_for_role_' . $this->$rolePrimaryKey;
        if (Cache::getStore() instanceof TaggableStore) {
            return Cache::tags(Config::get('entrust.permission_role_table'))->rememberForever(
                $cacheKey, function () {
                    return $this->perms()->ordered()->recent()->get();
                }
            );
        } else {
            return $this->perms()->ordered()->recent()->get();
        }
    }
}
