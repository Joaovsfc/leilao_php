<div class="row" style="height: 3em;background-color: rgb(0, 204, 102)">
    <div class="col-10 padding:0">
        <a href="">
            <img src="./images/do-utilizador.png" alt="user_img" style="max-width: 3em; max-height: 3em;"> 
        </a>
        <span>Bem vindo: </span>
        <spam><?=$_SESSION['usuario']['nome']?> id: <?=$_SESSION['usuario']['id']?></spam>
    </div>
    <div class="float-right col-2" style="padding: 0.2em 0 0 0">
        <a href="http://localhost/leilao/admin/listar/itens" class="btn btn-secondary">Itens</a> 
        <a href="http://localhost/leilao/admin/listar/leilao" class="btn btn-secondary">Leiloes</a>  
        <a href="http://localhost/leilao/admin/sair.php" class="btn btn-secondary">sair</a>
    </div>

</div>