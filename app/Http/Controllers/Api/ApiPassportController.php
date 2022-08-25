<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Nyholm\Psr7\Response as Psr7Response;
use Psr\Http\Message\ServerRequestInterface;

class ApiPassportController extends \Laravel\Passport\Http\Controllers\AccessTokenController
{

    public function issueToken(ServerRequestInterface $request)
    {
        $data = parent::issueToken($request); // TODO: Change the autogenerated stub
        if ($data->getStatusCode() == 200) {
            $data = json_decode($data->content());
            return Response::json($data);
        }
        if ($data->getStatusCode() == 401) {
            $data = json_decode($data->content());
            return Response::json($data, "Username atau Passowrd salah", 401);
        }
    }

    public function attemptLogin(ServerRequestInterface $request)
    {
//        LumenPassport::tokensExpireIn(Carbon::now('Asia/Makassar')->addHours(2), 8);
        $data = $this->withErrorHandling(function () use ($request) {
            $data = $this->convertResponse(
                $this->server->respondToAccessTokenRequest($request, new Psr7Response)
            );
            $data = json_decode($data->content());
            return Response::json($data);
        });
        if ($data->getStatusCode() == 401) {
            $data = json_decode($data->content());
            return Response::json($data, "Username atau Passowrd salah", 401);
        }
    }

    public function getDetailUser()
    {
        $data = Auth::guard('api')->user();
        return Response::json($data, 'Ok');
    }

    public function logout()
    {
        $accessToken = Auth::guard('api')->user()->token();
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);
        $accessToken->revoke();
        return Response::json("", "Berhasil Logout");
    }

    public function getRoleAkses()
    {
        $user = auth()->user()->load('Role.Akses');
        return Response::json($user);
    }
}