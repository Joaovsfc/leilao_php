<?php
    if ( !isset ( $page ) ) exit;
?>
<div class="card">
    <div class="card-header">
        <h2 class="float-left">Listar Usuários</h2>
        <div class="float-right">
            <a href="cadastros/usuarios" title="Cadastrar Novo Usuário" class="btn btn-success">
                Cadastrar Usuário
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Nome do Usuário</td>
                    <td>Login do Usuário</td>
                    <td>Ativo</td>
                    <td>Opções</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    //selecionar todas aos usuários
                    $consulta = $pdo->prepare("select * from usuario order by nome");
                    $consulta->execute();

                    while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {
                        ?>
                        <tr>
                            <td><?=$dados->id?></td>
                            <td><?=$dados->nome?></td>
                            <td><?=$dados->login?></td>
                            <td><?=$dados->ativo?></td>
                            <td width="100px">
                                <a href="cadastros/usuarios/<?=$dados->id?>" title="Editar Registro" class="btn btn-success">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="salvar/ativos/<?=$dados->id?>" title="Alterar Ativo"
                                class="btn btn-danger">
                                    <i class="fas fa-eye"></i>
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
        Swal.fire({
            title: 'Você deseja realmente excluir este item?',
            showCancelButton: true,
            confirmButtonText: 'Excluir',
            cancelButtonText: 'Cancelar',
            }).then((result) => {
            if (result.isConfirmed) {
                location.href='excluir/categorias/'+id;
            } 
        })
    }
</script>