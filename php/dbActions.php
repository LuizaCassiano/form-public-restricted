<?php 
    header('Content-Type: application/json');

    $db_conn = include('dbConnection.php');
    $action = $_POST["action"];    
    
    if($action == "select")
    {              
        $restricted = getListRestricted($db_conn);
        $opened = getListOpened($db_conn);

        echo json_encode(array(
            'total_restrito' => $restricted[0],
            'dados_restrito' => $restricted[1],
            'total_aberto' => $opened[0],
            'dados_aberto' => $opened[1]
        ));
    }
    else if($action == "update")
    {
        $type_form = $_POST["type_form"];
        $id = $_POST["id"];     

        $result = updateUser($db_conn, $id, $type_form);

        echo json_encode(array(
            'mensagem' => $result
        ));
    }
    else if($action == "delete")
    {
        $type_form = $_POST["type_form"];
        $id = $_POST["id"];

        $result = deleteUser($db_conn, $id, $type_form);   
        
        echo json_encode(array(
            'mensagem' => $result
        ));
    }   
    else if($action == "insert")
    {
        $type_form = $_POST["type_form"];

        $result = insertUser($db_conn, $type_form);

        echo json_encode(array(
            'mensagem' => $result
        ));
    } 

    $db_conn->close();

    function insertUser($db_conn, $type_form)
    {
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $cpf = $_POST["cpf"];

        $query = mysqli_query($db_conn, "SELECT * FROM formaberto WHERE cpf like '{$cpf}'");
        $total = mysqli_num_rows($query); 

        if($type_form == "aberto")
        {
            $telefone = $_POST["telefone"];
            $sql = "INSERT INTO formaberto (`Nome`, `Email`, `CPF`, `Telefone`) VALUES ('{$nome}', '{$email}', '{$cpf}', '{$telefone}')";
        }
        else if($type_form == "restrito")
        {
            $senha = $_POST["senha"];
            $sql = "INSERT INTO formrestrito (`Nome`, `Email`, `CPF`, `Senha`) VALUES ('{$nome}', '{$email}', '{$cpf}', '{$senha}')";
        }

        if(!$query || $total === 0)
        {
            if ($db_conn->query($sql) === TRUE) {
                return "Cadastro realizado com sucesso, você já pode acessar a aplicação";
            } else {
                return "Error: " . $sql . "<br>" . $db_conn->error; 
            }
        }
        else
        {
            return "CPF ja cadastrado";
        } 
    }

    function updateUser($db_conn, $id, $type_form)
    {
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $cpf = $_POST["cpf"];

        if($type_form == "aberto")
        {
            $nameTable = "formaberto";
            $telefone = $_POST["telefone"];

            $sql = "UPDATE $nameTable SET Nome = '{$nome}', Email = '{$email}', 
                    CPF = '{$cpf}', Telefone = '{$telefone}' WHERE Id = {$id}";
        }
        else if($type_form == "restrito")
        {
            $nameTable = "formrestrito";
            $senha = $_POST["senha"];

            $sql = "UPDATE $nameTable SET Nome = '{$nome}', Email = '{$email}', 
                    CPF = '{$cpf}', Senha = '{$senha}' WHERE Id = {$id}";
        } 

        if ($db_conn->query($sql) === TRUE) {
            return "Cadastro atualizado com sucesso, atualize a aplicação para ver as atualizações";
        } else {
            return "Error: " . $sql . "<br>" . $db_conn->error; 
        }
    }

    function deleteUser($db_conn, $id, $type_form)
    {
        if($type_form == "aberto")
        {
            $nameTable = "formaberto";
        }
        else if($type_form == "restrito")
        {
            $nameTable = "formrestrito";
        }

        $query = mysqli_query($db_conn, "SELECT * FROM {$nameTable} WHERE Id = {$id}");
        $total = mysqli_num_rows($query);

        if(!$query || $total > 0)
        {
            $sql = "DELETE FROM {$nameTable} WHERE Id = {$id}";

            if ($db_conn->query($sql) === TRUE) {
                return "Cadastro deletado com sucesso, atualize a aplicação para ver as atualizações";
            } else {
                return "Error: " . $sql . "<br>" . $db_conn->error; 
            }
        }
        else
        {
            return "Erro ao fazer consulta SQL";
        } 
    }

    function getListRestricted($db_conn)
    {      
        $select_restricted = mysqli_query($db_conn, "SELECT * FROM formrestrito");
        $total_restricted = mysqli_num_rows($select_restricted); 
        $dados_restricted = array();

        if($total_restricted > 0)
        {
            while($row = $select_restricted->fetch_assoc()) {

                $dados_restricted[] = array(
                    'nome' => $row["Nome"],
                    'email' => $row["Email"],
                    'cpf' => $row["CPF"],
                    'senha' => $row["Senha"],
                    'id' => $row["Id"]
                );
            }
        }

        return array($total_restricted, $dados_restricted);
    }

    function getListOpened($db_conn)
    {      
        $select_opened = mysqli_query($db_conn, "SELECT * FROM formaberto");
        $total_opened = mysqli_num_rows($select_opened); 
        $dados_opened = array();

        if($total_opened > 0)
        {
            while($row = $select_opened->fetch_assoc()) {

                $dados_opened[] = array(
                    'nome' => $row["Nome"],
                    'email' => $row["Email"],
                    'cpf' => $row["CPF"],
                    'telefone' => $row["Telefone"],
                    'id' => $row["Id"]
                );
            }
        }

        return array($total_opened, $dados_opened);
    }
?>