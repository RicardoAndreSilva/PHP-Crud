<?php
require_once('../public/connection.php');


//-----------VALIDAÇÂO FORMULÀRIO-----------//
$erro = false;
$sucess= "";
$sucessTrue=false;
if (isset($_POST['btRegister'])) {
    if (empty($_POST['nome']) || empty($_POST['email']) || empty($_POST['telefone']) || empty($_POST['curso'])) {
        $errorEmpty = "Os campos não podem ser vazios!";
        $erro = true;
    }

    //-----------PEGAR O VALOR VINDO DO POST E LIMPAR--------------------------//
    $nome_aluno = removeTags($_POST["nome"]);
    $email_aluno = removeTags($_POST["email"]);
    $telefone_aluno = removeTags($_POST["telefone"]);
    $curso_aluno = removeTags($_POST["curso"]);

    //-----------VERIFICAR SE O CAMPO NOME SÂO DIGITADOS SÒ LETRAS-----------//
    if (!preg_match("/^[a-zA-Z-' ]*$/", $nome_aluno)) {
        $errorNome = "Somente permitido letras e espaços em branco!";
        $erro = true;
    }
    //----------VERIFICAR SE O EMAIL È VALIDO-------------------------------//
    if (!filter_var($email_aluno, FILTER_VALIDATE_EMAIL)) {
        $errorEmail = "E-mail inválido!";
        $erro = true;
    }

    //----------VERIFICAR SE ESTÁ VAZIO O POST NUMERO---------------------//
    if (!is_numeric($_POST['telefone'])) {
        $errorTelefone = "Digite só numeros!";
        $erro = true;
    }

    //------------INSERE NA BASE DE DADOS-------------------------------//
    if (!$erro) {
        $comandoSQL = "INSERT INTO dados_alunos (nome,email,telefone,curso)VALUE('$nome_aluno','$email_aluno','$telefone_aluno','$curso_aluno')";
        $resultado = $pdo->prepare($comandoSQL);
        $resultado->execute();
        $sucess= "Aluno inserido com sucesso";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Registo</title>
</head>

<body class="m-2">
    <header>
        <nav class="navbar navbar-expand-lg bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand text-white" href="#">Navbar</a>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="registo.php">Registar aluno</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="mx-auto" style="width: 500px; margin-top:20vh;">

            <form method="post" action="">
                <p>
                    <label style=" display:block;" for="nome_aluno" class="text-dark fs-5">Nome do aluno:</label>
                    <?php if (isset($errorEmpty)) { ?><span style="color:red;"><?php echo $errorEmpty; ?></span><?php } ?>
                    <input type="text" id="nome" class="form-control w-70 nome" id="nome_aluno" name="nome" placeholder="Digite o seu nome" 
                    <?php if (isset($_POST['nome'])) {echo "value='" . $_POST['nome'] . "'"; } ?>>
                    <?php if (isset($errorNome)) { ?><span style="color:red;" ;><?php echo $errorNome; ?></span><?php } ?>
                </p>
                <p>
                    <label style="display:block;" for="email_aluno" class="text-dark fs-5">Email do aluno:</label>
                    <?php if (isset($errorEmpty)) { ?><span style="color:red;"><?php echo $errorEmpty; ?></span><?php } ?>
                    <input type="email" class="form-control w-70 email" id="email_aluno" name="email" placeholder="Digite o seu emai" 
                    <?php if (isset($_POST['email'])) { echo "value='" . $_POST['email'] . "'"; } ?>>
                    <?php if (isset($errorEmail)) { ?><span style="color:red;" ;><?php echo $errorEmail; ?></span><?php } ?>
                </p>
                <p>

                    <label style="display:block;" for="telefone_aluno" class="text-dark fs-5">Telefone do aluno:</label>
                    <?php if (isset($errorEmpty)) { ?><span style="color:red;"><?php echo $errorEmpty; ?></span><?php } ?>
                    <input type="text" class="form-control w-70 telefone" id="telefone_aluno" name="telefone" placeholder="Digite o seu numero telefone" 
                    <?php if (isset($_POST['telefone'])) {echo "value='" . $_POST['telefone'] . "'";} ?>>
                    <?php if (isset($errorTelefone)) { ?><span style="color:red;" ;><?php echo $errorTelefone; ?></span><?php } ?>
                </p>
                <p>
                    <?php if (isset($errorEmpty)) { ?><span style="color:red" ;><?php echo $errorEmpty; ?></span><?php } ?>
                    <label for="curso_aluno" style="display:block;" class="text-dark fs-5 ">Escolha o curso:</label>
                    <select name="curso" id="curso_aluno" class="form-select w-70 curso">
                        <option value="" >Escolha uma opção</option>
                        <option value="PHP">PHP</option>
                        <option value="CSS">CSS</option>
                        <option value="HTML">HTML</option>
                        <option value="JAVASCRIPT">JAVASCRIPT</option>
                    </select>
                </p>
                <p class="text-center">
                    <input type="submit" class="btn btn-success submit" value="Efectuar registo" name="btRegister">
                </p>
                <span class="text-bg-success text-center w-100 d-block fs text-white"><?php echo $sucess;?></span>
            </form>
        </div>
    </main>
    <footer class=" text-center position-absolute bottom-0 w-100 bg-primary">
        <!-- Copyright -->
        <p class="text-white"> © 2023 Copyright By:Ricardo Silva</p>
        <div class="text-center d-block text-white">
            <a class="text-white  pr-4" href="index.php">Home</a>
            <a class="text-white ml-2" href="registo.php">Registo aluno</a>
        </div>
    </footer>

</body>

</html>