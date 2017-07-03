<?php
namespace App\Http\Controllers\REST\Exceptions;

class CantFindProductException extends BaseApiException
{
	protected $exceptionType = 'IncorrectInput';
	protected $exceptionMsg = 'Can\'t find product with filled id';

}