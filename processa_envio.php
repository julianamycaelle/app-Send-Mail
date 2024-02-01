<?php
require "./bibliotecas/phpMailer/Exception.php";
require "./bibliotecas/phpMailer/PHPMailer.php";
require "./bibliotecas/phpMailer/POP3.php";
require "./bibliotecas/phpMailer/SMTP.php";
//print_r($_POST);
class Mensagem{
    private $para=null;
    private $assunto=null;
    private $mensagem=null;
    public $status=array('codigo_status'=>null,'descricao_status'=>'');

    public function __get($atributo){
        return $this->$atributo;
    }
    public function __set($atributo,$valor){
        $this->$atributo=$valor;
    }

    public function mensagemValida(){
        if(empty($this->para)|| empty($this->assunto)|| empty($this->mensagem)){
            return false;
    }else{
        return true;
    }

}
}
$mensagem = new Mensagem();
$mensagem->__set('para',$_POST['para']);
$mensagem->__set('assunto',$_POST['assunto']);
$mensagem->__set('mensagem',$_POST['mensagem']);

//print_r($mensagem);
#faça uma lógica para verificar 
#se algum dos campos digitados estão vazios
#de forma que emita uma mensagem
#se tiver vazio:"mensagem nao enviada, tem campos vazios!"
#se todos os campos tiver okay:"Mensagem pronta para envio!"
if($mensagem->mensagemValida()){
    echo 'Mensagem valida, pronta para envio!';
}else{
    echo 'Mensagem não válida, tem campos vazios';
}

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings (configurações do servidor)
    $mail->SMTPDebug = false;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'juliana25centerfamili@gmail.com';                     //SMTP username
    $mail->Password   = 'anassasnna';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //receptor
    $mail->setFrom('juliana25centerfamili@gmail.com', 'Web completo');
    $mail->addAddress($mensagem->__get('para'));     //Add a recipient
    //$mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo('juliana25centerfamili@gmail.com');
   // $mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //EMail
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Assunto';
    $mail->Body    = 'mensagem bla bla bla ';
    //$mail->AltBody = 'corpo do e-mail';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>