<?php
namespace App\Helpers\Validation;

use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Exceptions\NestedValidationException;

/**
 * Validation helper
 */
class Validator
{
    /**
     * Validation rules
     * @var array
     */
    protected $errors = [];

    /**
     * Validates request parameters
     * @param  Request $rquest Page request for fields
     * @param  array  $rules  Validation rules
     * @return object
     */
    public function validate(Request $request, array $rules)
    {
        foreach($rules as $field => $rule)
        {
            try {
                $rule->setName(ucfirst($field))->assert($request->getParam($field));
            } catch(NestedValidationException $e) {
                $this->errors[$field] = $e->getMessages();
            }
        }

        $_SESSION['errors'] = $this->errors;

        return $this;
    }

    /**
     * Checks if the validation passed
     * @return boolean
     */
    public function failed()
    {
        return !empty($this->errors);
    }
}
