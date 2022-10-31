<div class="row" style="height: 3em; background-color: rgb(0, 204, 102)">
    <div class="col-10">
            <img src="./images/do-utilizador.png" alt="user_img" style="max-width: 3em; max-height: 3em;"> 
            <span>Bem vindo: </span>
            <spam><?=$_SESSION['usuario']['nome']?></spam>
    </div>
    <div class="col-2" style="padding-top:0.2em">
        <a href="http://localhost/leilao/admin/listar/itens" class="btn btn-secondary">Itens</a> 
        <a href="http://localhost/leilao/admin/listar/leilao" class="btn btn-secondary">Leiloes</a>  
        <a href="http://localhost/leilao/admin/sair.php" class="btn btn-secondary">sair</a>
    </div>

</div>