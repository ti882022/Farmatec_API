<?php
//Não apresentar tela com erros
//ini_set('display_errors','0');

use LDPA\Result;

require_once("../databases/BdturmaConect.php");
require_once("../config/SimpleRest.php");

$page_key="";
// termo extends pega emprestado o conteudo do arquivo 1 pra o 2
class PedidosResHandler extends SimpleRest{

    public function PedidosIncluir(){

        if(isset($_POST["txtnomecliente"])) {

            $nomecliente=$_POST["txtnomecliente"];
            $canal=$_POST['txtcanal'];
            $forma=$_POST['txtforma'];
            $codfuncionario=$_POST['txtcodfuncionario'];
            $datapgto=$_POST['txtdpgto'];
            $dataenvi=$_POST['txtdenvio'];
            $produto=$_POST['txtproduto'];

            $query="CALL spInserirPedidos(:pnomecliente,:pcanal,:pforma,:pcodigofuncionario,:pdpgto,:pdenvio,:pproduto,@pnumeropedido)";
            $array = array(":pnomecliente"=>"{$nomecliente}",":pcanal"=>"{$canal}",":pforma"=>"{$forma}",":pcodigofuncionario"=>"{$codfuncionario}",":pdpgto"=>"{$datapgto}",":pdenvio"=>"{$dataenvi}",":pproduto"=>"{$produto}");
            $final = "SELECT @pnumeropedido as numeropedido";
            
            $dbcontroller = new BdturmaConect();

            $rawData = $dbcontroller->executeProcedureOut($query,$array,$final);
            
            if(empty($rawData)){
                $statusCode = 404;
                $rawData = array('sucesso' => 0);
            }
            else{
                $statusCode = 200;
            }
            
            $requestContentType = $_POST['HTTP_ACCEPT'];
            $this -> setHttpHeaders($requestContentType, $statusCode);
            $result["RetornoDados"] = $rawData;

            if(strpos($requestContentType,'application/Json') !== false){
                $response = $this->encodeJson($result);
                echo $response;
            }

        }

    }

    public function PedidosConsultar(){
        if(isset($_POST["txtnumpedido"])){

            $numpedido = $_POST["txtnumpedido"];
            $cpf = $_POST["txtcpf"];

        $query="CALL spConsultarPedidos(:npedido,:pcpf)";
        $array = array(":npedido"=>"{$numpedido}",":pcpf"=>"{$cpf}");
            $dbcontroller = new BdturmaConect ();
            $rawData = $dbcontroller->executeProcedure($query,$array);
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

    case "Incluir":
        $Pedidos = new PedidosResHandler();
        $Pedidos -> PedidosIncluir();
        break; 
    case "Consultar":
        $Pedidos = new PedidosResHandler();
        $Pedidos -> PedidosConsultar();
        break;
}

?>