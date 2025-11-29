<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ativação de Conta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .container {
            width: 90%;
            margin: auto;
            padding: 20px;
        }

        .header {
            font-size: 24px;
            color: #333;
        }

        .code-box {
            padding: 10px 20px;
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 24px;
            letter-spacing: 2px;
            text-align: center;
            margin: 20px 0;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="header">Olá, {{ $usuario->getNome() }}!</h2>
        <p>Obrigado por se registrar na plataforma LinkedIF. Use o código abaixo para ativar sua conta:</p>

        <div class="code-box">
            {{ $codigoAtivacao }}
        </div>

        <p>Se você não se registrou, por favor, ignore este e-mail.</p>
        <p>Atenciosamente,<br>Equipe LinkedIF</p>
    </div>
</body>

</html>