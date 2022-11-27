<?php
    //se nao existir a variavel page
    if ( !isset ($page) ) exit;

    $nome_item = $descricao_item = $id_item = $id_categoria_item = $foto = NULL;

    if ( !empty($id) ) {
        $sql = "SELECT i.*, c.nome AS nome_categoria, img.caminho AS caminho_foto FROM item i JOIN categoria c ON i.id_categoria = c.id_categoria JOIN imagem img ON i.id_item = img.id_item WHERE i.id_item = :id limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        $id_item = $dados->id_item ?? NULL;
        $nome_item = $dados->nome ?? NULL;
        $descricao_item = $dados->descricao ?? NULL;
        $id_categoria_item = $dados->id_categoria ?? NULL;
        $nome_categoria = $dados->nome_categoria ?? NULL;
        $foto = $dados->caminho_foto ?? NULL;
        
    }
?>
<div class="row">
    <div class="col-2"></div>
        <div class="card col-8" style="margin-top: 2em;">
            <div class="card-header">
                <h2 class="float-left">Cadastro de Itens</h2>
                <div class="float-right">
                    <a href="listar/itens" title="Listar Marcas" class="btn btn-success">
                        Listar Itens
                    </a>
                </div>
            </div>
        
        <div class="card-body">
            <form name="formCadastro" method="post" action="http://localhost/leilao/admin/salvar/itens" enctype="multipart/form-data" data-parsley-validate="">
                <div class="row">
                    <div class="col-10">
                        <input type="hidden" name="id" id="id" value="<?=$id?>">
                        <label for="nome">Nome do Item:</label>
                        <input type="text" name="nome" id="nome" class="form-control" required data-parsley-required-message="Por favor, preencha este campo" value="<?=$nome_item?>">
                    </div>
                    <div class="col-2">
                        <br>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Salvar Dados
                        </button>
                    </div>
                </div>
                <br>
                <label for="descricao">Descrição do Item:</label>
                <input type="text" name="descricao" id="descricao" class="form-control" required data-parsley-required-message="Por favor, preencha este campo" value="<?=$descricao_item?>">
                <br>
                <div class="row">
                    <div class="col-6">
                        <label for="categoria">Categoria:</label>
                        <br>
                        <select name="categoria" id="categoria" class="form-select" aria-label="Default select example" required data-parsley-required-message="Por favor, preencha este campo">
                            <?php
                                if (empty($id_item)){
                                    ?>
                                        <option selected value="">Selecione uma Categoria</option>
                                    <?php
                                }else{
                                    ?>
                                        <option name="categoria" value="<?=$id_categoria_item?>"><?=$nome_categoria?></option>
                                    <?php
                                }
                                $consulta = $pdo->prepare("SELECT * FROM categoria;");
                                $consulta->execute();

                                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)){
                                    if($dados->id_categoria != $id_categoria_item){
                                    ?>
                                        <option name="categoria" value="<?=$dados->id_categoria?>"><?=$dados->nome?></option>
                                    <?php   
                                    }
                                }
                            ?>
                        </select>
                        <br>
                        <label for="imagem">Imagem:</label>
                        <br>
                        <input type="file" name="foto" id="foto" value="<?=$foto?>" class="form-control-file"  accept="image/png, image/jpeg">
                    </div>
                    <div class=col-6>
                        <?php
                            if(!empty($foto)){
                                ?>
                                    <img src="../imagens/<?=$foto?>" width="350px">
                                <?php
                            }
                        ?>
                    </div>
                    <input type="hidden" id="caminho_apagar" name="caminho_apagar" value="<?=$foto?>">
                </div>
                
            </form>
        </div>
    </div>
</div>