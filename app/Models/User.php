<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * User model
 */
class User extends Model
{
    /**
     * Fillable columns in the table
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'email',
        'admin',
        'ban'
    ];

    /**
     * Checks if the user is an admin
     * @return boolean admin status
     */
    public function isAdmin()
    {
        return (bool) $this->admin;
    }

    /**
     * Checks if the user is banned
     * @return boolean ban status
     */
    public function isBanned()
    {
        return (bool) $this->ban;
    }
}
