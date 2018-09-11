<?php
namespace App\Helpers\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use App\Models\User;

/**
 * Username Available custom validation rule
 */
class usernameAvailable extends AbstractRule
{
    /**
     * Checks if the username is available
     * @param  string $input User input
     * @return boolean       Username status
     */
    public function validate($input)
    {
        return User::where('username', $input)->count() === 0;
    }
}
