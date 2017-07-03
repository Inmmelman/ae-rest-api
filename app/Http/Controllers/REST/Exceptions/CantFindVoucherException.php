<?php
namespace App\Http\Controllers\REST\Exceptions;

class CantFindVoucherException extends BaseApiException
{
	protected $exceptionType = 'IncorrectInput';
	protected $exceptionMsg = 'Can\'t find voucher with filled id';

}