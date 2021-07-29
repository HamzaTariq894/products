<?php

namespace Teamincredibles\Products\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use Teamincredibles\Products\Models\Category;
use Teamincredibles\Products\Http\Requests\CategoryRequest;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function addCategory(CategoryRequest $request) {
        $category = new Category;
        $category->addCategory($request);
        return response([
            'code' => 201,
            'status' => true,
            'message' =>'Category Added Successfully',
            'data' =>  $category,
        ]);
    }

    public function editCategoryDetails(CategoryRequest $request) {
        $category = Category::editCategoryDetails($request);
        if($category != null) {
            return response([
                'code' => 201,
                'status' => true,
                'message' =>'Category Updated Successfully',
                'data' => $category,
            ]);
        } else {
            return response([
                'code' => 202,
                'status' => false,
                'message' => 'Category does\'t exists!',
            ]);
        }
    }

    public function deleteCategory(CategoryRequest $request) {
        $category = Category::getCategoryInstance($request->category_id);
        if($category == null) {
            return response([
                'code' => 202,
                'status' => false,
                'message' => 'Category does\'t exists!',
            ]);
        } else {
            $category->delete();
            return response([
                'code' => 200,
                'status' => true,
                'message' =>'Category Deleted Successfully',
            ]);
        }
    }

    public function categoryRestore(Request $request) {
        $this->validate($request,[
            'category_id' => 'required|integer',
        ]);
        Category::categoryRestore($request->category_id); 
        return response([
            'code' => 200,
            'status' => true,
            'message' =>'Category Restored Successfully',
        ]);
    }

    public function getAllCategories(Request $request) {
        $categories = Category::getAllCategories($request->limit);
        return response([
            'code' => 201,
            'status' => true,
            'message' =>'Success',
            'data' => $categories,
        ]);
    }
}
