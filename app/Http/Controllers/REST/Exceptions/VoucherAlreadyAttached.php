<?php
namespace App\Http\Controllers\REST\Exceptions;

class VoucherAlreadyAttached extends BaseApiException
{
	protected $exceptionType = 'IncorrectAction';
	protected $exceptionMsg = 'Filled product already has current voucher';

}