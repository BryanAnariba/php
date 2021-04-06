<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require 'vendor/phpmailer/PHPMailer/src/Exception.php';
    require 'vendor/phpmailer/PHPMailer/src/PHPMailer.php';
    require 'vendor/phpmailer/PHPMailer/src/SMTP.php';
    class Email {
        public function sendEmail ($data) {
            
                $emailDestino = $data['emailDestino'];
                $name = $data['name'];
                $mail = new PHPMailer(true); // Instancia PHPmAILER 
                try {
                    //Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host = 'smtp.office365.com'; // IR a correo institucional/configuraciones/correo/sincronizar correo/ configuracion smtp
                    $mail->SMTPAuth = true;                                   // Enable SMTP authentication
                    $mail->Username = 'ariel.anarib@unah.edu.hn';// Email usuario remitente
                    $mail->Password = 'Ef5FrUd92D';// Clave usuario remitente
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                
                    //Recipients
                    $mail->setFrom('ariel.anarib@unah.edu.hn', 'Admin POA PACC'); // Desde mi correo envio a
                    $mail->addAddress($emailDestino, 'Usuario'); // Para
                
                    // Attachments
                    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
                
                    // Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Bienvenido a la plataforma POA PACC ' . $emailDestino;
                    $mail->Body = '
                        <h2>Tus Credenciales de acceso son: </h2>
                        Nombre Usuario: ' . $name . '<br/>' . 
                        'Correo: ' . $emailDestino . '<br/>' .'
                        Password: asd.456';
                    $mail->AltBody = 'Mantente siempre conectado para que puedas ver las siguientes notificacion';
                
                    if ($mail->send()) {
                        echo json_encode(array("message" => "El mensaje se envio por correo con exito"));
                    }
                } catch (Exception $e) {
                    echo json_encode("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
                }
        }
    }