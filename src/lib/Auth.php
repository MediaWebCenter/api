<?php
namespace src\lib;
use Firebase\JWT\JWT;
use Tuupola\Base62;

class Auth
{
    private static $encrypt = ['HS256'];
    private static $aud = null;
  // meter los payload en el token
    public static function SignIn($data, $username)
    {
        //deserializamos el scope
        $deserializar= unserialize($data->scope);
       //ponemos el tiempo
        $time = time();
        //encriptamos el jti en Base62 con tuupola
        $jti = (new Base62)->encode(random_bytes(16));
        //generamos el array con los payloads
        $token = array(
            "iat" => $time,
            'exp' => $time + (60*3600),
            "jti" => $jti,
            "id" => $data->id,
            "username" => $username,
            "xrequest" => $data->xrequest,
            "scope" => $deserializar,
            'aud' => self::Aud(),
            );
            
            //Codificamos el token en JWT
        $token=JWT::encode($token,getenv("JWT_SECRET"));
       
        //retornamos el token
        return $token;
    }
  //encriptar el token
    public static function Restore($data,$username)
    {

        
                     
        $deserializar= unserialize($data->scope);
         $token = array(
            "iat" => $data->iat,
            'exp' => $data->exp,
            "jti" => $data->jti,
            "id" => $data->id,
            "username" => $username,
            "xrequest" =>$data->xrequest,
            "scope" => $deserializar,
            'aud' => self::Aud(),
            
        );
       
       $token=JWT::encode($token,getenv("JWT_SECRET"));
       return $token;
       
    }
  //meter el aud del token
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
//desencriptar el token
    public static function GetData($token)
    {
        return JWT::decode(
            $token,
            getenv("JWT_SECRET"),
            self::$encrypt
        );
    }
    
    
   
}