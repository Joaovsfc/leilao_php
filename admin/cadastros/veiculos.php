<?php
    if ( !isset ( $page ) ) exit;

    $modelo = $marca_id = $valor = $anomodelo = $anofabricacao = $cor = $foto = $opcionais = NULL;

    if ( !empty($id) ) {
        $sql = "select * from veiculo where id = :id limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);
        $modelo = $dados->modelo;
        $marca_id = $dados->marca_id;
        $valor = $dados->valor;
        $anomodelo = $dados->anomodelo;
        $anofabricacao = $dados->anofabricacao;
        $cor = $dados->cor;
        $foto = $dados->foto;
        $opcionais = $dados->opcionais;

        $valor = number_format($valor,2,',','.');
    }

?>
<div class="card">
    <div class="card-header">
        <h1 class="float-left">Cadastro de Veículos</h1>
        <div class="float-right">
            <a href="listar/veiculos" class="btn btn-success">
                Listar Veículos
            </a>
        </div>
    </div>
    <div class="card-body">
        <form name="formProduto" method="post" action="salvar/veiculos" enctype="multipart/form-data" data-parsley-validate="">
            <label for="id">ID:</label>
            <input type="text" name="id" id="id"
            readonly class="form-control"
            value="<?=$id?>">
            <label for="modelo">Modelo:</label>
            <input type="text" name="modelo" id="modelo"
            required data-parsley-required-message="Por favor preencha este campo" class="form-control" value="<?=$modelo?>">

            <label for="anomodelo">Ano Modelo:</label>
            <input type="text" name="anomodelo" id="anomodelo"
            required data-parsley-required-message="Por favor preencha este campo" class="form-control" value="<?=$anomodelo?>">

            <label for="anofabricacao">Ano Fabricação:</label>
            <input type="text" name="anofabricacao" id="anofabricacao"
            required data-parsley-required-message="Por favor preencha este campo" class="form-control" value="<?=$anofabricacao?>">

            <label for="cor">Cor:</label>
            <input type="text" name="cor" id="cor"
            required data-parsley-required-message="Por favor preencha este campo" class="form-control" value="<?=$cor?>">

            <label for="marca_id">Selecione a Marca:</label>
            <select name="marca_id" id="marca_id" required data-parsley-required-message="Selecione uma marca" class="form-control">
                <option value=""></option>
                <?php
                    $sql = "select id, marca from marca order by marca";
                    $consultaMarca = $pdo->prepare($sql);
                    $consultaMarca->execute();
                    while ( $dadosMarca = $consultaMarca->fetch(PDO::FETCH_OBJ)) {
                        //separar os dados
                        $idMarca = $dadosMarca->id;
                        $nomeMarca = $dadosMarca->marca;
                        
                        echo "<option value='{$idMarca}'>{$nomeMarca}</option>";
                    }
                ?>
            </select>
            <label for="valor">Valor do Veículo:</label>
            <input type="text" name="valor" id="valor"
            required data-parsley-required-message="Preencha o valor" class="form-control valor"
            value="<?=$valor?>">
            <label for="opcionais">Opcionais do Veículo:</label>
            <textarea rows="5" name="opcionais" id="opcionais" required data-parsley-required-message="Preencha a descrição do produto" class="form-control texto"><?=$opcionais?></textarea>
            <label for="foto">Foto:</label>
            <input type="file" name="foto" id="foto" class="form-control-file">

            <?php
                if ( !empty($foto ) ) {
                    ?>
                    <img src="../imagens/<?=$foto?>"
                    width="100px"><br>
                    <?php
                }
            ?>

            <br>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-check"></i>
                Gravar Dados
            </button>
        </form>

        <script>
            $(document).ready(function(){
                $('.valor').maskMoney({thousands:'.', decimal:','});
                $('.texto').summernote({
                    height: 200
                });
                $('#marca_id').val(<?=$marca_id?>);
            })
        </script>
    </div>
</div>