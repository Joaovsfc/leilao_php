<?php
    //função para mostrar a janela de erro
    function mensagemErro($msg) {
        ?>
        <script>
            alert("Eu sou um alert!");
            history.back(); 
        </script>
        <?php
        exit;
    } //fim da função