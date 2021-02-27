<?php

class HomeController{
    
    public function index(){

        $loader = new \Twig\Loader\FilesystemLoader('app/View');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('home.html');
        $parametros = array();
        $parametros['link_base'] = AdminController::route();

        try{            
            $colecPostagens = Postagem::selecionaTodos();
            $parametros['postagens'] = $colecPostagens;
            
        }catch(Exception $e){
            echo '<script>alert("'.$e->getMessage().'")</script>';
        }
        $conteudo = $template->render($parametros);
            
        echo $conteudo;
    }
}