<?php

namespace App\Http\Controllers;

use App\Http\Services\APIService;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->page;
        $number = $request->number;
        $teacherId = $request->teacherId;

        $classes = APIService::getClasses($request->token, $teacherId, $page, $number);
        if (isset($classes->errors)) {
            return response()->json([
                'error' => $classes->errors[0]->message,
            ], 404);
        }
        
        return response()->json($classes->data->classes->data);
    }

    public function show(Request $request, $id)
    {
        $class = APIService::getClassById($request->token, $id);
        dd($class);

        return response()->json($class->data->class);
    }
}
