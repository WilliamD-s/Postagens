<?php

class AdminController{

    public static function route($index = ""){
        $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        if(strpos($link,"?pagina=") == false){
            $link .= "?pagina=home";
        }else{        
            $link = substr($link,0,strpos($link,"?pagina=")+8);
        }
        $link .= $index;
        return $link;
    }
    
    public function index(){
        
        $parametros = array();
        try{
            $loader = new \Twig\Loader\FilesystemLoader('app/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('admin.html');

            $postagens = Postagem::selecionaTodos();
            $parametros['postagens'] = $postagens;
            $parametros['link_base'] = AdminController::route();
        
        }catch(Exception $e){
            echo '<script>alert("'.$e->getMessage().'")</script>';
        }
            
        $conteudo = $template->render($parametros);
        echo $conteudo; 
    }

    public function create(){

        $loader = new \Twig\Loader\FilesystemLoader('app/View');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('create.html');

        $parametros = array();
        $parametros['link_base'] = AdminController::route();
        
        $conteudo = $template->render($parametros);
        echo $conteudo;
    }

    public function insert(){

        try{
            Postagem::insert($_POST);
            echo '<script>alert("Publicação inserida com sucesso!")</script>';   
            echo '<script>location.href = "'.AdminController::route("admin&metodo=index").'"</script>';
        }catch(Exception $e){
            echo '<script>alert("'.$e->getMessage().'")</script>';    
            echo '<script>location.href = "'.AdminController::route("admin&metodo=create").'"</script>';
        }
    }

    public function delete($paramId){
        try{
            Postagem::delete($paramId);
            echo '<script>alert("Publicação deletada com sucesso!")</script>';   
            echo '<script>location.href ="'.AdminController::route("admin&metodo=index").'"</script>';
        }catch(Exception $e){
            echo '<script>alert("'.$e->getMessage().'")</script>';    
            echo '<script>location.href ="'.AdminController::route("admin&metodo=index").'"</script>';
        }
    }

    public function update(){
        try{
            Postagem::update($_POST);
            echo '<script>alert("Publicação alterada com sucesso!")</script>';   
            echo '<script>location.href ="'.AdminController::route("admin&metodo=index").'"</script>';
        }catch(Exception $e){
            echo '<script>alert("'.$e->getMessage().'")</script>';    
            echo '<script>location.href ="'.AdminController::route("admin&metodo=modify&id=".$_POST['id']).'"</script>';
        }
    }

    public function modify($paramId){

        $loader = new \Twig\Loader\FilesystemLoader('app/View');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('modify.html');

        $postagem = Postagem::selecionaPorId($paramId);

        $parametros = array();
        $parametros['link_base'] = AdminController::route();
        $parametros['id'] = $postagem->id;
        $parametros['titulo'] = $postagem->titulo;
        $parametros['conteudo'] = $postagem->conteudo;

        $conteudo = $template->render($parametros);
        echo $conteudo;
    }
}