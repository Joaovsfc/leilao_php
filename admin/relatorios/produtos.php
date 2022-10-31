<?php
    if ( !isset ( $page ) ) exit;
?>
<div class="card">
    <div class="card-header">
        <h2>Relatório de Produtos</h2>
    </div>
    <div class="card-body">
        <form name="formBusca" method="post" action="relatorios/produtos">
            <div class="row d-flex align-items-end">
                <div class="col-12 col-md-4">
                    <label for="valorInicial">Valor Inicial:</label>
                    <input type="text" name="valorInicial"
                    id="valorInicial" class="form-control">
                </div>
                <div class="col-12 col-md-4">
                    <label for="valorFinal">Valor Final:</label>
                    <input type="text" name="valorFinal" id="valorFinal" class="form-control">
                </div>
                <div class="col-12 col-md-4">
                    <button type="button" id="submit" class="btn btn-success w-100">Buscar</button>
                </div>
            </div>
        </form>

        <p class="text-center">Resultados da busca:</p>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Foto</td>
                    <td>Nome do Produto</td>
                    <td>Valor</td>
                    <td>Marca</td>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.form-control').maskMoney({thousands:'.', decimal:','});
    })

    $("#submit").click(function(){
        var valorInicial = $("#valorInicial").val();
        var valorFinal = $("#valorFinal").val();

        $("tbody").html("<tr><td colspan='5' class='text-center'><img src='images/loading.gif'> Aguarde, carregando...</td></tr>");

        $.post("rel-produtos.php",{valorInicial:valorInicial,valorFinal:valorFinal}, function(dados){
            $("tbody").html(dados);
        })
    })
</script>