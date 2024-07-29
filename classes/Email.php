<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token) 
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {

          // Crear instancia de phpmailer
          $mail = new PHPMailer();

          try {

              // Configurar SMTP
              $mail->isSMTP();      
              $mail->Host       =  $_ENV['EMAIL_HOST'];    
              $mail->SMTPAuth   = true;     
              $mail->Username   = $_ENV['EMAIL_USER']; 
              $mail->Password   = $_ENV['EMAIL_PASS'];  
              $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
              $mail->Port       = $_ENV['EMAIL_PORT'];     

              // CONFIGURAR CONTENIDO DEL EMAIL
              $mail->setFrom($_ENV['EMAIL_FROM'], 'Mailer');
              $mail->addAddress($this->email, 'Bienes Raices');
          
              //Habilitar HTML
              $mail->isHTML(true);                           
              $mail->Subject = 'Confirma tu cuenta';
              $mail->CharSet = 'UTF-8';

              // Contenido
              $contenido = '<html>';
              $contenido .= '<p><strong>Hola ' . $this->nombre . '</strong> Has creado tu cuenta en App Salon, solo debe confirmarla presionando el siguiente enlace</p>';
              $contenido .= '<p>Presiona aqui: <a href="' . $_ENV['APP_URL'] . '/confirm?token=' . $this->token  . '">Confirmar Cuenta</a></p>';
              $contenido .= '<p>Si tu no solicitastes esta cuenta, puedes ignorar el mensaje</p>';
              $contenido .= '</html>';              

              $mail->Body    = $contenido;
              $mail->AltBody = 'Esto es texto alternativo sin HTML';
          
              // Enviar email
              $mail->send();
              $mensaje = 'Mensaje enviado Correctamente';
          } catch (Exception $e) {
              $mensaje = "EL mensaje no se pudo enviar, Error: {$mail->ErrorInfo}";
          }

        
    }

    public function enviarInstrucciones() {
          // Crear instancia de phpmailer
          $mail = new PHPMailer();

          try {

              // Configurar SMTP
              $mail->isSMTP();      
              $mail->Host       =  $_ENV['EMAIL_HOST'];      
              $mail->SMTPAuth   = true;     
              $mail->Username   = $_ENV['EMAIL_USER']; 
              $mail->Password   = $_ENV['EMAIL_PASS'];  
              $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
              $mail->Port       = $_ENV['EMAIL_PORT'];       

              // CONFIGURAR CONTENIDO DEL EMAIL
              $mail->setFrom($_ENV['EMAIL_FROM'], 'Mailer');
              $mail->addAddress($this->email, 'Bienes Raices');
          
              //Habilitar HTML
              $mail->isHTML(true);                           
              $mail->Subject = 'Restablece tu Password';
              $mail->CharSet = 'UTF-8';

              // Contenido
              $contenido = '<html>';
              $contenido .= '<p><strong>Hola ' . $this->nombre . '</strong> Has solicitado restrablecer tu password, sigue el siguiente enlace para hacerlo</p>';
              $contenido .= '<p>Presiona aqui: <a href="' . $_ENV['APP_URL'] . '/recover?token=' . $this->token  . '">Restablecer Password</a></p>';
              $contenido .= '<p>Si tu no solicitastes este cambio, puedes ignorar el mensaje</p>';
              $contenido .= '</html>';              

              $mail->Body    = $contenido;
              $mail->AltBody = 'Esto es texto alternativo sin HTML';
          
              // Enviar email
              $mail->send();
              $mensaje = 'Mensaje enviado Correctamente';
          } catch (Exception $e) {
              $mensaje = "EL mensaje no se pudo enviar, Error: {$mail->ErrorInfo}";
          }
    }

}