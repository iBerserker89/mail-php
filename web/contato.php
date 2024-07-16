<?php
$sucesso = false;

if (isset($_POST['nome'])) {
    $aviso = '';

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $area = $_POST['area'];
    $mensagem = $_POST['mensagem'];

    if (empty($_POST['nome'])) {
        $aviso .= 'Favor preencher o nome.<br>';
    }
    if (empty($_POST['email'])) {
        $aviso .= 'Favor preencher o email.<br>';
    }
    if (empty($_POST['area'])) {
        $aviso .= 'Favor preencher a area.<br>';
    } else {
        if ($area == 'vendas') {
            $email_to = 'lucianof.barros89@gmail.com';
        } elseif ($area == 'suporte') {
            $email_to = 'lucianof.barros89@gmail.com';
        } else {
            $aviso .= 'Área selecionada é inválida';
        }
    }
    if (empty($_POST['mensagem'])) {
        $aviso .= 'Favor preencher a mensagem.<br>';
    }

    if (empty($aviso) && isset($email_to)) {
        $body = '
            <!doctype html>
            <html lang="pt-br">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                <title>Mail</title>
            </head>
            <body>
                Email enviado através do site <br>';
        $body .= date('d/m/X h:m:s') . '<br>';
        $body .= 'Nome: ' . $nome . '<br>';
        $body .= 'Email: ' . $email . '<br>';
        $body .= 'Mensagem: ' . '<br>' . nl2br($mensagem) . '<br>';
        $body .= '</body></html>';

        $email_headers = "Content-type: text/html;charset=utf-8\r\n";
        $email_headers .= "from: " . $email;


        $retorno = mail($email_to, 'Email enviado pelo formulário de contato', $body, $email_headers);

        if ($retorno) {
            $sucesso = true;
            $aviso = 'Email enviado com sucesso!';
        } else {
            $aviso = 'Erro ao enviar ao email';
        }

        $aviso .= '<br><br> <a href="contato.php">Voltar</a>';

        $sucesso = true;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="Content-Type" content="ie=edge">
    <title>Formulário</title>
</head>
<body>
<?php if (!empty($aviso)) : ?>
    <h2><?php print $aviso; ?></h2>
<?php endif; ?>

<?php if (!$sucesso) : ?>
    <form action="contato.php" method="post">
        <label for="nome">Nome:</label>
        <input id="nome" type="text" name="nome" value="<?php if (isset($nome)) {
            echo $nome;
        } ?>"><br>
        <label for="email">Email:</label>
        <input id="email" type="email" name="email" value="<?php if (isset($email)) {
            echo $email;
        } ?>"><br>
        Selecione para quem quer enviar:<br>
        <select name="area">
            <option value="vendas">Vendas</option>
            <option value="suporte">Suporte</option>
        </select><br>
        Mensagem: <br>
        <textarea name="mensagem" cols="30" rows="10"><?php if (isset($mensagem)) {
                echo $mensagem;
            } ?></textarea><br>
        <input type="submit" value="Enviar">
    </form>
<?php endif; ?>
</body>
</html>
