<?php
use \Slim\Middleware\HttpBasicAuthentication\PdoAuthenticator,
    \Slim\Middleware\JwtAuthentication,
    \Slim\HttpCache\Cache,
    \Slim\Middleware\HttpBasicAuthentication,
    \Tuupola\Middleware\Cors;


//middleware que protege toda la app, global usado en container

$container = $app->getContainer();

//CORS de tuupola
$container["Cors"] = function ($container) {
    return new Cors([
        "origin" => ["*"],
        "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
        "headers.allow" => [],
        "headers.expose" => ["Etag"],
        "credentials" => false,
        "cache" => 0,
        
    ]);
};


$app->add("Cors");

// Gestion autenticacion para obtener el token
$container["HttpBasicAuthentication"] = function ($container)  {
    $pdo=$container['pdo']; 
    return new HttpBasicAuthentication([
        "path" => ["/v1/token"],
        "realm" => "Protected",
        "secure" => true,
        "relaxed" => ["localhost"],
        "authenticator" => new PdoAuthenticator([
            "pdo" => $pdo,
            "table" => "accounts",
            "user" => "username",
            "hash" => "hashed"
        ]),
        "error" => function ($request, $response, $arguments) {
            return $response->withJson(array('error'=>'Credenciales incorrectas'), 403);
        }
        
    ]);
};
$app->add("HttpBasicAuthentication");

//  autenticacion JWT
$container["JwtAuthentication"] = function ($container) {
    return new JwtAuthentication([
        "path" => "/v1",
        "passthrough" => ["/v1/token","/v1/status"],
        "secret" => getenv("JWT_SECRET"),
        "attribute" => false,
        "cookie" => "facebook",
        "relaxed" => ["localhost"],
        "error" => function ($request, $response, $arguments) {
            $data["status"] = "error";
            $data["mensaje"] = $arguments["message"];
            return $response
                   ->withHeader("Content-Type", "application/json")
                   ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        },
        "callback" => function ($request, $response, $arguments) use ($container) {
            $container["token"] = $arguments["decoded"];
            
           
        }
        ]);

   
};
$app->add("JwtAuthentication");

