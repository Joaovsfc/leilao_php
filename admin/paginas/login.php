<?php
    //validação dos dados
    if ( $_POST ) {
        
        //recuperar login e senha
        $login = trim( $_POST["login"] ?? NULL );

        $senha = trim ( $_POST["senha"] ?? NULL );

        //validar o login e a senha
        if ((empty($login)) or (empty($senha))) {
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
            where email = :login and senha = :senha
            limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":login", $login);
        $consulta->bindParam(":senha", $senha);
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);
        //verificar se trouxe resultado
        if (empty($dados)){
            ?>
            <script>
                alert("Usuario não existe");
                history.back(); 
            </script>
            <?php
            exit;
        } 
        
        //guardar as informações na sessao
        $_SESSION["usuario"] = array("id"=>$dados->id_usuario,
            "nome"=>$dados->nome,
            "login"=>$dados->email);
        //direcionar para uma página home
        echo "<script>location.href='index.php';</script>";
        exit;
        

    } // fim do POST
    
?>
<div class="row">
    <div class="col-4"></div>
    <div class="col-4 card" style="padding: 1em;margin: 1em">
        <h1 class="text-center">Efetuar Login</h1>
        <form name="formLogin" method="post" data-parsley-validate="">
            <label for="login">Login:</label>
            <input type="text" name="login" id="login"
            class="form-control" required
            data-parsley-required-message="Por favor preencha este campo">
            <br>
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha"
            class="form-control" required 
            data-parsley-required-message="Por favor preencha este campo">
            <span class="float-end"> <a href="javascript:cadUsuario()">Criar uma conta</a></span>
            <button type="submit" class="btn btn-success w-100">Efetuar Login</button>
        </form>
    </div>
</div>
<script>
    function cadUsuario(){
        <?php 
            $_SESSION["usuario"] = array("novo_usuario"=>true);
        ?>
        
    }
</script>