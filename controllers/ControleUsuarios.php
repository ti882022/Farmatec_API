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

        if(isset($_POST["txtnomeusuario"])) {

            $nomeusuario=$_POST["txtnomeusuario"];
            $emailusuario=$_POST['txtemailusuario'];
            $senhausuario=$_POST['txtsenhausuario'];

            $query="CALL spInserirusuarios(:pusuario,:pemail,:psenha)";
            $array = array(":pusuario"=>"{$nomeusuario}",":pemail"=>"{$emailusuario}",":psenha"=>"{$senhausuario}");
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

        if(!empty($_POST["txtnomeusuario"])){

            $nome = $_POST["txtnomeusuario"];
        //Informar a Stored Produre e seus Parâmetros
        $query="CALL spConsultarusuario (:pnomeusuario)";
        //Definir o conjunto de dados
        $array = array(":pnomeusuario"=>"{$nome}");
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

    public function UserValidar(){

        if(!empty($_POST["txtnomeusuario"])){

            $nome = $_POST["txtnomeusuario"];
            $senha = $_POST["txtsenhausuario"];

        //Informar a Stored Produre e seus Parâmetros
        $query="CALL spValidarUsuario (:pNomeUsuario,:pSenhaUsuario)";

        //Definir o conjunto de dados
        $array = array(":pNomeUsuario"=>"{$nome}",":pSenhaUsuario"=>"{$senha}");

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

    public function UserLogout(){

        if(!empty($_POST["txtnomecompleto"])){

            $nome = $_POST["txtnomecompleto"];
            $email = $_POST["txtemailusuario"];

        //Informar a Stored Produre e seus Parâmetros
        $query="CALL spLogoutUsuario (:pnomecompleto,:pemailusuario)";

        //Definir o conjunto de dados
        $array = array(":pnomecompleto"=>"{$nome}",":pemailusuario"=>"{$email}");

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

        if(!empty($_POST["txtnomeusuario"])){

            $nome = $_POST["txtnomeusuario"];
            $email = $_POST["txtemailusuario"];
            $senha = $_POST["txtsenhausuario"];
            $senhanova = $_POST["txtsenhanova"];

        //Informar a Stored Produre e seus Parâmetros
        $query="CALL spTrocaSenha (:pnomeusuario,:pemailusuario,:psenhausuario,:psenhanova)";

        //Definir o conjunto de dados
        $array = array(":pnomeusuario"=>"{$nome}",":pemailusuario"=>"{$email}",":psenhausuario"=>"{$senha}",":psenhanova"=>"{$senhanova}");

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
            $Usuarios -> UserValidar();
            break;

            case "Logout":
                //esta passando o conteudo(instanciando) do UsuariosResHandler para o $Usuarios
                $Usuarios = new UsuariosResHandler();
                $Usuarios -> UserLogout();
                break;

                case "Trocar":
                    //esta passando o conteudo(instanciando) do UsuariosResHandler para o $Usuarios
                    $Usuarios = new UsuariosResHandler();
                    $Usuarios -> TrocaSenha();
                    break;   
        

}






?>