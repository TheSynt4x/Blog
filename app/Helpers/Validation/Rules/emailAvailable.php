<?php
namespace App\Helpers\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use App\Models\User;

/**
 * Email Available custom validation rule
 */
class emailAvailable extends AbstractRule
{
    /**
     * Checks if the username is available
     * @param  string $input User input
     * @return boolean       Email status
     */
    public function validate($input)
    {
        return User::where('email', $input)->count() === 0;
    }
}
