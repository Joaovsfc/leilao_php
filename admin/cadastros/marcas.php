<?php
    //se nao existir a variavel page
    if ( !isset ($page) ) exit;

    $marca = NULL;

    if ( !empty($id) ) {
        $sql = "select * from marca where id = :id limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        $id = $dados->id ?? NULL;
        $marca = $dados->marca ?? NULL;
    }
?>
<div class="card">
    <div class="card-header">
        <h2 class="float-left">Cadastro de Marcas</h2>

        <div class="float-right">
            <a href="listar/marcas" title="Listar Marcas" class="btn btn-success">
                Listar Marcas
            </a>
        </div>
    </div>
    <div class="card-body">
        <form name="formCadastro" method="post" action="salvar/marcas" data-parsley-validate="">
            <label for="id">ID da Marca:</label>
            <input type="text" readonly name="id" id="id" class="form-control" value="<?=$id?>">
            <label for="marca">Nome da Marca:</label>
            <input type="text" name="marca" id="marca" class="form-control" required data-parsley-required-message="Por favor, preencha este campo" value="<?=$marca?>">
            <br>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-check"></i> Salvar Dados
            </button>
        </form>
    </div>
</div>