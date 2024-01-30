<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponse;
    public function listCategories()
    {
        $categories = Category::all();
        return $this->ResponseSuccess(data: ["Categories" => $categories], message: __('auth.list_successful'), statusCode: 200);

    }
}
