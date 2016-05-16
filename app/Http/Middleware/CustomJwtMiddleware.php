<?php
/**
 * Created by PhpStorm.
 * User: zq014
 * Date: 16-4-14
 * Time: 上午11:43
 */

namespace App\Http\Middleware;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Middleware\BaseMiddleware;

class CustomJwtMiddleware extends BaseMiddleware
{
    public function handle($request, \Closure $next)
    {
        if (!$token = $this->auth->setRequest($request)->getToken()) {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(500,'非法请求');
        }

        try {
            $user = $this->auth->authenticate($token);
        } catch (TokenExpiredException $e) {
            return $this->respond('tymon.jwt.expired', 'token过期，请重新申请', $e->getStatusCode(), [$e]);
        } catch (JWTException $e) {
            return $this->respond('tymon.jwt.invalid', 'token失效，请重新登录', $e->getStatusCode(), [$e]);
        } catch (\Exception $e) {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(500, '认证服务器错误，请稍后重试');
        }
        if (!$user) {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(500,'非法请求');
        }

        $this->events->fire('tymon.jwt.valid', $user);

        return $next($request);
    }


    protected function respond($event, $error, $status, $payload = [])
    {
        $response = $this->events->fire($event, $payload, true);

        return $response ?: $this->response->json(['message' => $error, 'status_code' => $status], $status);
    }
}