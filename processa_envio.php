<?php
    require "./bibliotecas/src/Exception.php";
    require "./bibliotecas/src/PHPMailer.php";
    require "./bibliotecas/src/POP3.php";
    require "./bibliotecas/src/SMTP.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    class Mensagem {
        private $para = null;
        private $assunto = null;
        private $mensagem = null;
        public $status = array ('codigo_status' => null, 'descricao_status' => '');

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
            header('Location: index.php'); //redireciona para o index.php, pois precisa de dados previos para entrar na aba processa_envio.php
        } 
    }

    // implementação do PHPMailer, para poder fazer requisições HTTP
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'lbm3@discente.ifpe.edu.br';                     //SMTP username
        $mail->Password   = 'vdnv csqf vbyr fluf';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients -- metodos do objeto
        $mail->setFrom('lbm3@discente.ifpe.edu.br', 'Estudante Leonardo');
        $mail->addAddress($mensagem-> __get('para'));     //Add a recipient
        $mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com'); --> copia
        //$mail->addBCC('bcc@example.com'); --> copia oculta

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $mensagem-> __get('assunto');
        $mail->Body    = $mensagem->__get('mensagem');
        $mail->AltBody = 'É necessario utilizar o client que suporte o HTML';

        $mail->send();

        $mensagem->status['codigo_status'] = 1;
        $mensagem->status['descricao_status'] = 'Email enviado com sucesso';

    } catch (Exception $e) {

        $mensagem->status['codigo_status'] = 2;
        $mensagem->status['descricao_status'] = 'Email não foi enviado com sucesso';
    }

?>
<html>
    <!-- cabeça da pagina -->
    <head>
        <meta charset="utf-8" />
    	<title>App Mail Send</title>

    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>

    <!-- corpo da pagina -->
    <body>
        <div class="container">
            <div class="py-3 text-center">
				<img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
				<h2>Send Mail</h2>
				<p class="lead">Seu app de envio de e-mails particular!</p>
			</div>
            <div class="row">
                <div class="col-md-12">
                    <? if($mensagem->status['codigo_status'] == 1) { ?>
                            <div class="container">
                                <h1 class="display-4 text-success">Sucesso</h1>
                                <p>E-mail enviado com sucesso</p>
                            </div>
                     <? } ?> 

                    // email não enviado com sucesso
                    <? if ($mensagem->status['codigo_status'] == 2) { ?>

                    <?  } ?>
                     
                </div>
            </div>
        </div>
    </body>
</html>