<?php
namespace App\Helpers\Authentication;

use App\Models\User;

/**
 * Authentication helper
 */
class Auth
{
    /**
     * Retrieves the user data based on the user id
     * @return object User data
     */
    public function user()
    {
        if (isset($_COOKIE['user'])) return User::find($_COOKIE['user']);
    }

    /**
     * Checks if the user is signed in
     * @return boolean
     */
    public function check()
    {
        if (isset($_COOKIE['user'])) return isset($_COOKIE['user']);
    }

    /**
     * Handles user authentication
     * @param  string $username User's username
     * @param  string $password User's password
     * @param  string $remember Remember me functionality
     * @return boolean Status
     */
    public function attempt($username, $password, $remember = null)
    {
        $user = User::where('username', $username)->where('password', $password);

        if($user->count()) {
            $expiration = time() + ((isset($remember)) ? 604800 : 86400);
            setcookie('user', $user->first()->id, $expiration, '/', null, null, true);

            return true;
        }

        return false;
    }

    /**
     * Handles the user logout
     * @return boolean
     */
    public function logout()
    {
        setcookie('user', '', time()-31536000, '/', null, null, true);
        return true;
    }
}
