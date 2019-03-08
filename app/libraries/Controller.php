<?php

/* 
*Controlador Base
*Carrega a model e as views

*/

class Controller{

    //Carregar Model

    public function Model($model){
        require_once('../app/models/'.$model.".php");


        //instanciação da model
        
        return new $model;
    }

    //Carregar a view

    public function View($view,$data = []){
        //Checkar pelo arquivo da view
            if(file_exists('../app/views/'.$view.".php")){
                require_once('../app/views/'.$view.".php");
            }else{
                die('View Não Existe');
            }
    }


}


