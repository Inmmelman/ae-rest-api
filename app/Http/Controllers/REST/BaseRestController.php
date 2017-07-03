<?php
namespace App\Http\Controllers\REST;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BaseRestController extends Controller
{

	/**
	 * Using paginate props and return json
	 * @param Builder $builder
	 * @param Request $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function responseWithPaginate(Builder $builder, Request $request)
	{
		//set default items per page
		$perPage = 10;
		if ($request->has('per_page')) {
			$perPage = $request->get('per_page');
		}

		$list = $builder->simplePaginate($perPage);
		if ($request->has('per_page')) {
			$list->appends('per_page', $perPage);
		}

		return response(
			[
				'data' => $list,
			]
		);
	}
}