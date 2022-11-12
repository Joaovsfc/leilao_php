<?php
    //se nao existir a variavel page
    if ( !isset ($page) ) exit;

    $titulo_leilao = NULL;
    $descricao_leilao = NULL;
    $dt_inicio = NULL;
    $dt_fim = NULL;
    $is_arremate = NULL;
    $step = NULL;
    $valor_arremate = NULL;
    $valor_inicial = NULL;

    if ( !empty($id) ) {
        $sql = "select * from leilao where id_leilao = :id limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        $id = $dados->id_leilao ?? NULL;
        $titulo_leilao = $dados->titulo ?? NULL;
        $descricao_leilao = $dados->descricao ?? NULL;
        $dt_inicio = $dados->dt_inicio ?? NULL;
        $dt_fim = $dados->dt_fim ?? NULL;
        $is_arremate = $dados->is_arremate ?? NULL;
        $step = $dados->step ?? NULL;
        $valor_arremate = $dados->valor_arremate ?? NULL;
        $valor_inicial = $dados->valor_inicial ?? NULL;

        $dt_inicio != NULL ? $dt_inicio = str_replace(" ", "T",$dt_inicio): NULL;
        $dt_fim    != NULL ? $dt_fim = str_replace(" ", "T",$dt_fim): NULL;
        $is_arremate != NULL ? $is_arremate = "checked" : $is_arremate = "";
    }
?>
<div class="row">
    <div class="col-2"></div>
        <div class="card col-8" style="margin-top: 2em;">
            <div class="card-header">
                <h2 class="float-left">Cadastro de Leilões</h2>
                <div class="float-right">
                    <a href="listar/leilao" title="Listar Leilões" class="btn btn-success">
                        Listar Leilões
                    </a>
                </div>
            </div>
        
        <div class="card-body">
            <form name="formCadastro" method="post" action="" data-parsley-validate="">
                <input type="hidden" name="id" id="id" value="<?=$id?>">
                <label for="titulo">Titulo do Leilão:</label>
                <div class="row">
                    <div class="col-10"> 
                        <input type="text" name="titulo" id="titulo" class="form-control" required data-parsley-required-message="Por favor, preencha este campo" value="<?=$titulo_leilao?>">
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Salvar Dados
                        </button>
                    </div>
                </div>
                <br>
                <label for="descricao">Descrição:</label>
                <br>
                <textarea name="descricao" id="descricao" cols="103" rows="3" class="form-control" required data-parsley-required-message="Por favor, preencha este campo" ><?=$descricao_leilao?></textarea>
                <br>
                <div class="row">
                    <div class="col-6" >
                        <label for="arremate">Aceita arremate:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" onchange="validaDigitacaoArremate()" value="1" aria-label="Checkbox for following text input" id="arremate" name="arremate" <?php echo $is_arremate; ?>>
                            </div>
                            <input type="number" class="form-control" aria-label="Text input with checkbox" id="valorArremate" name="valorArremate" placeholder="valor do arremate R$" min="1" value="<?=$valor_arremate?>" readonly>
                        </div>
                    </div>
                    <div class="col-3">
                        <label for="arremate">Incremento minimo:</label>
                        <input type="number" class="form-control" aria-label="Text input with checkbox" id="incremento" name="incremento" placeholder="R$" min="1" required data-parsley-required-message="Por favor, preencha este campo" value="<?=$step?>">
                    </div>
                    <div class="col-3">
                        <label for="arremate">Valor inicial:</label>
                        <input type="number" class="form-control" aria-label="Text input with checkbox" id="valorInicial" name="valorInicial" placeholder="R$" min="1" required data-parsley-required-message="Por favor, preencha este campo" value="<?=$valor_inicial?>">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-6">
                        <label for="meeting-time">Data de inicio do leilão:</label>
                        <input type="datetime-local" id="dtInicio" name="dtInicio" value="<?=$dt_inicio?>" min="" max="" required data-parsley-required-message="Por favor, preencha este campo">
                    </div>
                    <div class="col-6">
                        <label for="meeting-time">Data de finalização do leilão:</label>
                        <input type="datetime-local" id="dtFim" name="dtFim" value="<?=$dt_fim?>" min="" max="" required data-parsley-required-message="Por favor, preencha este campo">
                    </div>
                </div>
                <br>
                <span>Seus produtos disponiveis:</span>
                <?php
                        $consulta = $pdo->prepare("SELECT * FROM `item` a WHERE a.id_item not in(SELECT b.id_item FROM leilao_itens b);");
                        $consulta->execute();

                        while ($dados = $consulta->fetch(PDO::FETCH_OBJ)){
                            ?>
                            <div class="input-group mb-3">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input" id="<?=$dados->id_item?>" name="arremate<?=$dados->id_item?>">
                                </div>
                                <label for="">  </label>
                                <span><?=$dados->id_item?>: <?=$dados->nome?></span>
                            </div>
                            <?php   
                        }
                    ?>
            </form>
        </div>
    </div>
</div>
