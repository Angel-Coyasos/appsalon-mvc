<?php 

namespace Model;

class Usuario extends ActiveRecord {

    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'telefono', 'admin', 'confirmado', 'token', 'password'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;
    public $password;

    public function __construct( $args = [] ) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    public function validarNuevaCuenta() {

        if (!$this->nombre) {
           self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }

        if (!$this->apellido) {
            self::$alertas['error'][] = 'El Apellido es Obligatorio';
        }

        if (!$this->telefono) {
            self::$alertas['error'][] = 'El Telefono  es Obligatorio';
        }

        if (!$this->email) {
            self::$alertas['error'][] = 'El Correo  es Obligatorio';
        }

        if (!$this->password) {
            self::$alertas['error'][] = 'La  Contraseña es Obligatoria';
        }

        if ( strlen($this->password) < 8  || !preg_match('/[A-Z]/', $this->password) || !preg_match('/[a-z]/', $this->password) || !preg_match('/[0-9]/', $this->password) || !preg_match('/[\W]/', $this->password) ) {
            self::$alertas['error'][] = 'La  Contraseña debe contener al menos 8 caracteres, entre minusculas, mayusculas, numeros y simbolos';
        }

        return self::$alertas;
    }

    public function validarLogin() {

        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }

        if (!$this->password) {
            self::$alertas['error'][] = 'El Password es Obligatorio';
        }
        
        return self::$alertas;
    }

    public function validarEmail() {
        
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        
        return self::$alertas;

    }

    public function validarPassword() {
        
        if (!$this->password) {
            self::$alertas['error'][] = 'La  Contraseña es Obligatoria';
        }

        if ( strlen($this->password) < 8  || !preg_match('/[A-Z]/', $this->password) || !preg_match('/[a-z]/', $this->password) || !preg_match('/[0-9]/', $this->password) || !preg_match('/[\W]/', $this->password) ) {
            self::$alertas['error'][] = 'La  Contraseña debe contener al menos 8 caracteres, entre minusculas, mayusculas, numeros y simbolos';
        }
        
        return self::$alertas;

    }

    // Revisa si el usuario ya existe
    public function existeUsuario() {
        $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado->num_rows) {
            self::$alertas['error'][] = 'El Usuario ya esta registrado';
        }

        return $resultado;

    }

    public function hashPassword() {
        $this->password = password_hash( $this->password, PASSWORD_BCRYPT );
    }

    public function crearToken() {
        $this->token = uniqid();
    }

    public function comprobarPasswordAndVerificado($password) {
        
        $resultado = password_verify($password, $this->password);
        
        if ( !$resultado || !$this->confirmado ) {
            self::$alertas['error'][] = 'Password Incorrecto o tu cuneta no ha sido confirmada';
        } else {
           return true;
        }
        
    }

    public function setValueAdmin($value) {
        $this->admin = $value;
    }

    public function setValueConfirmado($value) {
        $this->confirmado = $value;
    }

    public function setValueToken($value) {
        $this->token = $value;
    }

}