<?php
namespace src\lib;
use Firebase\JWT\JWT;
use Tuupola\Base62;

class Auth
{
    private static $encrypt = ['HS256'];
    private static $aud = null;
  
    public static function SignIn($data)
    {
        
        $time = time();
        $jti = (new Base62)->encode(random_bytes(16));
        $token = array(
            "iat" => $time,
            'exp' => $time + (60*3600),
            "jti" => $jti,
            "id" => $data['id'],
            "username" => $data['username'],
            "scope" => $data['scope'],
            'aud' => self::Aud(),
            
        );

        return JWT::encode($token,getenv("JWT_SECRET"));
    }

    public static function Restore($data)
    {
        
         $token = array(
            "iat" => $data['iat'],
            'exp' => $data['exp'],
            "jti" => $data['jti'],
            "id" => $data['id'],
            "username" => $data['username'],
            "scope" => $data['scope'],
            'aud' => self::Aud(),
            
        );

        return JWT::encode($token,getenv("JWT_SECRET"));
    }

    public  static function Aud()
    {
        $aud = '';
        
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = $_SERVER['REMOTE_ADDR'];
        }
        
        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();
        
        return sha1($aud);
    }

    public static function GetData($token)
    {
        return JWT::decode(
            $token,
            getenv("JWT_SECRET"),
            self::$encrypt
        );
    }
    
    
   
}