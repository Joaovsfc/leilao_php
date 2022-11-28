<?php
    if ( !isset ( $page ) ) exit;

    $id_usuario = $_SESSION['usuario']['id'];
?>
<div class=row>
    <div class="col-2"></div>
    <div class="card col-8" style="margin-top: 2em;">
        <div class="card-header">
            <h2 class="float-left">Meus Itens</h2>
            <div class="float-right">
                <a href="cadastros/itens" title="Cadastrar Novo Item" class="btn btn-success float-end">
                    Cadastrar Itens
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <td>Código</td>
                        <td>Nome</td>
                        <td>Descrição</td>
                        <td>categoria</td>
                        <td>Função</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        //selecionando todas os itens com suas categorias 
                        $consulta = $pdo->prepare("SELECT i.id_item, i.nome as nome_item, i.descricao as descricao_item, c.nome as nome_categoria FROM item i JOIN categoria c ON i.id_categoria = c.id_categoria WHERE i.id_usuario = :id_usuario ORDER BY i.id_item;");
                        //$consulta = $pdo->prepare("SELECT * FROM `item` a WHERE id_usuario = :id_usuario");
                        $consulta->bindParam(":id_usuario", $id_usuario);
                        $consulta->execute();

                        while ($dados = $consulta->fetch(PDO::FETCH_OBJ)){
                            ?>
                            <tr>
                                <td><?=$dados->id_item?></td>
                                <td><?=$dados->nome_item?></td>
                                <td><?=$dados->descricao_item?></td>
                                <td><?=$dados->nome_categoria?></td>
                                <td>
                                    <a href="cadastros/itens/<?=$dados->id_item?>" title="Editar Item" class="btn float-end">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="javascript:excluir(<?=$dados->id_item?>)" title="Excluir Item" class="btn float-end">
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
<script>
function excluir(id) {
  let text = "Você realmente deseja excluir o item selecionado?";
  console.log('teste')
  if (confirm(text) == true) {
    location.href='excluir/itens/'+id;
  } else {
    alert("Operação cancelada!");
  }
}
</script>