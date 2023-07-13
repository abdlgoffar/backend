<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use DomainException;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use UnexpectedValueException;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $key = 'hfu58588ywehgddhr8r7488hgrig2996e3rd1w4gydh4h8t85921hdbve33w132as1425sv3dvud09h70jn948bf5s7dbcjnkmzoaolskkdeu6490i92';
        $header = $request->header("authorization");
        $token = explode(" ", $header);

        try {

            JWT::decode(end($token), new Key($key, 'HS256'));

            $user = DB::table('users')->where('jwt_token', end($token))->first();
            if (empty($user->name))  throw new AuthenticationException();

            return $next($request);
        } catch (InvalidArgumentException $e) {

            throw new AuthenticationException();
        } catch (DomainException $e) {

            throw new AuthenticationException();
        } catch (SignatureInvalidException $e) {

            throw new AuthenticationException();
        } catch (BeforeValidException $e) {

            throw new AuthenticationException();
        } catch (ExpiredException $e) {

            throw new AuthenticationException();
        } catch (UnexpectedValueException $e) {

            throw new AuthenticationException();
        }
    }
}
