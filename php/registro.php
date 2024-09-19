<?php 
//GUIA: ESTE ARQUIVO POSSUI A FUNÇÃ DE SALVAR O NOVO PAGAMENTO ADICIONADO PELO USUÁRIO APÓS CONFIRMAR QUE ELE NÃO TINHA CIDO REGISTRADO
include('conexao.php');

//REPORTAR ERRO DE CONEXÃO
if(!$conn){
    die("Conexão falhou." . mysqli_connect_error());
}

//CAPTURAR OS DADOS DIGITADOS PELO USUÁRIO
if (isset($_POST["inscreva"])) {

    $Nome = ucwords(strtolower($_POST["nome"]));
    $Email = $_POST["email"];
    $Senha = $_POST["senha"];
}

//CONSULTA PARA O BANCO
$query_sits = "SELECT * FROM usuarios";
     
/*REALIZAR A CONEXÃO COM O BANCO, PEGAR OS DADOS EXISTENTES E VERIFICAR SE O DONO DO CPF DIGITADO JÁ ESTÁ CADASTRADO*/
$result = $conn->query($query_sits);
//VARIÁVEL PARA DADO JÁ EXISTENTE
$dadoExiste = false;
    
//LER OS DADOS DO BANCO PARA VERIFICAR A EXISTÊNCIA DO DADO DIGITADO
if (($result) and ($result->num_rows != 0) ) {
    while ($row = $result->fetch_assoc()) {
     
        extract($row);
        $dados[] = [
            'nome' => $Nome,
            'email' => $Email,
            'senha' => $Senha,
        ];
    }
    //VERIFICAR SE O USUÁRIO JÁ ECISTE NO BANCO
    for ($i = 0; $i < count($dados); $i++) {
        if(($dados[$i]['nome'] == $Nome) && ($dados[$i]['email'] == $Email)){
                
            $dadoExiste = true;
            echo '<script> alert("Este pagamento foi cadastrado anteriormente!"); const win = window.open("../html/index.html","_self"); </script>';
        }
    }
    //SE O USUÁRIO NÃO EXITE ENTÃO ELE REGISTRA
    if($dadoExiste == false){

        //-----------------------------------------------------CADASTRAR O USUÁRIO NO BANCO DE DADOS
        $query_sits2 = "INSERT INTO usuarios(nome, email, senha)  VALUES('$Nome', '$Email', '$Senha')";  

        //REALIZAR A CONEXÃO COM O BANCO ENVIANDO A CONSULTA
        $result2 = $conn->query($query_sits2);
            
        if ($result2) {
            //MOSTRAR NA TELA SE O CADASTRO FOI REALIZADO
            echo '<script> alert("Usuario registrado!"); const win = window.open("../html/index.html","_self"); </script>';
            
        }
    }
}

//SE FOR PARA REGISTRAR O PRIMEIRO USUÁRIO
else if (($result) and ($result->num_rows == 0) ) {
    //-----------------------------------------------------CADASTRAR O USUÁRIO NO BANCO DE DADOS
     
    $query_sits3 = "INSERT INTO usuarios(nome, email, senha)  VALUES('$Nome', '$Email', '$Senha')"; 
    
    //REALIZAR A CONEXÃO COM O BANCO ENVIANDO A CONSULTA
    $result3 = $conn->query($query_sits3);
        
    if ($result3) {
        //MOSTRAR NA TELA SE O CADASTRO FOI REALIZADO
        echo '<script> alert("Usuario cadastrado!!"); const win = window.open("../html/index.html","_self"); </script>';
    }
}
     
//-----------------------------------------------------ENCERRAR A CONEXÃO COM O BANCO
$conn->close();
?>