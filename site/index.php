<?php
    //iniciar o uso da sessao
    session_start();
    ini_set('display_errors',1);
    ini_set('display_startup_erros',1);
    error_reporting(E_ALL);
    //incluir o arquivo de conexao com o banco
    require "../config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <base href="<?php echo "http://".$_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"]; ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" />    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="js/scripts.js"></script>

</head>
<body>
<?php
    if(!isset($_SESSION["usuario"])) {
        //inserir uma tela de login
        require "paginas/cadLogin.php";
    }
?>
    
</body>
</html>