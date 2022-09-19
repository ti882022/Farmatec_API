<?php
// $host = "localhost"; //indica o nome do servidor MySQL , pode ser pelo IP
// $user = "vito";
// $password = "";
// $database = "bdturma88"; 
// $link = mysqli_connect($host,$user,$password,$database);
// if (!$link) {
//  echo "Erro: Não foi possível connectar ao MySQL." . PHP_EOL ;
//  echo "Número do erro: " . mysqli_connect_errno() . PHP_EOL;
//  echo "Possível erro : " . mysqli_connect_error() . PHP_EOL;
//  exit;
// }
// echo "Sucesso: A conexão com o MySQL foi estabelecida! " . PHP_EOL;
// echo "Informação de seu host: " . mysqli_get_host_info($link) . PHP_EOL;
// mysqli_close($link);

$conexao ="";
$host = "localhost";
$user = "root";
$password = "";
$database = "bdfarmacia";
function connectDB() {
    $GLOBALS['conexao'] = mysqli_connect($GLOBALS['host'], $GLOBALS['user'], $GLOBALS['password'], 
    $GLOBALS['database']);
 if(!$GLOBALS['conexao']){
 printf("Falha de Conexão: %s\n", mysqli_connect_error());
 exit();
}
}
connectDB();
echo $conexao;
echo "<br>";

?>



