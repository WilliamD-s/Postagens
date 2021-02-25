<?php 

class Core{
    
    public function start($urlGet){

        if(!isset($urlGet['pagina'])){            
            header('Location: '.AdminController::route());
        }

        $controller = ucfirst($urlGet['pagina'].'Controller');
        $acao = 'index';
        
        if(isset($urlGet['metodo'])){
            $acao = $urlGet['metodo'];
        }

        if(!class_exists($controller)){
            $controller = 'ErroController';
        }

        if(isset($urlGet['id']) && $urlGet['id'] != null){
            $id = $urlGet['id'];
        }else{
            $id = null;
        }

        call_user_func_array(array(new $controller, $acao),array('id' => $id));

    }
}