<?php
    require "./bibliotecas/src/Exception.php";
    require "./bibliotecas/src/OAuth.php";
    require "./bibliotecas/src/PHPMailer.php";
    require "./bibliotecas/src/POP3.php";
    require "./bibliotecas/src/SMTP.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class Mensagem {
        private $para = null;
        private $assunto = null;
        private $mensagem = null;

        public function __get($atributo){
            return $this->$atributo;
        }

        public function __set($atributo, $valor){
            $this->$atributo = $valor;
        }

        public function mensagemValida(){
            return !empty($this->para) &&
                !empty($this->assunto) &&
                !empty($this->mensagem);
        }
    }

    if($_SERVER["REQUEST_METHOD"] === "POST") {

        $mensagem = new Mensagem();

        $mensagem->__set('para', $_POST['para'] ?? '');
        $mensagem->__set('assunto', $_POST['assunto'] ?? '');
        $mensagem->__set('mensagem', $_POST['mensagem'] ?? '');

        if(!$mensagem->mensagemValida()){
            echo 'Mensagem não é válida';
            die();
        } 
    }

    // implementação do PHPMailer, para poder fazer requisições HTTP
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'lbm3@discente.ifpe.edu.br';                     //SMTP username
        $mail->Password   = 'SENHA_DE_APP_AQUI';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients -- metodos do objeto
        $mail->setFrom('lbm3@discente.ifpe.edu.br', 'Estudante Leonardo');
        $mail->addAddress('lbm3@discente.ifpe.edu.br', 'Estudante Leonardo');     //Add a recipient
        $mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com'); --> copia
        //$mail->addBCC('bcc@example.com'); --> copia oculta

        //Attachments
        $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Oi, eu sou o assunto!';
        $mail->Body    = 'Oi, eu sou o conteúdo do <strong>e-mail</strong>';
        $mail->AltBody = 'Oi, eu sou o conteúdo do e-mail';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Não foi possível enviar esse e-mail! Tente novamente mais tarde";
        echo "Detalhes do erro: {$mail->ErrorInfo}";
    }

?>