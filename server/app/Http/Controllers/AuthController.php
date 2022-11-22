<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse|bool|string
    {
        $loginEndpoint = 'https://www.googleapis.com/identitytoolkit/v3/relyingparty/verifyPassword?key=AIzaSyAh2Au-mk5ci-hN83RUBqj1fsAmCMdvJx4';

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $loginEndpoint,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'email' => $request->email,
                'password' => $request->password,
                'returnSecureToken' => true
            ]),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
            ],
        ]);

        $rawResponse = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }

        curl_close($curl);

        if (isset($error_msg)) {
            return response()->json([
                'error' => $error_msg,
            ], 400);
        }

        $response = json_decode($rawResponse);
        $accountInfo = $this->getAccountInfo($response->idToken);
        $accountId = json_decode($accountInfo->users[0]->customAttributes)->id;
        $teacherInfo = $this->findInfoInRoleById($response->idToken, $accountId);
        $response->info = $teacherInfo->data->users->findInfoInRoleById[0]->info;

        return response()->json($response);
    }

    public function getAccountInfo($token)
    {
        $getAccountInfoEndpoint = 'https://www.googleapis.com/identitytoolkit/v3/relyingparty/getAccountInfo?key=AIzaSyAh2Au-mk5ci-hN83RUBqj1fsAmCMdvJx4';

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $getAccountInfoEndpoint,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '
                {
                    "idToken": "' . $token . '"
                }
            ',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }

        curl_close($curl);

        if (isset($error_msg)) {
            return response()->json([
                'error' => $error_msg,
            ], 400);
        }

        return json_decode($response);
    }

    public function findInfoInRoleById($token, $accountId)
    {
        $findInfoInRoleByIdEndpoint = 'https://lms-api.mindx.vn/';

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $findInfoInRoleByIdEndpoint,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '
                {
                    "operationName":"FindInfoInRoleById",
                    "variables":{
                        "payload":{
                            "id":"' . $accountId . '"
                        }
                    },
                    "query":"mutation FindInfoInRoleById($payload: FindInfoInRoleByIdCommand!) {\n  users {\n    findInfoInRoleById(payload: $payload) {\n      info\n      role\n    }\n  }\n}\n"
                }
            ',
            CURLOPT_HTTPHEADER => [
                'Authorization: ' . $token,
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }

        curl_close($curl);

        if (isset($error_msg)) {
            return response()->json([
                'error' => $error_msg,
            ], 400);
        }

        return json_decode($response);
    }
}
