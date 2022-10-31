<div>

    <table class="mx-auto">
        <thead>
            <td>ID</td>
            <td>Descricao</td>
        </thead>
    
    <tbody>
    <?php
        $sql = "select * from leilao";
        $consulta = $pdo->prepare($sql);
        $consulta->execute();
        while($dados = $consulta->fetch(PDO::FETCH_OBJ)){
        ?>
            <tr>
                <td><?=$dados->id_leilao?></td>
                <td><?=$dados->descricao?></td>
            </tr>
            
        <?php
        }
    ?>
    </tbody>
    </table>
    

</div>