<?php
//Não apresentar tela com erros
//ini_set('display_errors','0');

use LDPA\Result;

require_once("../databases/BdturmaConect.php");
require_once("../config/SimpleRest.php");

$page_key="";
// termo extends pega emprestado o conteudo do arquivo 1 pra o 2
class UsuariosResHandler extends SimpleRest{
    public function UsuariosIncluir(){

        if(isset($_POST["txtnome"])) {

            $nome=$_POST["txtnome"];
            $usuario=$_POST['txtusuario'];
            $senha=$_POST['txtsenha'];
            $email=$_POST['txtemail'];
            $classe=$_POST['txtclasseusuario'];
            $logado=$_POST['txtlogado'];

            $query="CALL spInserirUsuarios(:pnome,:pusuario,:psenha,:pemail,:pclasseusuario,:plogado)";
            $array = array(":pnome"=>"{$nome}",":pusuario"=>"{$usuario}",":psenha"=>"{$senha}",":pemail"=>"{$email}",":pclasseusuario"=>"{$classe}",":plogado"=>"{$logado}");
             //Instanciar a classe BdTurmaConnect
             $dbcontroller = new BdturmaConect();

             $rawData = $dbcontroller->executeProcedure($query,$array);
            
            //Verificar se o retorno esta "vazio"
            if(empty($rawData)){
                $statusCode = 404;
                $rawData = array('sucesso' => 0);
            }
            else{
                $statusCode = 200;
                $rawData = array('sucesso' => 1);
            }
            
            $requestContentType = $_POST['HTTP_ACCEPT'];
            $this -> setHttpHeaders($requestContentType, $statusCode);
            $result["RetornoDados"] = $rawData;

            if(strpos($requestContentType,'application/Json') !==false){
                $response = $this->encodeJson($result);
                echo $response;
            }

        }

    }

    public function UsuarioConsultar(){

        if(!empty($_POST["txtusuario"])){

            $usuario = $_POST["txtusuario"];
        //Informar a Stored Produre e seus Parâmetros
        $query="CALL spConsultarUsuarios(:pusuario)";
        //Definir o conjunto de dados
        $array = array(":pusuario"=>"{$usuario}");
            //Instanciar a classe BdTurmaConect
            $dbcontroller = new BdturmaConect ();
            //Chamar o método
            $rawData = $dbcontroller->executeProcedure($query,$array);
            //Verificar se o retorno está "Vazio"
            if(empty($rawData)){
                $statusCode = 404;
                $rawData = array('sucesso'=> 0);
            }
            else{
                $statusCode = 200;
            }
            $requestContentType = $_POST['HTTP_ACCEPT'];
            $this ->setHttpHeaders($requestContentType, $statusCode);

            $Result["RetornoDados"] = $rawData;

            if(strpos($requestContentType,'application/Json')!== false){
                $response = $this -> encodeJson($Result);
                echo $response;

            }

        }

    }

    public function UsuariosValidar(){

        if(!empty($_POST["txtusuario"])){

            $usuario = $_POST["txtusuario"];
            $senha = $_POST["txtsenha"];

        //Informar a Stored Produre e seus Parâmetros
        $query="CALL spValidarUsuarios(:pusuario,:psenha)";

        //Definir o conjunto de dados
        $array = array(":pusuario"=>"{$usuario}",":psenha"=>"{$senha}");

            //Instanciar a classe BdTurmaConect
            $dbcontroller = new BdturmaConect ();

            //Chamar o método
            $rawData = $dbcontroller->executeProcedure($query,$array);

            //Verificar se o retorno está "Vazio"
            if(empty($rawData)){
                $statusCode = 404;
                $rawData = array('sucesso'=> 0);
            }
            else{
                $statusCode = 200;
            }
            $requestContentType = $_POST['HTTP_ACCEPT'];
            $this ->setHttpHeaders($requestContentType, $statusCode);

            $Result["RetornoDados"] = $rawData;

            if(strpos($requestContentType,'application/Json')!== false){
                $response = $this -> encodeJson($Result);
                echo $response;

            }

        }

    }

