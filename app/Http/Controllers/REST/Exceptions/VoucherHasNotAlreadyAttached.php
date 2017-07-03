<?php
namespace App\Http\Controllers\REST\Exceptions;

class VoucherHasNotAlreadyAttached extends BaseApiException
{
	protected $exceptionType = 'IncorrectAction';
	protected $exceptionMsg = 'Filled product has not attached to voucher';

}