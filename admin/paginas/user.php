<?php
    if ( !isset ( $page ) ) exit;

?>

<div class="row">
    <div class="col-2"></div>
    <div class="card col-8" style="margin-top: 2em;">
        <div class="card-header">
            <h2 class="float-left">Leilões que ganhei</h2>
        </div>
        <div class="card-body">
            <?php
                $consulta = $pdo->prepare("SELECT l.*,(SELECT u.nome FROM usuario u WHERE u.id_usuario = l.id_usuario) AS nome_ganhador FROM leilao l WHERE l.id_ganhador = :id_ganhador AND l.in_finalizado = 1");
                $consulta->bindParam(":id_ganhador", $_SESSION['usuario']['id']);    
                $consulta->execute();
                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)){
                    ?>
                        <div class="card">
                            <div class="row">
                                <div class="col-11">
                                    <span>Leilão: <?=$dados->id_leilao?>, <?=$dados->titulo?>, arrematado de <?=$dados->nome_ganhador?> valor de:R$ <?=$dados->valor_atual?></span> 
                                </div>
                                <div class="col-1">
                                    <a href="paginas/dialogo/<?=$dados->id_usuario?>" class="btn btn-outline-secondary" ><i class="bi bi-send"></i></a>
                                </div>
                            </div>
                            
                            
                        </div>
                        <br>
                    <?php   
                }
            ?>
        </div>
        <div class="card-header">
            <h2 class="float-left">Meus leilões finalizados</h2>
        </div>
        <div class="card-body">
            <?php
                $consultaMeusLeiloes = $pdo->prepare("SELECT l.*, (SELECT u.nome FROM usuario u WHERE u.id_usuario = l.id_ganhador) AS nome_ganhador FROM leilao l WHERE l.id_usuario = :id_usuario AND l.in_finalizado = 1");
                $consultaMeusLeiloes->bindParam(":id_usuario", $_SESSION['usuario']['id']);    
                $consultaMeusLeiloes->execute();
                while ($dadosMeusLeiloes = $consultaMeusLeiloes->fetch(PDO::FETCH_OBJ)){
                    ?>
                        <div class="card">
                            <div class="row">
                                <div class="col-11">
                                    <span>Leilão: <?=$dadosMeusLeiloes->id_leilao?>, <?=$dadosMeusLeiloes->titulo?>, arrematado por <?=$dadosMeusLeiloes->nome_ganhador?> no valor de:R$ <?=$dadosMeusLeiloes->valor_atual?></span> 
                                </div>
                                <div class="col-1">
                                    <a href="paginas/dialogo/<?=$dadosMeusLeiloes->id_ganhador?>" class="btn btn-outline-secondary" ><i class="bi bi-send"></i></a>
                                </div>
                            </div>
                            
                            
                        </div>
                        <br>
                    <?php   
                }
            ?>
        </div>
    </div>
</div>
