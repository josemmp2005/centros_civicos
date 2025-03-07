<?php

namespace App\Controllers;

use App\Models\Usuarios;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;


class AuthController
{
    private $requestMethod;

    private $userId;

    private $users;

    public function __construct($requestMethod){
        $this->requestMethod = $requestMethod;
        $this->users = Usuarios::getInstancia();
    }

    public function LoginFromRequest() {
        $input = json_decode(file_get_contents('php://input'), true);
    
        if (json_last_error() != JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['mensaje' => 'El JSON recibido no es válido']);
            exit();
        }
    
        $email = $input['email'] ?? '';
        $password = $input['password'] ?? '';
    
        $dataUser = $this->users->login($email, $password);
    
        if (!$dataUser) {
            http_response_code(401);
            echo json_encode(["mensaje" => "Credenciales incorrectas"]);
            exit();
        }
    
        $key = KEY;
        $issuer_claim = "http://centros_civicos.local";
        $audience_claim = "http://centros_civicos.local";
        $issuedat_claim = time();
        $expire_claim = $issuedat_claim + 3600;
    
        $token = [
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "nbf" => $issuedat_claim,
            "exp" => $expire_claim,
            "data" => [
                "email" => $email
            ]
        ];
    
        $jwt = \Firebase\JWT\JWT::encode($token, $key, 'HS256');
    
        http_response_code(200);
        echo json_encode([
            "mensaje" => "Acceso concedido",
            "jwt" => $jwt,
            "email" => $email,
            "ExpireAt" => $expire_claim
        ]);
        exit(); // Detenemos la ejecución aquí
    }
}
?>    