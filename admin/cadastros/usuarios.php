<?php
    if ( !isset ( $page ) ) exit;

    $nome = $login = $ativo = $email = NULL;

    if ( !empty ( $id ) ) {

        $sql = "select * from usuario
        where id = :id limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        $nome = $dados->nome;
        $login = $dados->login;
        $email = $dados->email;
        $ativo = $dados->ativo;
    }
?>
<div class="card">
    <div class="card-header">
        <h2 class="float-left">Cadastro de Usuários</h2>

        <div class="float-right">
            <a href="listar/usuarios" title="Listar Usuários" class="btn btn-success">
                Listar Usuários
            </a>
        </div>
    </div>
    <div class="card-body">
        <form name="formCadastro" method="post" action="salvar/usuarios" data-parsley-validate="">
            <label for="id">ID:</label>
            <input type="text" readonly name="id" id="id" class="form-control" value="<?=$id?>">
            
            <label for="nome">Nome do Usuário:</label>
            <input type="text" name="nome" id="nome"
            class="form-control" required data-parsley-required-message="Preencha este campo"
            value="<?=$nome?>" autocomplete="off">

            <label for="login">Login do Usuário:</label>
            <input type="text" name="login" id="login"
            class="form-control" required
            data-parsley-required-message="Preencha este campo"
            value="<?=$login?>" autocomplete="off">

            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email"
            class="form-control" required
            data-parsley-required-message="Preencha este campo"
            data-parsley-type-message="Digite um e-mail válido"
            value="<?=$email?>" autocomplete="off">

            <label for="senha">Digite a sua senha:</label>
            <input type="password" name="senha" id="senha"
            class="form-control">

            <label for="senha2">Redigite a senha:</label>
            <input type="password" name="senha2" id="senha2"
            class="form-control">

            <label for="ativo">Ativo:</label>
            <select name="ativo" id="ativo" class="form-control"
            required data-parsley-required-message="Selecione uma opção">
                <option value=""></option>
                <option value="S">Sim</option>
                <option value="N">Não</option>
            </select>

            <br>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-check"></i> Salvar Dados
            </button>
        </form>
    </div>
</div>
<script>
    //selecionar o campo ativo
    $("#ativo").val("<?=$ativo?>");
</script>