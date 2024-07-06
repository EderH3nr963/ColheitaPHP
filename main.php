<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\Users\ederh\OneDrive\Área de Trabalho\ColheitaPHP\vendor\autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$mail = new PHPMailer(true);

try {
    // Configurações do servidor
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';  // Especifique o servidor SMTP
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV ['MEU_EMAIL']; // Seu endereço de e-mail SMTP
    $mail->Password   = $_ENV['MINHA_SENHA']; // Sua senha SMTP
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Ativar TLS ou PHPMailer::ENCRYPTION_SMTPS para SSL
    $mail->Port       = 587; // Porta TCP. Comum: 587 para TLS, 465 para SSL

    // Remetente e destinatário
    $mail->setFrom($_ENV['MEU_EMAIL'], "colheita");
    $mail->addAddress("ederhenriquevicentejust963@gmail.com", "Eder"); // Adicionar um destinatário

    // Conteúdo do e-mail
    $mail->isHTML(true); // Definir e-mail no formato HTML
    $mail->Subject = 'Seu Código de Verificação';
    $mail->Body    = 'Seu código de verificação é $verificationCode';
    $mail->altBody = 'Seu código de verificação é <b>$verificationCode</b>';
    
    $mail->send();
    echo 'Mensagem enviada com sucesso';
} catch (Exception $e) {
    echo "A mensagem não pôde ser enviada. Erro do Mailer: {$mail->ErrorInfo}";
}