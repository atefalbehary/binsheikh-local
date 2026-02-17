<?php
namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;

    /**

     * The attributes that are mass assignable.

     *

     * @var array<int, string>

     */

    // protected $fillable = [

    //     'name',

    //     'email',

    //     'password',

    // ];

    /**

     * The attributes that should be hidden for serialization.

     *

     * @var array<int, string>

     */

    protected $hidden = [

        'password',

        'remember_token',

        'email_verified_at',

        'previllege',

        'password_reset_otp',

        'password_reset_time',

        'password_reset_code',

    ];

    protected $guarded = [];

    /**

     * The attributes that should be cast.

     *

     * @var array<string, string>

     */

    protected $casts = [

        'email_verified_at' => 'datetime',

    ];

    protected $appends = ['profile_url'];

    public function getProfileUrlAttribute()
    {

        $url = url('profile/' . $this->id);

        return $url;

    }

    public static function update_password($id, $password)
    {

        return DB::table("users")->where("id", '=', $id)->update(['password' => bcrypt($password)]);

    }

    public function getUserImageAttribute($value)
    {

        // if($this->role == 3 || $this->role == 4){

        //     return public_url().$value;

        // }

        return get_uploaded_image_url($value, 'user_image_upload_dir');

    }

    public function getBannerImageAttribute($value)
    {

        return get_uploaded_image_url($value, 'user_image_upload_dir');

    }

    public function branch_details()
    {

        return $this->hasOne('App\Models\BranchDetails', 'user_id', 'id');

    }

    public function address()
    {

        return $this->hasMany('App\Models\UserAddress', 'user_id', 'id');

    }

    public function cart()
    {

        return $this->hasMany('App\Models\Cart', 'user_id', 'id');

    }

    public function del_by_branch()
    {

        return $this->hasOne('App\Models\User', 'id', 'del_boy_branch');

    }

    public function country()
    {
        return $this->hasOne(Country::class, 'code_iso', 'country_id');
    }

    /**
     * Get the agency that this user belongs to.
     */
    public function agency()
    {
        return $this->belongsTo(User::class, 'agency_id');
    }

    /**
     * Get all users that belong to this agency.
     */
    public function agencyUsers()
    {
        return $this->hasMany(User::class, 'agency_id');
    }

    /**
     * Get all reservations for this agent.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'agent_id');
    }

    /**
     * Get the role that belongs to the user.
     */
    public function role_details()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Check if user has a specific permission.
     * 
     * @param string $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        if (!$this->role_details) {
            return false;
        }

        // Check if the user is Super Admin (bypass checks)
        if ($this->role_details->name === 'Super Admin') {
            return true;
        }

        // Cache the permissions for this role to avoid N+1 queries
        $permissions = \Cache::remember('role_permissions_' . $this->role_id, 3600, function () {
            return $this->role_details->permissions->pluck('name')->toArray();
        });

        return in_array($permission, $permissions);
    }

    /**
     * Check if user has a specific role.
     * 
     * @param string $roleName
     * @return bool
     */
    public function hasRole($roleName)
    {
        return $this->role_details && $this->role_details->name === $roleName;
    }
}
