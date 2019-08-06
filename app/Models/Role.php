<?php
/**
 * Created by ARIS.
 * Date: Wed, 07 Nov 2018 07:11:03 +0000.
 */
namespace App\Models;
use Reliese\Database\Eloquent\Model as Eloquent;
use \Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Laravel\Scout\Searchable;
use Config;
use Zizaco\Entrust\EntrustRole;
use \LiamWiltshire\LaravelJitLoader\Concerns\AutoloadsRelationships;
/**
 * Class Role
 *
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $permissions
 * @property \Illuminate\Database\Eloquent\Collection $role_users
 *
 * @package App\Models
 */
class Role extends EntrustRole
{
    use AutoloadsRelationships;
    /**
     * @return Illuminate\Database\Eloquent\Model
     */
    // use Searchable;
    // public $asYouType = true;
    public function toSearchableArray()
    {
        $array = $this->toArray();
        return $array;
    }
    protected $table = 'roles';
    protected $fillable = ['name', 'display_name', 'description', 'multiple_management'];
    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission', Config::get('entrust::permission_role_table'));
    }
    public function users()
    {
        return $this->belongsToMany(Config::get('auth.providers.users.model'), Config::get('entrust.role_user_table'), Config::get('entrust.role_foreign_key'), Config::get('entrust.user_foreign_key'));
    }
}