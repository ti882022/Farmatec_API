<!DOCTYPE html>
<html lang="pt-br"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible"content="IE=edge"><meta name="viewport"content="width=device-width, initial-scale=1.0"><title>::: Teste Array:::</title></head><body><?php echo"Teste de Array <br>";

//atribuição de um Array
$array_numeros=array(5, 10, 15, 20, 25);

//Apresentar os dados 
print_r($array_numeros);

echo "<br><br>";

//verificar a quantidade de itens
$qtdeitens=count($array_numeros);

echo "Quantidade de itens da coleção = ".$qtdeitens;

//###################################################################
echo "<br>";
//######################################################################

//Apresentar os dados utilizando estrutura de repetição
//for

//fica validando o valor de $i até se igual ao do $qtdeitens

for($i=0; $i < $qtdeitens; $i++) {
    echo "Indice = ". $i ."  Valor = ".$array_numeros[$i]."<br>";
}

echo "<br>";

//foreache
foreach($array_numeros as $i) {
    echo$i . "<br>";
}

echo "<br>";



$salarios=array();
$salarios ["claudia"]=1000;
$salarios ["João"]=7000;
$salarios ["Luiza"]=12000;

foreach($salarios as $key_arr=> $var_arr) {
    echo $key_arr ." = ".$var_arr . "<br />";
}


//Array Multidimensional
$Produtos=array (array("maçã", 20, 10),
    array("Banana", 10, 15),
    array("Laranja", 15, 7),
    array("Pera", 20, 5));

//For dentro de outro for 
for ($linha=0; $linha < 4; $linha++) {
    echo "<p><b>Linha Número : ". $linha. "<br/></p>";
    echo "<ul>";

    for($coluna=0; $coluna < 3; $coluna++) {
        echo "<li>".$Produtos[$linha][$coluna]."</li>";
    }

    echo "</ul>";
}

//definindo os idices e os valores dos indices do $idade
$idade=array("Marcos"=>"35", "Suzana"=>"37", "Joel"=>"43");

session_start();
//deixa a session com o limite de linhas que vc criar 
session_destroy();

//Se   session não existir , sera criada
if(empty($_SESSION['Lista'])) {
    $_SESSION['Lista']=[];
}

//define o $_SESSION com o valor do $idade

array_push($_SESSION['Lista'], $idade);

$tabela="<table border='1'>
<thead>
    <tr>
            <th>Nome</th>
            <th>Idade</th>
    </tr>
</thead>
<tbody>";

$retorno=$tabela;

print_r($_SESSION['Lista']);

foreach($_SESSION['Lista'] as $linhadoarray) {
    // o foreach esta pegando a variavel e trazendo seu indice e o valor de seu indice 
    foreach($linhadoarray as $key_nome=> $var_idade) {

        $retorno .="<tr>";
        $retorno .="<td>".$key_nome."</td>"."<td>".$var_idade."</td>";
        $retorno .="</tr>";

    }
}

$retorno .="<tr>";
$retorno .="<td> ****** </td>";
$retorno.="<td> *******</td>";
$retorno .="</tr>";

//seleciona as chaves  
$indice = array_keys($idade);
//classifica as chaves em ordem crescente 
rsort($indice);

// "!" usado pra negar 
//faça enquanto 
while (!empty($indice)){

    $retorno .= "<tr>";
    $nomecoluna = array_pop($indice);
    $retorno .= "<td>" .$nomecoluna . "</td>";
    $retorno .= "<td>" .$idade[$nomecoluna]. "</td>";
    $retorno .= "</tr>";
    }

    $indice = array_keys($idade);

    do {

    $retorno .= "<tr>";
    $nomecoluna = array_pop($indice);
    $retorno .= "<td>" .$nomecoluna . "</td>";
    $retorno .= "<td>" .$idade[$nomecoluna]. "</td>";
    $retorno .= "</tr>";
    }


    while (!empty($indice));

    $retorno .= "<tr>";
    $retorno .= "</td> ***** </td>";
    $retorno .= "</td> ***** </td>";
    $retorno .= "</tr>";

    foreach ($indice as $coluna=>$conteudodacoluna){
        $retorno .= "<tr>";
        $retorno .="<td>".$coluna . "</td>";
        $retorno .="<td>".$conteudodacoluna . "</td>";
        $retorno .="</tr>";
      }


$retorno .="</tbody></table>";
echo $retorno;

?></body></html>