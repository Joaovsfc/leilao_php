<?php
    //se nao existir a variavel page
    if ( !isset ($page) ) exit;

    $nome = NULL;

    if ( !empty($id) ) {

        /* ******************************************************* */

        $sql = "";

        /* ******************************************************* */
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        $id = $dados->id ?? NULL;
        $nome = $dados->nome ?? NULL;
    }
?>
<div class="card">
    <div class="card-header">
        <h2 class="float-left">Cadastro de Clientes</h2>

        <div class="float-right">
            <a href="listar/clientes" title="Listar Clientes" class="btn btn-success">
                Listar Clientes
            </a>
        </div>
    </div>
    <div class="card-body">
        <form name="formCadastro" method="post" action="salvar/clientes" data-parsley-validate="">
            <label for="id">ID:</label>
            <input type="text" readonly name="id" id="id" class="form-control" value="<?=$id?>">
            <label for="nome">Nome do Cliente:</label>
            <input type="text" name="nome" id="nome" class="form-control" required data-parsley-required-message="Por favor, preencha este campo" value="<?=$nome?>">
            <br>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-check"></i> Salvar Dados
            </button>
        </form>
    </div>
</div>