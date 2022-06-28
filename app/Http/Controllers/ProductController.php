<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $params = $request->only('title', 'date');
        $title = ''; $date = '';

        if( isset($params['title']) ){
            $title = $params['title']; 
        }

        if( isset($params['date']) ){
            $date = $params['date'];

            $data = Product::where('title', 'like',  '%' . $title . '%')
                    ->where(DB::raw("(DATE_FORMAT(created_at,'%Y-%m-%d'))"), $date)
                    ->paginate(5);
        }else{   
            $data = Product::where('title', 'like',  '%' . $title . '%')->paginate(5);
        }


        return view('products.index', ['data' => $data]);

    }

 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
  
        print_r($request->all()); 
        $request->validate([
            'title' => 'required',
            'sku' => 'required',
            'description' => 'required',
        ]);
        
        Product::create($request->all());
        return redirect()->route('products.product')->with('success', 'Product created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product_object, Request $request)
    {
        $product_id = ($request->segment(2)); 
        $variants = Variant::all();
        $product_obj = Product::find($product_id);
        $product['title'] = $product_obj->title; 
        return view('products.edit', compact('variants', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $request->validate([
            'title' => 'required',
            'sku' => 'required',
            'description' => 'required',
        ]);

        Product::update($request->all());
        return redirect()->route('products.product')->with('success', 'Product created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();
        return redirect()->route('products.product')->with('success', 'Product deleted successfully');
    }

    public function search()
    {
        $search_text = $_GET['query'];
        $products = Product::where('title', 'LIKE', '%'.$search_text.'%')->with('blog')->get();

        return view('products.search', compact('products'));
    }
}
