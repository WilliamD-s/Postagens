<?php

class Postagem{
     
    public static function selecionaTodos(){
        
        $con = Connection::getConn();
        $sql = $con->prepare("SELECT * FROM postagem ORDER BY id DESC");
        $res = $sql->execute();

        $resultado = array();

        while($row = $sql->fetchObject('Postagem')){
            $resultado[] = $row;
        }

        if($res == false){
            throw new Exception("Erro ao consultar o banco!");
        }

        return $resultado;
    }

    public static function selecionaPorId($id){
        
        $con = Connection::getConn();
        $sql = $con->prepare("SELECT * FROM postagem WHERE id = :id");
        $sql->bindValue(':id', $id, PDO::PARAM_INT);
        $sql->execute();
        
        $resultado = $sql->fetchObject('Postagem');

        if(!$resultado){
            throw new Exception("Não foi encontrado nenhum registro no banco");
        }else{
            $resultado->comentarios = Comentario::selecionarComentarios($resultado->id);
        }

        return $resultado;

    }

    public static function insert($dadosPost){

        if(empty($dadosPost['titulo']) || empty($dadosPost['conteudo'])){
            throw new Exception("Preencha todos os campos!");
            return false;
        }

        $con = Connection::getConn();
        $sql = $con->prepare("INSERT INTO postagem (titulo,conteudo) VALUES (:titulo,:conteudo)");
        $sql->bindValue(':titulo', $dadosPost['titulo']);
        $sql->bindValue(':conteudo', $dadosPost['conteudo']);
        $res = $sql->execute();

        if($res == false){
            throw new Exception("Falha ao inserir nova postagem");
            return false;
        }
        return true;
    }

    public static function update($dados){
        
        $con = Connection::getConn();
        $sql = $con->prepare("UPDATE postagem SET titulo=:titulo,conteudo=:conteudo WHERE id = :id");
        $sql->bindValue(':id', $dados['id']);
        $sql->bindValue(':titulo', $dados['titulo']);
        $sql->bindValue(':conteudo', $dados['conteudo']);
        $res = $sql->execute();

        if($res == false){
            throw new Exception("Falha ao alterar postagem");
            return false;
        }

        return true;
    }

    public static function delete($id){
        
        if(!isset($id)){
            throw new Exception("Postagem não encontrada!");
            return false;
        }

        $con = Connection::getConn();
        $sql = $con->prepare("DELETE FROM postagem WHERE id = :id");
        $sql->bindValue(':id', $id);
        $res = $sql->execute();
        $sql = $con->prepare("DELETE FROM comentario WHERE id_postagem = :id");
        $sql->bindValue(':id', $id);
        $res = $sql->execute();

        if($res == false){
            throw new Exception("Falha ao deletar postagem");
            return false;
        }

        return true;
    }
}