<?php
namespace App\Http\Controllers\REST\Response;

use App\Http\Controllers\REST\Exceptions\BaseApiException;

class ApiErrorResponse
{
	/**
	 * Handling error's array and prepared grouped reponse
	 * @param BaseApiException $exception
	 * @return \Illuminate\Http\JsonResponse
	 */
	public static function prepareErrorResponse(BaseApiException $exception)
	{
		$errors = [];
		$exceptionMsg = json_decode($exception->getMessage(), true);
		if (is_array($exceptionMsg)) {
			foreach ($exceptionMsg as $msg) {
				$errors[] = ['message' => reset($msg)];
			}
		} else {
			$errors = $exceptionMsg;
		}

		return self::respondGroupedError($errors, $exception->getExceptionType(), $exception->getExceptionMsg());
	}

	/**
	 * Prepared grouped response
	 * @param $errors
	 * @param $type
	 * @param string $groupedMsg
	 * @return \Illuminate\Http\JsonResponse
	 */
	public static function respondGroupedError($errors, $type, $groupedMsg = '')
	{
		return self::respond(
			[
				'error' => [
					'type' => $type,
					'message' => $groupedMsg,
					'errors' => $errors
				]
			]
		);
	}

	/**
	 * @param $message
	 * @param $statusCode
	 * @return \Illuminate\Http\JsonResponse
	 */
	public static function respondError($message, $statusCode = 400)
	{
		return self::respond(
			[
				'error' => [
					'message' => $message,
				]
			],
			$statusCode
		);
	}

	/**
	 * Return response
	 * @param $data
	 * @param int $statusCode
	 * @param array $headers
	 * @return \Illuminate\Http\JsonResponse
	 */
	public static function respond($data, $statusCode = 200, $headers = [])
	{
		return response()->json($data, $statusCode, $headers);
	}
}