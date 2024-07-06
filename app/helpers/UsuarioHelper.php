<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UsuarioHelper {

    public static function isWeakPassword($senha) {
        // Verifica se a senha é inteiramente numérica
        if (ctype_digit($senha)) {
            return true;
        }

        // Verifica se a senha é fraca (menos de 8 caracteres, sem letras maiúsculas, minúsculas, números e caracteres especiais)
        if (strlen($senha) < 8 ||
            !preg_match('/[A-Z]/', $senha) ||
            !preg_match('/[a-z]/', $senha) ||
            !preg_match('/[0-9]/', $senha) ||
            !preg_match('/[\W]/', $senha)) {
            return true;
        }

        return false;
    }
    public function enviarEmail($nomeDest, $emailDest, $subject, $body, $altBody) {
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
            $mail->addAddress($emailDest, $nomeDest); // Adicionar um destinatário

            // Conteúdo do e-mail
            $mail->isHTML(true); // Definir e-mail no formato HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->altBody = $altBody;
            
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}


