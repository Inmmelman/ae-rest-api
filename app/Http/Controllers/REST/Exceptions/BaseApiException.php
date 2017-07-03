<?php
namespace App\Http\Controllers\REST\Exceptions;

class BaseApiException extends \Exception
{
	protected $exceptionType = 'GeneralException';
	protected $exceptionMsg = 'Error';

	/**
	 * @return string
	 */
	public function getExceptionType()
	{
		return $this->exceptionType;
	}

	/**
	 * @return string
	 */
	public function getExceptionMsg()
	{
		return $this->exceptionMsg;
	}
}