<?php
//Não apresentar tela com erros
//ini_set('display_errors','0');

use LDPA\Result;

require_once("../databases/BdturmaConect.php");
require_once("../config/SimpleRest.php");

$page_key="";
// termo extends pega emprestado o conteudo do arquivo 1 pra o 2
class FornecedoresResHandler extends SimpleRest{

    public function FornecedoresIncluir(){

        if(isset($_POST["txtnomeFornecedor"])) {

            $nomeFornecedor=$_POST["txtnomeFornecedor"];
            $endereco=$_POST["txtendereco"];
            $cep=$_POST["txtcep"];
            $cidade=$_POST["txtcidade"];
            $bairro=$_POST["txtbairro"];
            $uf=$_POST["txtuf"];
            $cnpj=$_POST["txtcnpj"];
            $foneFornecedor=$_POST['txtfoneFornecedor'];
            $emailFornecedor=$_POST['txtemailFornecedor'];

            $query="CALL spInserirFornecedores(:pnome,:pendereco,:pcep,:pcidade,:pbairro,:puf,:pcnpj,:pfone,:pemail)";
            $array = array(":pnome"=>"{$nomeFornecedor}",":pendereco"=>"{$endereco}",":pcep"=>"{$cep}",":pcidade"=>"{$cidade}",":pbairro"=>"{$bairro}",":puf"=>"{$uf}",":pcnpj"=>"{$cnpj}",":pfone"=>"{$foneFornecedor}",":pemail"=>"{$emailFornecedor}");
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

    public function FornecedoresConsultar(){

        if(isset($_POST["txtnomeFornecedor"])){

            $nome = $_POST["txtnomeFornecedor"];
        //Informar a Stored Produre e seus Parâmetros
        $query="CALL spConsultarFornecedores(:pnome)";
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
        $Fornecedores = new FornecedoresResHandler();
        $Fornecedores -> FornecedoresConsultar();
        break;

    case "Incluir":
        $Fornecedores = new FornecedoresResHandler();
        $Fornecedores -> FornecedoresIncluir();
        break;
}

?>