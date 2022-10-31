<?php
    if ( !isset ( $page ) ) exit;

?>
<div class=row>
    <div class="col-2"></div>
    <div class="card col-8" style="margin-top: 2em;height: 600px;">
        <div class="card-header">
            <h2 class="float-left">Meus Leilões</h2>
            <div class="float-right">
                <a href="cadastros/leilao" title="Cadastrar Novo Item" class="btn btn-success float-end">
                    Cadastrar Leilão
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <td>Titulo</td>
                        <td>Descrição</td>
                        <td>Inicio</td>
                        <td>Fim</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        //selecionando todas os itens com suas categorias 
                        $consulta = $pdo->prepare("SELECT a.id_leilao, a.titulo, a.descricao, a.dt_fim, a.dt_inicio FROM `leilao` a ORDER BY a.id_leilao");
                        $consulta->execute();

                        while ($dados = $consulta->fetch(PDO::FETCH_OBJ)){
                            ?>
                            <tr>
                                <td><?=$dados->titulo?></td>
                                <td><?=$dados->descricao?></td>
                                <td><?=$dados->dt_inicio?></td>
                                <td><?=$dados->dt_fim?></td>
                                <td>
                                    <a href="cadastros/leilao/<?=$dados->id_item?>" title="Editar Item" class="btn float-end">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="cadastros/leilao" title="Excluir Item" class="btn float-end">
                                        <i class="bi bi-trash3"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php   
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>