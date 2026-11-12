<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(Category $category): View
    {
        $services = $category->services()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('services.index', compact('category', 'services'));
    }
}
