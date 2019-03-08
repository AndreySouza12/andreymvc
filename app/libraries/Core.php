<?php

 /*Classe Core
 *Criar Url & carrega controlador core
 * Formato da url - /controller/method/params
  */

    class   Core{
        protected $controladorAtual = 'Pages';
        protected $metodoAtual = 'index';
        protected $params = [];

        public function __construct(){
            // print_r($this->obterUrl());
            $url = $this->obterUrl();

            //Olhar no controlador pelo primeiro valor

            if(file_exists('../app/controllers/'.ucwords($url[0]).".php")){
                //Se existe
                $this->controladorAtual = ucwords($url[0]);
              
                //
                unset($url[0]);
            }

            //incluir o controlador
            require_once('../app/controllers/'.$this->controladorAtual.".php");

            //instanciando o controlador
            $this->controladorAtual = new $this->controladorAtual;


            //Checkar pelo segundo parte da url

            if(isset($url[1])){
                //verificar se método existe
                if(method_exists($this->controladorAtual,$url[1])){
                    $this->metodoAtual = $url[1];
                    unset($url[1]);
                }
            }


            $this->params = $url ? array_values($url) : [];

            //Callback com array de parâmetros

            call_user_func_array([$this->controladorAtual,$this->metodoAtual],$this->params);

        }


        public function obterUrl(){
            if(isset($_GET['url'])){
               $url = rtrim($_GET['url'],'/');
               $url = filter_var($url,FILTER_SANITIZE_URL);
               $url = explode('/',$url);
               return $url;
          }else{
                $_GET['url'] = "/";
            }
        }
    }


?>