<?php
    if ( !isset ( $page ) ) exit;
?>
<div class="card">
    <div class="card-header">
        <h2 class="float-left">Listar Clientes</h2>
        <div class="float-right">
            <a href="cadastros/clientes" title="Cadastrar Novo Clientes" class="btn btn-success">
                Cadastrar Clientes
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Nome do Cliente</td>
                    <td>Opções</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    //selecionar todas as categorias
                    $consulta = $pdo->prepare("select * from cliente order by nome");
                    $consulta->execute();

                    while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {
                        ?>
                        <tr>
                            <td><?=$dados->id?></td>
                            <td><?=$dados->nome?></td>
                            <td width="100px">
                                <a href="cadastros/clientes/<?=$dados->id?>" title="Editar Registro" class="btn btn-success">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="javascript:excluir(<?=$dados->id?>)" title="Excluir Dados"
                                class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php
                    } // fim do while
                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(".table").dataTable();
    function excluir(id) {
        alert('Oi... programa eu pra excluir!!!')
    }
</script>