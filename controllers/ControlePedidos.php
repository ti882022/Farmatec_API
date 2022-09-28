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

        if(isset($_POST["txtnome"])) {

            $nome=$_POST["txtnomecliente"];
            $canal=$_POST['txtcanal'];
            $forma=$_POST['txtforma'];
            $codfuncionario=$_POST['txtcodfuncionario'];
            $produto=$_POST['txtproduto'];

            $query="CALL spInserirPedidos(:pnome,:pcanal,:pforma,:pcodigofuncionario,:pproduto,@pnumeropedido)";
            $array = array(":pnome"=>"{$nome}",":pcanal"=>"{$canal}",":pforma"=>"{$forma}",":pcodigofuncionario"=>"{$codfuncionario}",":pproduto"=>"{$produto}");
            $final = "SELECT @pnumeropedido as numeropedido";
            //Instanciar a classe BdTurmaConnect
             $dbcontroller = new BdturmaConect();

             $rawData = $dbcontroller->executeProcedureOut($query,$array,$final);
            
            //Verificar se o retorno esta "vazio"
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

            if(strpos($requestContentType,'application/Json') !==false){
                $response = $this->encodeJson($result);
                echo $response;
            }

        }

    }

    public function PedidosConsultar(){
        if(!empty($_POST["txtnumpedido"])){

            $numpedido = $_POST["txtnumpedido"];
            $cpf = $_POST["txtcpf"];

        $query="CALL spConsultarUsuarios(:npedido,:pcpf)";
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
        //esta passando o conteudo(instanciando) do PedidosResHandler para o $Usuarios
        $Pedidos = new PedidosResHandler();
        $Pedidos -> PedidosIncluir();
        break; 
    case "Consultar":
        //esta passando o conteudo(instanciando) do UsuariosResHandler para o $Usuarios
        $Usuarios = new UsuariosResHandler();
        $Usuarios -> UsuarioConsultar();
        break;  

}






?>