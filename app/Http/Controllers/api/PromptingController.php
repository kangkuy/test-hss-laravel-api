<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function Laravel\Ai\agent;

class PromptingController extends Controller
{
    public function prompt(Request $request){
        $response = agent(
            instructions: "You are a helpful daily assistant",
        )->prompt($request->input('prompt'));
        return response()->json($response);
        return response()->json($request->input('prompt'));
    }
}
