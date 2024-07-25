<?php 

namespace Controllers;

use Model\Servicio;
use Model\Cita;
use Model\CitaServicio;

class APIController {

    public static function index() {

        $servicios = Servicio::all();

        echo json_encode($servicios);
    }

    public static function guardar() {

        // Almacena la cita y devuelve el Id
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        $id = $resultado['id'];

        // almacena la cita y el servcicio

        // Almacena los servicios con el id de la cita
        $idServicios = explode( ',', $_POST['servicios'] );
        foreach( $idServicios as $idServicio ) {

            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];

            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();

        };

        // Retornamos una respuesta
        $respuesta = [
            'servicios' => $resultado
        ];

        echo json_encode(['resultado' => $resultado]);

    }


    public static function eliminar() {

        if ( $_SERVER['REQUEST_METHOD'] === 'POST') {
            $cita = Cita::find($_POST['id']);
            $cita->eliminar();

            header('Location: /admin');
        }

    }

}