    public function UsuariosLogout(){

        if(!empty($_POST["txtnome"])){

            $nome = $_POST["txtnome"];
            $email = $_POST["txtemail"];

        //Informar a Stored Produre e seus Parâmetros
        $query="CALL spDesconectarUsuarios(:pnome,:pemail)";

        //Definir o conjunto de dados
        $array = array(":pnome"=>"{$nome}",":pemail"=>"{$email}");

            //Instanciar a classe BdTurmaConect
            $dbcontroller = new BdturmaConect ();

            //Chamar o método
            $rawData = $dbcontroller->executeProcedure($query,$array);

            //Verificar se o retorno está "Vazio"
            if(empty($rawData)){
                $statusCode = 404;
                $rawData = array('sucesso'=> 0);
            }
            else{
                $statusCode = 200;
            }
            $requestContentType = $_POST['HTTP_ACCEPT'];
            $this ->setHttpHeaders($requestContentType, $statusCode);

            $Result["RetornoDados"] = $rawData;

            if(strpos($requestContentType,'application/Json')!== false){
                $response = $this -> encodeJson($Result);
                echo $response;

            }

        }

    }

    public function TrocaSenha(){

        if(!empty($_POST["txtnome"])){

            $nome = $_POST["txtnome"];
            $email = $_POST["txtemail"];
            $senha = $_POST["txtsenha"];
            $senhanova = $_POST["txtsenhanova"];

        //Informar a Stored Produre e seus Parâmetros
        $query="CALL spTrocarSenha(:pnome,:pemail,:psenha,:psenhanova)";

        //Definir o conjunto de dados
        $array = array(":pnome"=>"{$nome}",":pemail"=>"{$email}",":psenha"=>"{$senha}",":psenhanova"=>"{$senhanova}");

            //Instanciar a classe BdTurmaConect
            $dbcontroller = new BdturmaConect ();

            //Chamar o método
            $rawData = $dbcontroller->executeProcedure($query,$array);

            //Verificar se o retorno está "Vazio"
            if(empty($rawData)){
                $statusCode = 404;
                $rawData = array('sucesso'=> 0);
            }
            else{
                $statusCode = 200;
            }
            $requestContentType = $_POST['HTTP_ACCEPT'];
            $this ->setHttpHeaders($requestContentType, $statusCode);

            $Result["RetornoDados"] = $rawData;

            if(strpos($requestContentType,'application/Json')!== false){
                $response = $this -> encodeJson($Result);
                echo $response;

            }

        }

    }

    

    public function encodeJson($responseData){
        $JsonResponse = json_encode($responseData);
        return $JsonResponse;
    }
}

    
    if(isset($_GET["page_key"])){
        $page_key = $_GET["page_key"];
    }

    else{

    if(isset($_POST["page_key"])){
        $page_key = $_POST["page_key"];
    }
}


if(isset($_POST["btnEnviar"])) {  
    $page_key = "Incluir";
    $_POST['HTTP_ACCEPT'] = "application/Json";
    
 }

 if(isset($_POST["btnListar"])) {  
    $page_key = "Consultar";
    $_POST['HTTP_ACCEPT'] = "application/Json";
 }

switch($page_key){

    case "Consultar":
        //esta passando o conteudo(instanciando) do UsuariosResHandler para o $Usuarios
        $Usuarios = new UsuariosResHandler();
        $Usuarios -> UsuarioConsultar();
        break;

    case "Incluir":
        //esta passando o conteudo(instanciando) do UsuariosResHandler para o $Usuarios
        $Usuarios = new UsuariosResHandler();
        $Usuarios -> UsuariosIncluir();
        break;

        case "Validar":
            //esta passando o conteudo(instanciando) do UsuariosResHandler para o $Usuarios
            $Usuarios = new UsuariosResHandler();
            $Usuarios -> UsuariosValidar();
            break;

            case "Deslogar":
                //esta passando o conteudo(instanciando) do UsuariosResHandler para o $Usuarios
                $Usuarios = new UsuariosResHandler();
                $Usuarios -> UsuariosLogout();
                break;

                case "Trocar":
                    //esta passando o conteudo(instanciando) do UsuariosResHandler para o $Usuarios
                    $Usuarios = new UsuariosResHandler();
                    $Usuarios -> TrocaSenha();
                    break;   
        

}






?>