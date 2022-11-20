<?php
    if($_POST){
        $nome          = trim($_POST['nome'] ?? null);
        $email         = trim($_POST['email'] ?? null);
        $senha         = trim($_POST['senha'] ?? null);
        $contraSenha   = trim($_POST['contra_senha'] ?? null);
        $emailValidado = null;

        if(isset($email)){
            if(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
                ?>
            <script>
                alert("Formato de email incorreto!.");
                history.back(); 
            </script>
            <?php
            exit;
            }
        }

        if($senha != $contraSenha){
            ?>
            <script>
                alert("As senhas não são iguais!.");
                history.back(); 
            </script>
            <?php
            exit;
        }

        $sql = "SELECT * FROM usuario WHERE email = :email;";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":email", $email);
        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        if (!empty($dados)){
            ?>
            <script>
                alert("Email já está em uso.");
                history.back(); 
            </script>
            <?php
            exit;
        } 

        $sql = "INSERT INTO usuario (nome, email, senha) VALUES (:nome, :email, :senha);";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":nome", $nome);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":senha", $senha);
        if (!$consulta->execute() ){
            ?>
            <script>
                alert("Falha ao cadastrar novo usuario.");
                history.back(); 
            </script>
            <?php
            exit;
        }else{
            //guardar as informações na sessao
            $_SESSION["usuario"] = array(
            "id"=>$pdo->lastInsertId(),
            "nome"=>$nome,
            "login"=>$email);
            //direcionar para uma página home
            echo "<script>location.href='http://localhost/leilao/admin/';</script>";
            exit;
        }
    }

?>
    
    <div class="row">
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
                <input type="password" name="contra_senha" id="contraSenha"
                class="form-control" required 
                data-parsley-required-message="Por favor preencha este campo">
                <br>
                <button type="submit" class="btn btn-success w-100" >Criar conta</button>
            </form>
        </div>
    </div>
