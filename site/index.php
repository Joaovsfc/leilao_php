<?php
    //validação dos dados
    if ( $_POST ) {
        
        //recuperar login e senha
        $email = trim($_POST["email"] ?? NULL );
        $nome = trim($_POST["nome"] ?? NULL );
        $senha = trim($_POST["senha"] ?? NULL );
        $contraSenha = trim($_POST["contraSenha"] ?? NULL );

        //validar o login e a senha
        if ((empty($email)) or (empty($nome) or(empty($senha)) or (empty($contraSenha)))) {
            //mostrar um erro na tela
            ?>
            <script>
                alert("Login e/ou senha sem preencher!");
                history.back(); 
            </script>
            <?php
            exit;
        }       

        //selecionar os dados do banco
        $sql = "select id_usuario, nome, email, senha 
            from usuario
            where email = :login
            limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":login", $email);
        $consulta->execute();

        var_dump('pos select');
        exit;
        $consulta->bindParam(":login", $email);
        $consulta->execute();
        

        $dados = $consulta->fetch(PDO::FETCH_OBJ);
        //verificar se trouxe resultado
        if (!empty($dados)){
            ?>
            <script>
                alert("Email já em uso por outro usuario.");
                history.back(); 
            </script>
            <?php
            exit;
        } 
        
        var_dump('sair');
        exit;
        //guardar as informações na sessao
        $_SESSION["usuario"] = array(
            "id"=>$dados->id_usuario,
            "nome"=>$dados->nome,
            "login"=>$dados->email);
        //direcionar para uma página home
        echo "<script>location.href='index.php';</script>";
        exit;
        

    } // fim do POST
    
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
<body class="row">

    <div class="col-4"></div>
    <div class="col-4 card" style="padding: 1em;margin: 1em">
        <h1 class="text-center">Efetuar Cadastro</h1>
        <form name="formLogin" method="post" data-parsley-validate="">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome"
            class="form-control" required
            data-parsley-required-message="Por favor preencha este campo">
            <br>
            <label for="login">Email:</label>
            <input type="text" name="email" id="email"
            class="form-control" required
            data-parsley-required-message="Por favor preencha este campo">
            <br>
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha"
            class="form-control" required 
            data-parsley-required-message="Por favor preencha este campo">
            <label for="contraSenha">Repita a senha:</label>
            <input type="password" name="contraSenha" id="contraSenha"
            class="form-control" required 
            data-parsley-required-message="Por favor preencha este campo">
            <br>
            <button type="submit" class="btn btn-success w-100" onclick="cadastros/leilao/<?=$dados->id_leilao?>">Criar conta</button>
        </form>
    </div>
    
</body>
</html>