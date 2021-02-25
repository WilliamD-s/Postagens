<?php

class HomeController{
    
    public function index(){

        try{            
            $colecPostagens = Postagem::selecionaTodos();

            $loader = new \Twig\Loader\FilesystemLoader('app/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('home.html');

            $parametros = array();
            $parametros['link_base'] = AdminController::route();
            $parametros['postagens'] = $colecPostagens;
            
            $conteudo = $template->render($parametros);
            
            echo $conteudo;
            
        }catch(Exception $e){
            echo '<script>alert("'.$e->getMessage().'")</script>';
        }
    }
}