<?php

//-------------------CONST-CONNECTION-DATABASE----------------------------//
define('MYSQL_SERVER', 'LOCALHOST');
define('MYSQL_DATABASE', 'registo_alunos');
define('MYSQL_USERS', 'root');
define('MYSQL_PASS', '');
define('MYSQL_CHARSET', 'utf8');


//------------------CONNECTION-DATABASE------------------------------//
try {
    $pdo = new PDO("mysql:host=" . MYSQL_SERVER . ";" . "dbname=" . MYSQL_DATABASE . ";" . "charset=" . MYSQL_CHARSET, MYSQL_USERS, MYSQL_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "sucess";
} catch (PDOException $error) {
    //echo"Erro na coneção AO banco de dados".$error->getCode()."".$error->getMessage();
}

//---------------FUNÇÃO PARA SANITIZAR (SQL INJECTION)-------------------//
function removeTags($value){
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    return $value;
}
?>
