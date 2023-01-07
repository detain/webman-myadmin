<?php
namespace app\middleware;

use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;
use support\Db;

class Auth implements MiddlewareInterface
{
    public function process(Request $request, callable $next) : Response
    {
        $key = $request->header('x-api-key');
        $login = $request->header('x-api-login');
        $pass = $request->header('x-api-pass');
        if (is_null($key) && (is_null($login) || is_null($pass)))
            return new Response(401, ['Content-Type' => 'application/json'], json_encode(['code' => 401, 'message' => 'API credentials are missing'], JSON_UNESCAPED_UNICODE));
        if (!is_null($pass))
            $accountInfo = Db::table('accounts')
                ->where('account_lid', $login)
                ->where('account_passwd', md5($pass))
                ->first();
        elseif (!is_null($key))
            $accountInfo = Db::table('accounts')
                ->leftJoin('account_security', 'account_security.account_id','=','accounts.account_id')
                ->where('account_sec_type', 'api_key')
                ->where('account_sec_data', $key)
                ->first();
        if (is_null($accountInfo))
            return new Response(401, ['Content-Type' => 'application/json'], json_encode(['code' => 401, 'message' => 'API credentials are invalid'], JSON_UNESCAPED_UNICODE));
        $request->accountInfo = $accountInfo;
        return $next($request);
    }
}
