<?php
namespace App\Http\Controllers\REST\Exceptions;

class ValidationException extends BaseApiException
{
	protected $exceptionType = 'ValidationException';
	protected $exceptionMsg = 'Something bad happened with value :(';
}