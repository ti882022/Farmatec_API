<?php
//Não apresentar tela com erros
//ini_set('display_errors','0');

use LDPA\Result;

require_once("../databases/BdturmaConect.php");
require_once("../config/SimpleRest.php");

$page_key="";
// termo extends pega emprestado o conteudo do arquivo 1 pra o 2
class ClientesResHandler extends SimpleRest{
    public function ClientesIncluir(){

        if(isset($_POST["txtnomeCliente"])) {

            $nomeCliente=$_POST["txtnomeCliente"];
            $endereco=$_POST["txtendereco"];
            $cep=$_POST["txtcep"];
            $cidade=$_POST["txtcidade"];
            $bairro=$_POST["txtbairro"];
            $uf=$_POST["txtuf"];
            $cpf=$_POST["txtcpf"];
            $foneCliente=$_POST['txtfoneCliente'];
            $emailCliente=$_POST['txtemailCliente'];

            $query="CALL spInserirClientes(:pnome,:pendereco,:pcep,:pcidade,:pbairro,:puf,:pcpf,:pfone,:pemail)";
            $array = array(":pnome"=>"{$nomeCliente}",":pendereco"=>"{$endereco}",":pcep"=>"{$cep}",":pcidade"=>"{$cidade}",":pbairro"=>"{$bairro}",":puf"=>"{$uf}",":pcpf"=>"{$cpf}",":pfone"=>"{$foneCliente}",":pemail"=>"{$emailCliente}");
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

    public function ClientesConsultar(){

        if(!empty($_POST["txtnomeCliente"])){

            $nome = $_POST["txtnomeCliente"];
            $cpf = $_POST["txtcpfCliente"];
        //Informar a Stored Produre e seus Parâmetros
        $query="CALL spConsultarClientes(:pnome,:pcpf)";
        //Definir o conjunto de dados
        $array = array(":pnome"=>"{$nome}",":pcpf"=>"{$cpf}");
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
        $Clientes = new ClientesResHandler();
        $Clientes -> ClientesConsultar();
        break;

    case "Incluir":
        //esta passando o conteudo(instanciando) do UsuariosResHandler para o $Usuarios
        $Clientes = new ClientesResHandler();
        $Clientes -> ClientesIncluir();
        break;
}

?>