<?php 
    header('Content-Type: application/json');

    $type_form = $_POST["type_form"];
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $cpf = $_POST["cpf"];
    $erro = array();
    $success = "";

    if(empty($nome))
    {
        $erro[] = "Favor digitar seu nome\n";  
    }

    if(empty($email))
    {
        $erro[] =  "Favor digitar seu email\n";  
    }

    if(empty($cpf))
    {
        $erro[] =  "Favor digitar seu cpf\n";  
    }

    if($type_form == "aberto")
    {        
        $telefone = $_POST["telefone"];       

        if(empty($telefone))
        {
            $erro[] =  "Favor digitar seu telefone";  
        }

        if(!empty($nome) && !empty($email) && !empty($cpf) && !empty($telefone))
        {
            $success = "OK";
        }
    }
    else if($type_form == "restrito")
    {
        $senha = $_POST["senha"];        

        if(empty($senha))
        {
            $erro[] =  "Favor digitar sua senha";  
        }

        if(!empty($nome) && !empty($email) && !empty($cpf) && !empty($senha))
        {
            $success = "OK";
        }
    }    

    echo json_encode(array(
        'mensagem' => $erro,
        'success' => $success
    ));
?>