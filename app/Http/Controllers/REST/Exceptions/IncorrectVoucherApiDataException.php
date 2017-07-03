<?php
namespace App\Http\Controllers\REST\Exceptions;

class IncorrectVoucherApiDataException extends BaseApiException
{
	protected $exceptionType = 'IncorrectData';
	protected $exceptionMsg = 'Data section must has `voucher` root node';

}