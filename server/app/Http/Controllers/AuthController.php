<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Services\APIService;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse|bool|string
    {
        $email = $request->email;
        $password = $request->password;

        $loginResponse = APIService::login($email, $password);
        if (isset($loginResponse->error)) {
            return response()->json([
                'error' => $loginResponse->error->message,
            ], 404);
        }

        $accountInfoResponse = APIService::getAccountInfo($loginResponse->idToken);
        $accountId = json_decode($accountInfoResponse->users[0]->customAttributes)->id;
        $teacherInfoResponse = APIService::findInfoInRoleById($loginResponse->idToken, $accountId);
        $loginResponse->info = $teacherInfoResponse->data->users->findInfoInRoleById[0]->info;

        return response()->json($loginResponse);
    }
}
