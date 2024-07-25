<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {

    public static function login( Router $router ) {

        $alertas = [];

        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

            $auth = new Usuario($_POST);
            $auth->sincronizar($_POST);
            $auth->validarLogin();

            // Leer alertas
            $alertas = Usuario::getAlertas();

            if (empty($alertas)) {
                // Comprobar que exista el usuario
                $usuario = Usuario::where('email', $auth->email);

                if ( $usuario ) {

                    // Verificar el password
                    if ( $usuario->comprobarPasswordAndVerificado($auth->password) ) {
                        // Autenticar al usuario
                        session_start();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // Redireccionamiento
                        if ( $usuario->admin === "1" ) {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /cita');
                        }
                    }
                } else {
                    // Mostrar mensaje de error
                    Usuario::setAlerta('error', 'Usuario No Encontrado');
                }

            }

        }

        // Leer alertas
        $alertas = Usuario::getAlertas();

        $router->render('/auth/login', [
            'alertas' => $alertas
        ]);
    }

    public static function logout( Router $router ) {
        session_start();
        $_SESSION = [''];
        header('Location: /');
    }

    public static function forget(  Router $router) {

        $alertas = [];

        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

            $auth = new Usuario($_POST);
            $auth->sincronizar($_POST);
            $alertas = $auth->validarEmail();

            if (empty($alertas)) {
                
                $usuario = Usuario::where('email', $auth->email);

                if ( $usuario && $usuario->confirmado === "1" ) {

                    // Generar token
                    $usuario->crearToken();
                    $usuario->guardar();

                    // enviar el email
                    $email = new Email( $usuario->email, $usuario->nombre, $usuario->token );
                    $email->enviarInstrucciones();

                    Usuario::setAlerta('exito', 'Revisa tue email');
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe o no ha sido confirmado');
                }

            }

        }

        // Leer alertas
        $alertas = Usuario::getAlertas();

        $router->render('/auth/forget', [
            'alertas' => $alertas
        ]);
    }

    public static function recover( Router $router ) {

        $alertas = [];
        $error = false;
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);

        if( empty($usuario) ) {
            // Mostrar mensaje de error
            $error = true;
            Usuario::setAlerta('error', 'Token No valido');

        }

        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

            // leer el nuevo password y guardarlo
            $password = new Usuario($_POST);
            $password->sincronizar($_POST);
            $alertas = $password->validarPassword();

            if ( empty($alertas) ) {

                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->setValueToken(null);

                $resultado = $usuario->guardar();

                if($resultado) {
                    header('Location: /');
                }
                
                Usuario::setAlerta('exito', 'Cuenta Comproboda Correctamente');
            }

            
        }

        // Leer alertas
        $alertas = Usuario::getAlertas();

        $router->render('/auth/recover', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function register( Router $router ) {

        $usuario = new Usuario($_POST);
        $alertas = [];

        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarNuevaCuenta();

            if ( empty($alertas) ) {

                // Verificar que el usuario no este registrado
                $resultado = $usuario->existeUsuario();

                if ( $resultado->num_rows ) {
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear el Password
                    $usuario->hashPassword();

                    // Generar token unico
                    $usuario->crearToken();

                    // Enviar el Email
                    $email = new Email( $usuario->email, $usuario->nombre, $usuario->token );
                    $email->enviarConfirmacion();

                    /* $usuario->setValueAdmin('0');
                    $usuario->setValueConfirmado('0'); */

                    // Crear el usuario
                    $resultado = $usuario->guardar();

                    if ($resultado) {
                        echo 'guardado correcatemnte';
                        header('Location: /mensaje');
                    }

                }
                
            }

        }

        $router->render('/auth/register', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function confirm(  Router $router) {

        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);

        if( empty($usuario) ) {
            // Mostrar mensaje de error
            Usuario::setAlerta('error', 'Token No valido');

        } else {
            // Modificar usuario confirmado
            $usuario->setValueConfirmado('1');
            $usuario->setValueToken(null);
            $usuario->guardar($usuario->id);

            Usuario::setAlerta('exito', 'Cuenta Comproboda Correctamente');
        }

        // Leer alertas
        $alertas = Usuario::getAlertas();

        $router->render('/auth/confirm', [
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(  Router $router) {
        $router->render('/auth/mensaje', []);
    }

}