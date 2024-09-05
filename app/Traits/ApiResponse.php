<?php
 
namespace App\Traits;
 
trait ApiResponse
{
    /** @param  array|string  $data
     * @param  string  $message
     * @param  int|null  $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data, string $message = null, int $code = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function successVoid(string $message = null, int $code = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
        ], $code);
    }

    protected function successToken($token, int $code = 200)
    {
        return response()->json([
            'status' => true,
            'token' => $token
        ], $code);
    }
 
    /**
     * Return an error JSON response.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  array|string|null  $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error($message, int $code = 200, $data = null)
    {
        $message = gettype($message) === 'object' 
            ?  $message->getMessage() . ' # ' . $message->getFile() . ' # ' . $message->getLine() 
            : $message
        ;
        
        $message = in_array(env('APP_ENV'), ['local', 'dev']) 
            ? $message
            : $message->getMessage()
        ;
        
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data
        ], $code);
    }
 
}
