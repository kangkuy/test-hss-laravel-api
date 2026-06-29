<?php

namespace App\Http\Controllers\api\auth;

use App\Helpers\Datatable;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function employeeData(Request $request)
    {
        $data = Employee::query();
        if($request->search){
            $data->where('name', 'like', "%{$request->search}%");
        }
        $response = Datatable::make($request, $data)
            ->addColumn('name', fn($item) => $item->name)
            ->addColumn('email', fn($item) => $item->email)
            ->addColumn('address', fn($item) => $item->address)
            ->addColumn('phone_number', fn($item) => $item->phone_number)
            ->response();
        return $response;
    }
}
