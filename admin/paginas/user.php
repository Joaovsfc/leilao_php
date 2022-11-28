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
                $consulta = $pdo->prepare("SELECT * FROM leilao WHERE id_ganhador = :id_ganhador");
                $consulta->bindParam(":id_ganhador", $_SESSION['usuario']['id']);    
                $consulta->execute();
                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)){
                    ?>
                        <div class="card">
                            <div class="row">
                                <div class="col-11">
                                    <span>Leilão: <?=$dados->id_leilao?>, <?=$dados->titulo?>, arrematado por: <?=$dados->valor_atual?></span> 
                                </div>
                                <div class="col-1">
                                    <a href="paginas/dialogo/<?=$dados->id_leilao?>" class="btn btn-outline-secondary" ><i class="bi bi-send"></i></a>
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
