<?php
//Não Apresentar tela com erros
//ini_set('display_errors','0');

class BdTurmaConect{

    //Declaração das Variaveis puclicas

    public $host = "localhost";  //indica o nome do servidor MySQL , pode ser pelo IP
    public $user = "root";
    public $password = "";
    public $database = "bdfarmacia"; 


    function connectDB() {
        //tratamento de exceções
        try{
            $this -> conn= new PDO ("mysql:host={$this->host};
            dbname={$this->database};charset=utf8",
            $this->user,
            $this->password,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => 
            "SET NAMES utf8"));

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->conn->query('SET NAMES utf8');
        }
        catch(PDOException $e){
            echo "Não foi possivel conectar ao Servidor.\n"."<br>";
            echo "Mensagem:". utf8_encode($e->getMessage())."\n";
        }


    }
    function disconnectDB(){
        $this -> conn = NULL;
    }

        //Metodo para executar intruções usadas nas inserções e modificação dos dados
        function executeQuery($query){
            try{
                $conn = $this->connectDB();
                $resultado = $this->conn->prepare($query);

                if(!$resultado->execute()){
                    $resultado="Não foi Possível executar a instrução";
                }
                else{
                    $resultado= array('Sucesso'=>1);
                }
            }
            catch(PDOException $e){
                die(print_r($e->getMessage()));
            }
            return $resultado;
        }

         //Metodo para executar intruções usadas nas consultas dos dados
         function executeSelectQuery($query){
             try{
                $conn = $this->connectDB();
                $resultado = $this->conn->query($query);
                $resultado ->execute();

                //while será um looping

                while ($linha = $resultado->fetch(PDO::FETCH_ASSOC )){
                    $resultset[] = $linha;
                }
                //Com ! não esta vazio
                if(!empty($resultset)){
                    return $resultset;
                }

             }

            catch(PDOException $e){
                die(print_r($e->getMessage()));
            }

         }
            
         function executeBuscarCodigoQuery($query){
            try{
                $conn = $this->connectDB();
                $resultado = $this->conn->prepare($query);

                if(!$resultado->execute()){
                    $resultado="Não foi Possível executar a instrução";
                }
                else{
                    $linha = $resultado->fetch ();
                    if(!is_null($linha[0])){
                        $resultado= $linha[0]+1;
                    }
                    else{
                        $resultado = 1;
                    }
                }
            }
            catch(PDOException $e){
                die(print_r($e->getMessage()));
            }
            return $resultado;
        }



        function executeProcedureOut($query,$array,$final){
            try{
               $conn = $this->connectDB();
              //prepare para execultar sa stored procedure
               $stmt = $this->conn->prepare($query);

               //passagem de parametro 
               foreach($array as $key =>$value){
                   $stmt->bingVakue($key,$value);
               }

               //executar a stored procedure
               $stmt ->exacute();
            
               //while será um looping

               while ($linha = $stmt->fetch(PDO::FETCH_ASSOC )){
                   $resultset[] = $linha;
               }
              
            }

           catch(PDOException $e){
               die(print_r($e->getMessage()));
           }

           return $resultset;

        }

        function executeProcedure($query,$array){
            try{
               $conn = $this->connectDB();
              //prepare para execultar sa stored procedure
               $stmt = $this->conn->prepare($query);

               //passagem de parametro 
               foreach($array as $key =>$value){
                   $stmt->bindValue($key,$value);
               }

               //executar a stored procedure
               $stmt ->execute();
            
               //while será um looping

               while ($linha = $stmt->fetch(PDO::FETCH_ASSOC )){
                   $resultset[] = $linha;
               }
              
            }

           catch(PDOException $e){
               die(print_r($e->getMessage()));
           }

           return $resultset;

        }


     
}



?>