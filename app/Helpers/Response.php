<?php
/**
 * Created by PhpStorm.
 * User: alifdoco
 * Date: 2018-11-27
 * Time: 17:20
 */

namespace App\Helpers;


use Illuminate\Support\Facades\DB;

class Response
{
    const STATUS_OK = 200;
    const STATUS_VALIDATION_ERROR = 422;
    const STATUS_INTERNAL_SERVER_ERROR = 500;
    const STATUS_BAD_REQUEST = 400;
    const STATUS_NOT_FOUND = 404;
    const STATUS_DELETED = 204;

    const MESSAGE_200 = 'ok';
    const MESSAGE_422 = 'missing required parameter';
    const MESSAGE_500 = 'internal server error';
    const MESSAGE_400 = 'bad request';
    const MESSAGE_404 = 'not found';
    const MESSAGE_204 = 'succesfully delete';
    const MESSAGE_UPDATE = 'succesfully update';
    const MESSAGE_INSERT = 'succesfully insert';

    static public function json($data, $message = self::MESSAGE_200, $status = self::STATUS_OK)
    {
        if ($data === null || $data === false) {
            return self::notFound();
        }
        $dgn = [
            'status' => $status,
            'message' => $message
        ];
        $page_info = null;
        if (method_exists($data, 'total')) {
            $page_info = [
                'current_page' => $data->currentPage(),
                'first_page_url' => $data->url(1),
                'from' => $data->firstItem(),
                'last_page' => $data->lastPage(),
                'last_page_url' => $data->url($data->lastPage()),
                'next_page_url' => $data->nextPageUrl(),
                'per_page' => $data->perPage(),
                'prev_page_url' => $data->previousPageUrl(),
                'to' => $data->lastItem(),
                'total' => $data->total(),
            ];
            $data = $data->items();
        }
        $response = [
            'diagnostic' => $dgn,
            'response' => $data
        ];
        if ($page_info) {
            $response['page_info'] = $page_info;
        }
        return response()->json($response, $status);
    }

    static public function validationError($required_parameter,$params = [])
    {
        $dgn = [
            'status' => self::STATUS_VALIDATION_ERROR,
            'message' => self::MESSAGE_422,
            'required_parameter' => $required_parameter,
            'params' => $params
        ];
        self::insertError($dgn,self::STATUS_VALIDATION_ERROR);
        return response()->json([
            'diagnostic' => $dgn
        ], self::STATUS_VALIDATION_ERROR);
    }

    static public function error($message = self::MESSAGE_500, $file = '', $line = '')
    {
        $dgn = [
            'status' => self::STATUS_INTERNAL_SERVER_ERROR,
            'message' => $message,
        ];
        if ($file !== '') {
            $dgn['file'] = $file;
        }
        if ($line !== '') {
            $dgn['error_line'] = $line;
        }
        self::insertError($dgn,self::STATUS_INTERNAL_SERVER_ERROR);
        return response()->json([
            'diagnostic' => $dgn
        ], self::STATUS_INTERNAL_SERVER_ERROR);
    }

    static public function messageOnly($message = self::MESSAGE_200, $status = self::STATUS_OK)
    {
        $dgn = [
            'status' => $status,
            'message' => $message,
        ];
        return response()->json([
            'diagnostic' => $dgn
        ], $status);
    }

    static public function badRequest($message = self::MESSAGE_400)
    {
        $dgn = [
            'status' => self::STATUS_BAD_REQUEST,
            'message' => $message,
        ];
        self::insertError($dgn,self::STATUS_BAD_REQUEST);
        return response()->json([
            'diagnostic' => $dgn
        ], self::STATUS_BAD_REQUEST);
    }

    static public function errorWithStatus($message = self::MESSAGE_500, $status = self::STATUS_INTERNAL_SERVER_ERROR)
    {

        $dgn = [
            'status' => $status,
            'message' => $message,
        ];
        self::insertError($dgn,$status);
        return response()->json([
            'diagnostic' => $dgn
        ], $status);
    }

    static public function notFound($message = self::MESSAGE_404)
    {
        $dgn = [
            'status' => self::STATUS_NOT_FOUND,
            'message' => $message
        ];
        return response()->json([
            'diagnostic' => $dgn
        ], self::STATUS_NOT_FOUND);
    }

    static public function successDelete($deleted, $message = self::MESSAGE_204)
    {
        if ($deleted) {
            $dgn = [
                'status' => self::STATUS_DELETED,
                'message' => $message
            ];
        } else {
            return self::notFound();
        }
        return response()->json([
            'diagnostic' => $dgn
        ]);
    }

    static public function successUpdate($data, $message = self::MESSAGE_UPDATE)
    {
        if (!$data) {
            return self::notFound();
        }
        $dgn = [
            'status' => self::STATUS_OK,
            'message' => $message
        ];
        $response = [
            'diagnostic' => $dgn,
            'response' => $data
        ];
        return response()->json($response, self::STATUS_OK);
    }

    static public function unauthorized()
    {
        return response()->json([
            'diagnostic' => [
                'status' => 401,
                'message' => 'unauthorized'
            ]
        ], 401);
    }

    static public function forbidden()
    {
        return response()->json([
            'diagnostic' => [
                'status' => 403,
                'message' => 'forbidden'
            ]
        ], 403);
    }

    static function insertError($message,$status)
    {
        if (is_array($message)) {
            $message = json_encode($message);
        }
        DB::table('error')->insert([
            'message' => $message,
            'user_insert' => auth('api')->check() ? auth('api')->user()->username : 'client',
            'status' => $status
        ]);
    }
}
