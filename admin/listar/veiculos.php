<?php
    if ( !isset ( $page ) ) exit;
?>
<div class="card">
    <div class="card-header">
        <h2 class="float-left">Listar Veículos</h2>
        <div class="float-right">
            <a href="cadastros/veiculos" title="Cadastrar Novo Veículos" class="btn btn-success">
                Cadastrar Veículos
            </a>
        </div>
    </div>
    <div class="card-body">

        <table class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Modelo do Veículos</td>
                    <td>Marca</td>
                    <td>Valor</td>
                    <td>Opções</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    
                    /* ******************************************************* */
                    
                    $sql = "select * from veivulo";


                    /* ******************************************************* */

                    $consultaVeiculos = $pdo->prepare($sql);
                    $consultaVeiculos->execute();

                    while ($dadosVeiculos = $consultaVeiculos->fetch(PDO::FETCH_OBJ)) {

                        /* ******************************************************* */
                        // formatar valor

                        $valor = number_format($dadosProdutos->valor, 2, 
                        ",", ".");

                        /* ******************************************************* */

                        ?>
                        <tr>
                            <td><?=$dadosVeiculos->id?></td>
                            <td><?=$dadosVeiculos->modelo?></td>
                            <td><?=$dadosVeiculos->marca?></td>
                            <td>R$ <?=$valor?></td>
                            <td>
                                <a href="cadastros/veiculos/<?=$dadosVeiculos->id?>"
                                class="btn btn-success">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="javascript:excluir(<?=$dadosVeiculos->id?>)" class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
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
<script>
    $(".table").dataTable();
    function excluir(id) {
        Swal.fire({
            title: 'Você deseja realmente excluir este item?',
            showCancelButton: true,
            confirmButtonText: 'Excluir',
            cancelButtonText: 'Cancelar',
            }).then((result) => {
            if (result.isConfirmed) {
                location.href='excluir/veiculos/'+id;
            } 
        })
    }
</script>