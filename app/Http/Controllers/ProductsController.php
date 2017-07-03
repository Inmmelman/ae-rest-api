<?php

namespace App\Http\Controllers;

use App\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
	/**
	 * Show the profile for the given user.
	 * @return Response
	 */
	public function view()
	{
		$products = Products::where('is_visible', 1)->with('vouchers')->get();

		return view('Products.list', ['products' => $products]);
	}

	/**
	 * Update product
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(Request $request)
	{
		$productId = $request->id;
		/**
		 * @var Products $product
		 */
		$product = Products::find($productId);
		$product->setBought();
		if ($product->save()) {
			return redirect('/');
		}
	}

}
