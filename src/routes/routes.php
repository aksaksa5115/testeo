<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;


#Esta es una funcion de prueba, retorna todos los usuarios de la base de datos.
return function (App $app, PDO $pdo, $JWT) {
    $app->get('/users', function (Request $request, Response $response) use ($pdo) {
        $stmt = $pdo->query("SELECT * FROM usuario"); 
        $usuarios = $stmt->fetchAll();

        $response->getBody()->write(json_encode($usuarios));
        return $response;
    });

    //---------<A PARTIR DE ACA SE AGREGAN LAS RUTAS DE LOS CONTROLADORES>------------------
    //--------- Ruta para los controladores de usuarios -----------
    #este controlador posee las siguientes opciones:
    # POST /login <--------- loguearse en la pag
    # POST /registro <------ registrarse en la pag
    # PUT /perfil <------- actualizar datos del usuario logueado
    # GET /perfil <------- obtener datos del usuario logueado
    (require __DIR__ . '/../Controllers/UserController.php')($app, $pdo, $JWT);
    //---------------------------------------------------------------------------------------
    
};
