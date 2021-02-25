<?php

class Comentario{
     
    public static function selecionarComentarios($idPost){
        
        $con = Connection::getConn();
        $sql = $con->prepare("SELECT * FROM comentario WHERE id_postagem= :id ORDER BY id DESC");
        $sql->bindValue(':id', $idPost, PDO::PARAM_INT);
        $sql->execute();

        $resultado = array();

        while($row = $sql->fetchObject('Comentario')){
            $resultado[] = $row;
        }

        return $resultado;
    }

    public static function comentar($dados){
        if(isset($dados['id']) && isset($dados['msg']) && isset($dados['nome'])){
            $con = Connection::getConn();
            $sql = $con->prepare("INSERT INTO comentario (nome,mensagem,id_postagem) VALUES (:nome,:msg,:id)");
            $sql->bindValue(':nome', $dados['nome'], PDO::PARAM_STR);
            $sql->bindValue(':msg', $dados['msg'], PDO::PARAM_STR);
            $sql->bindValue(':id', $dados['id'], PDO::PARAM_INT);
            $res = $sql->execute();

            if($res == false){
                throw new Exception("Erro ao comentar!");
            }
            return true;
        }else{
            throw new Exception("Nome e mensagem obrigatórios para comentar!");
        }
    }

    public static function remover($idcoment){
        if(isset($idcoment)){
            $con = Connection::getConn();
            $sql = $con->prepare("DELETE FROM comentario WHERE id=:id");
            $sql->bindValue(':id', $idcoment, PDO::PARAM_INT);
            $res = $sql->execute();

            if($res == false){
                throw new Exception("Erro ao excluir!");
            }
            return true;
        }else{
            throw new Exception("Parametros inválidos!");
        }
    }
}