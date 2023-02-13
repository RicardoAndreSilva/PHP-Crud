<?php
require('../public/connection.php');

//------Pesquisar na base de dados-----//
$register_details = "";
$result_error = "";

if (isset($_POST['btSubmit'])) {

    if (!empty($_POST['pesquisa'])) {
        $search = $_POST['pesquisa'];
        $query = $pdo->prepare("SELECT * FROM dados_alunos WHERE nome like '%$search%'");
        $query->execute();
        $register_details = $query->fetchAll();
    } else {
        $result_error = "Por favor entroduza um nome";
    }
}

//--------------Apagar registo aluno-------------//
if (!empty($_GET["apagar"])) {
    $delete = $_GET["apagar"];
    $sqlDelete = $pdo->prepare("DELETE FROM dados_alunos WHERE id=$delete");
    $sqlDelete->execute();
} else {
    //echo "aluno nao eliminado";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Alunos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body class="m-2 min-vh-100 position-relative">
    <nav class="navbar navbar-expand-lg bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="index.php">Navbar</a>
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

    <!--search-->
    <div class="mx-auto" style="width: 700px; margin-top:20vh;">
        <h2 class="d-block">Procurar dados do aluno pelo nome!</h2>
        <form method="post" class="d-flex mt-5 " d-flex role="search">
            <input class="form-control   " type="search" placeholder="Search" name="pesquisa" aria-label="Search">
            <input type="submit" class="btn btn-success w-25 mx-3 text-center" name="btSubmit" value="pesquisar">
        </form>
        <span class="text-center fs-5 text-danger animate__animated animate__backInLeft"><?php echo $result_error; ?></span>

    </div>



    <?php
    if ($register_details) {
        //---Imprime os dados de pesquisa do formulario---//
    ?>
        <p class="text-white bg-success w-100 text-center p-2 mt-5 fs-4">Registo encontrados</p>
        <table class="table mt-4 p-5">
            <thead class="bg-dark text-white">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">data de Registo</th>
                    <th scope="col">curso</th>
                    <th scope="col">Accões</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($register_details as $key => $value) {
                ?>
                    <tr>
                        <td><?php echo $value['id']; ?></td>
                        <td><?php echo $value['nome']; ?></td>
                        <td><?php echo $value['email']; ?></td>
                        <td><?php echo $value['data_registo']; ?></td>
                        <td><?php echo $value['curso']; ?></td>
                        <td><a href="<?= $_SERVER["PHP_SELF"] ?>?apagar=<?= $value["id"] ?>" class="btDelete btn btn-danger" data-nome="<?= $value["nome"] ?>">Delete</a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    <?php
    } elseif ($register_details > 0) {
    ?>
        <p class="text-center fs-3 text-danger animate__animated animate__backInLeft">
            <?php echo " Aluno não encontrado"; ?>
        <p>
        <?php
    }
        ?>

        <!-- Footer -->
        <footer style=" background-attachment: fixed;" class=" text-center  position-absolute bottom-0 w-100 bg-primary">
            <!-- Copyright -->
            <p class="text-white"> © 2023 Copyright By:Ricardo Silva</p>
            <div class="text-center d-block text-white">
                <a class="text-white  pr-4" href="index.php">Home</a>
                <a class="text-white ml-2" href="registo.php">Registo aluno</a>
            </div>
        </footer>

        <script>
            //------Mostra uma mensagem para confirmar se deseja eliminar o registo----//
            let buttonDelete = document.querySelectorAll(".btDelete");
            for (let button of buttonDelete) {
                button.addEventListener("click", function(e) {
                    // let nome=this.parentElement.parentElement.firstElementChild.textContent;
                    let nome = this.getAttribute("data-nome");
                    if (!confirm("Confirma a eliminação do aluno '" + nome + "'?")) {
                        e.preventDefault();
                    }
                });
            }
        </script>
</body>

</html>