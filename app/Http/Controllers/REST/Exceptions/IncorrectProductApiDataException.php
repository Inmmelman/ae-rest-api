<?php
namespace App\Http\Controllers\REST\Exceptions;

class IncorrectProductApiDataException extends BaseApiException
{
	protected $exceptionType = 'IncorrectData';
	protected $exceptionMsg = 'Data section must has `product` root node';

}