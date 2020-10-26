<?php 
    header('Content-Type: application/json');

    $db_conn = include('dbConnection.php');
    $type_form = $_POST["type_form"];  
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $cpf = $_POST["cpf"];

    if($type_form == "aberto")
    {
        $telefone = $_POST["telefone"];

        $query = mysqli_query($db_conn, "SELECT * FROM formaberto WHERE Nome LIKE '{$nome}' 
                            AND Email LIKE '{$email}' AND CPF LIKE '{$cpf}' 
                            AND Telefone like '{$telefone}'");

        $total = mysqli_num_rows($query); 
    
        if(!$query || $total === 1)
        {
            echo json_encode(array(
                'nome' => $nome,
                'email' => $email,
                'cpf' => $cpf,
                'telefone' => $telefone
            ));
        }
        else
        {
            echo json_encode(array(
                'mensagem' => "Dados incorretos"
            ));
        } 
    }
    else if($type_form == "restrito")
    {
        $senha = $_POST["senha"];

        $query = mysqli_query($db_conn, "SELECT * FROM formrestrito WHERE Nome LIKE '{$nome}' 
                            AND Email LIKE '{$email}' AND CPF LIKE '{$cpf}' 
                            AND Senha like '{$senha}'");

        $total = mysqli_num_rows($query); 
        
        if(!$query || $total === 1)
        {
            echo json_encode(array(
                'nome' => $nome,
                'email' => $email,
                'cpf' => $cpf,
                'senha' => $senha
            ));
        }
        else
        {
            echo json_encode(array(
                'mensagem' => "Dados incorretos"
            ));
        } 
    } 

    $db_conn->close();
?>