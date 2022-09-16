<?php
//Não apresentar tela com erros
//ini_set('display_errors','0');

use LDPA\Result;

require_once("../databases/BdturmaConect.php");
require_once("../config/SimpleRest.php");

$page_key="";
// termo extends pega emprestado o conteudo do arquivo 1 pra o 2
class FuncionariosResHandler extends SimpleRest{
    public function FuncionariosIncluir(){

        if(isset($_POST["txtnomeusuario"])) {

            $nomefuncionario=$_POST["txtnomefuncionario"];
            $sexofuncionario=$_POST["txtsexo"];
            $fonefuncionario=$_POST['txtemailfuncionario'];
            $emailfuncionario=$_POST['txtsenhafuncionario'];

            $query="CALL spInserirFuncionarios(:pnome,:psexo,:pemail,:psenha)";
            $array = array(":pnome"=>"{$nomefuncionario}",,":psexo"=>"{$sexofuncionario}",":pfone"=>"{$fonefuncionario}",":pemail"=>"{$emailfuncionario}");
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

    public function FuncionariosConsultar(){

        if(!empty($_POST["txtnomefuncionario"])){

            $nome = $_POST["txtfuncionario"];
        //Informar a Stored Produre e seus Parâmetros
        $query="CALL spConsultarFuncionarios(:pnome)";
        //Definir o conjunto de dados
        $array = array(":pnome"=>"{$nome}");
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
        $Funcionarios = new FuncionariosResHandler();
        $Funcionarios -> FuncionariosConsultar();
        break;

    case "Incluir":
        //esta passando o conteudo(instanciando) do UsuariosResHandler para o $Usuarios
        $Funcionarios = new FuncionariosResHandler();
        $Funcionarios -> FuncionariosIncluir();
        break;
        

}

?>