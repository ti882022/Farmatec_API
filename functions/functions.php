<?php
//Verificar o dia da semana 
//extraido de :
//http://www.linhadecodigo.com.br/artigo/35665/trabalhando-comfunçoes-em-php.asp

session_start();

if (empty($_SESSION['lista'])){
    $_SESSION['lista'] = [] ;
}

function listar(){
//     echo "Espelho de Array - Apresentação didatica <br>";
//     echo "======================================". "<br>";
//     print_r($_SESSION['lista']);
//     echo "<br><br>";

//     $qtderegistros = count($_SESSION['lista']);
// echo "Quantidade de Registros no Array = ". $qtderegistros;
// echo "<br><br>";

// echo "Tabela com dados  <br>";
// echo "============================================". "<br>";
// echo "<br>";

$tabela = "<table border='1'>
<thead>
   <tr>
        <th>Nome</th>
        <th>cep</th>
        <th>Endereço</th>
        <th>Bairro</th>
        <th>Cidade</th>
        <th>UF</th>
        <th>E-mail</th>
        <th>Telefone</th>
    </tr>
    </thead>
    <tbody>";


$retorno = $tabela;

foreach ($_SESSION['lista'] as $linhadoarray){
    $retorno .="<tr>";
    foreach ($linhadoarray as $coluna=>$conteudodacoluna){
        $retorno .= "<td>" . $conteudodacoluna . "</td>";
       
    }
    $retorno .= "</tr>";
}

$retorno .= "</tbody></table>";
return $retorno;

}






// function dia_atual(){
//     $hoje = getdate();
//     //return $hoje;
//     // print_r($hoje);
//     switch($hoje["wday"]){
//         case 0:
//         return "Domingo";
//         break;
//         case 1:
//             return "Segunda";
//             break;
//             case 2:
//                 return "Terça";
//                 break;
//                 case 3:
//                     return "Quarta";
//                     break;
//                     case 4:
//                         return "Quinta";
//                         break;
//                         case 5:
//                             return "Sexta";
//                             break;
//                             case 6:
//                                 return "Sabado";
//                                 break;

//     }
// }


?>