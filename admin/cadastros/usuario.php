<?php
    var_dump("teste");
    if (!empty($id) ) {
        $sql = "SELECT * FROM usuario WHERE id_usuario = :id limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        $id_usuario = $dados->id_usuario ?? NULL;
        $nome_usuario = $dados->nome ?? NULL;
        $email_usuario = $dados->email ?? NULL;
    }
?>
<div class="row">
    <div class="col-2"></div>
    <div class="col-8 card" style="margin-top: 2em;">
        <div class="card-header">
            <h2>Cadastro de usuarios</h2>
        </div>
        <form name="formCadastro" method="post" action="salvar/usuario" data-parsley-validate="">
            <input type="hidden" name="id" id="id" value="<?=$id_usuario?>">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" class="form-control" required data-parsley-required-message="Por favor, preencha este campo" value="<?=$nome_item?>">
            <br>
            <label for="nome">Nome:</label>
            <input type="email" name="email" id="email" class="form-control" required data-parsley-required-message="Por favor, preencha este campo" value="<?=$nome_item?>">
            <br>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-check"></i> Salvar Dados
            </button>
        </form>
    </div>
</div>