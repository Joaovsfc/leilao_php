<div class="row" style="height: 3em;background-color: rgb(0, 204, 102)">
    <div class="col-5 padding:0">
        <a href="paginas/user">
            <img src="./images/do-utilizador.png" alt="user_img" style="max-width: 3em; max-height: 3em;"> 
        </a>
        <span>Bem vindo: </span>
        <spam><?=$_SESSION['usuario']['nome']?> id: <?=$_SESSION['usuario']['id']?></spam>
    </div>
    <div class="col-2 text-center" style="padding: 0.2em 0 0 0;">
        <a href="" class="btn btn-primary">Listar Leilões</a>
    </div><div class="col-3">
    </div>
    <div class="float-right col-2" style="padding: 0.2em 0 0 0">
        <a href="listar/itens" class="btn btn-secondary">Itens</a> 
        <a href="http://localhost/leilao/admin/listar/leilao" class="btn btn-secondary">Leiloes</a>  
        <a href="sair.php" class="btn btn-secondary">sair</a>
    </div>

</div>