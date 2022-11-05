<?php

namespace App\Http\Controllers;

use App\DataTables\ProductsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService ,private CategoryService $categoryService )
    {
        
    }
    
    public function index(ProductsDataTable $dataTable){

        return $dataTable->render('dashboard.Products.index');

    }//end of index

    public function edit($id){
        $product = $this->productService->find($id);
        $categories=$this->categoryService->getAll();

        if (!$product)
        {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.product_not_found')];
            return back()->with('toast', $toast);
        }
        return view('dashboard.products.edit', compact('categories','product'));
    }//end of edit 

    public function create(){
        $categories=$this->categoryService->getAll();
        return view('dashboard.products.create',compact('categories'));
    }//end of create

    public function store(ProductRequest $request){
        try {
            $request->merge(['added_by'=>auth()->user()->id]);
            $request->validated();
            $this->productService->store($request->all());
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'Product Saved Successfully'];
            return redirect()->route('products.index')->with('toast', $toast);
        } catch (\Exception $ex) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    }//end of store

    public function update(ProductRequest $request, $id)
    {
        try {
            $request->validated();
            $this->productService->update($id, $request->all());
            $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect(route('products.index'))->with('toast', $toast);
        } catch (\Exception $ex) {

            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    } //end of update
    
    public function destroy($id)
    {
        try {
            $result = $this->productService->delete($id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy

    public function show($id)
    {
        $product = $this->productService->find($id);
        if (!$product)
        {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.Product_not_found')];
            return back()->with('toast', $toast);
        }
       return view('dashboard.products.show', compact('product'));
    } //end of show   

    
    public function featured($id)
    {
        $this->productService->featured($id);
        $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
        return redirect(route('products.index'))->with('toast', $toast);
    } //end of featured
}
