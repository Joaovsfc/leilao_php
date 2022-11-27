<?php 
    //iniciar o uso da sessao
    session_start();
    ini_set('display_errors',1);
    ini_set('display_startup_erros',1);
    error_reporting(E_ALL);
    //incluir o arquivo de conexao com o banco
    require "../config.php";

    $pageTotal = substr($_SERVER["REQUEST_URI"], 14, 8);
    //echo $pageTotal;//13-22
    if($pageTotal != 'operacao' ){

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geek Auction</title>
    <base href="<?php echo "http://".$_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"]; ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" />    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/scripts.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    

</head>
<body id="page-top" class="">

<?php
}
    //require "sair.php";
    //verificar se existe login

    
    if (!isset ($_SESSION["usuario"])) {
        //inserir uma tela de login
        require "paginas/login.php";
    } else {
        date_default_timezone_set('America/Sao_Paulo');

        $page = "comercial/leilao";

        if ( isset ( $_GET["param"] ) ) {
            $page = explode("/",$_GET["param"]);
            
            $pasta = $page[0] ?? NULL;
            $pagina = $page[1] ?? NULL;
            $id = $page[2] ?? NULL;

            $page = "{$pasta}/{$pagina}";
        }
        
        
        $page = "{$page}.php";
        //echo substr($page, 0,8);
        if(substr($page, 0,8) != 'operacao' ){
            //adicionar o header
            require "header.php";
            
            if ( file_exists($page) ) {
                require $page;
            } else {
                require "paginas/erro.php";
            }

            require "footer.php";
        }
        

    } 

    if(substr($_SERVER["REQUEST_URI"], 14, 8) != 'operacao' ){
?>
</body>
</html>
<?php
    }else{
       echo '<div></div>';
    }