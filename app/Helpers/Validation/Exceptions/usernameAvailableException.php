<?php
namespace App\Helpers\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

/**
 * Exception for usernameAvailable
 */
class usernameAvailableException extends ValidationException
{
	/**
	 * Message for custom rule
	 * @var array
	 */
	public static $defaultTemplates = [
		self::MODE_DEFAULT => [
			self::STANDARD => 'Sorry, but that username is already taken.',
		],
	];
}
