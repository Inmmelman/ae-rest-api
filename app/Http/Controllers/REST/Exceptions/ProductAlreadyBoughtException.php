<?php
namespace App\Http\Controllers\REST\Exceptions;

class ProductAlreadyBoughtException extends BaseApiException
{
	protected $exceptionType = 'IncorrectInput';
	protected $exceptionMsg = 'Cant buy product. This product has been bought.';
}