<?php
    //se nao existir a variavel page
    if ( !isset ($page) ) exit;

    if ( $_POST ) {

        //recuperar os dados enviados
        foreach ( $_POST as $key => $value ) {
            //echo "<p>$key - $value</p>";
            $$key = trim ( $value ?? NULL );
        }

        //pegar os nomes dos arquivos
        $foto = $_FILES["foto"]["name"] ?? NULL;

        //validar os campos
        if ( empty ( $valor ) ) {
            mensagemErro("Preencha o valor");
        } else if ( empty ( $marca_id ) ) {
            mensagemErro("Selecione uma marca");
        } else if ( ( empty ($id) ) and ( empty ($foto) ) ) {
            mensagemErro("Selecione a primeira imagem");
        } 

        if ( !empty ($foto ) ) {
            $foto = time()."_{$foto}";

            //copiar a imagem para o servidor
            if (!move_uploaded_file($_FILES["foto"]["tmp_name"], "../imagens/{$foto}")) {
                mensagemErro("Erro ao copiar arquivo");
            }
        } 
        

        //4.900,90 -> 4900.90
        $valor = str_replace(".","", $valor);
        //4900,00 -> 4900.00
        $valor = str_replace(",",".", $valor);

        //inserir ou atualizar os dados
        if ( empty ( $id ) ) {
            
            /* ******************************************************* */




            /* ******************************************************* */

        } else {

            $sql = "select foto from veiculo
                where id = :id limit 1";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":id", $id);
            $consulta->execute();

            $dados = $consulta->fetch(PDO::FETCH_OBJ);

            if ( empty ( $foto ) ) $foto = $dados->foto;

            $sql = "update veiculo set modelo = :modelo, marca_id = :marca_id, valor = :valor, anomodelo = :anomodelo, anofabricacao = :anofabricacao, cor = :cor, foto = :foto, opcionais = :opcionais where id = :id 
            limit 1";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":modelo", $modelo);
            $consulta->bindParam(":marca_id", $marca_id);
            $consulta->bindParam(":valor", $valor);
            $consulta->bindParam(":anomodelo", $anomodelo);
            $consulta->bindParam(":anofabricacao", $anofabricacao);
            $consulta->bindParam(":cor", $cor);
            $consulta->bindParam(":foto", $foto);
            $consulta->bindParam(":opcionais", $opcionais);
            $consulta->bindParam(":id", $id);

        }

        if ($consulta->execute()) {
            //enviar a tela para a listagem
            echo "<script>location.href='listar/veiculos';</script>";
        } else {
            mensagemErro("Erro ao salvar dados");
        }


    }