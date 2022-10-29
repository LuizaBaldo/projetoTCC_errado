<?php
    require_once './functions.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>

        <!-- bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <!-- JavaScript bootstrap 5 -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
        <!-- icons font-awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
        <!-- CSS -->
        <link rel="stylesheet" href="../css/pag_esqueci_senha.css">
        <link rel="stylesheet" href="../css/styles.css">
        <!-- js -->
        <!-- <script lang="javascript" src="../js/pag_esqueci_senha.js"></script>   -->
        
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Adot.org</title>
    </head>
    <body>
        <?php
            require_once './partials/common.php';
        ?>
        <div class="container rounded p-3" style="background-color: #66C4A9; width: 50%; margin-top:10%;">
            <h3 style="text-align: center;">Esqueci a Senha</h3>
            <form method="post" action="pag_esqueci_senha.php?enviar=1" id="formEsqueci">
                <label class="form-label">Insira seu e-mail</label>
                <input class="form-control form-control-sm" type="email" required />
                <button type="button" name="EnviaEmail" class="btn mt-3" onclick="validar();" style="background-color: #4C79D5; color: white;">Enviar e-mail</button>
                <?php if(isset($_POST["EnviaEmail"])) enviarEmail(); ?>
            </form>
        </div>
    </body>
</html>

<script language="javaScript">
function validar(){
  if(txtEmail.value ==  '' 
  || txtEmail.value.length<6 
  || txtEmail.value.indexOf("@")<=0
  || txtEmail.value.lastIndexOf(".") <= txtEmail.value.indexOf("@")){
    alert("Informe um e-mail válido!");
    txtEmail.focus();
    txtEmail.value = "";
    return false;
  }
  formEsqueci.submit();
}
</script>
<?php
  function enviarEmail(){
    $email = $_POST["email"];
    $con = new mysqli("localhost", "root", "", "tcc");
    $sql = "select nome from cliente where email='$email'";
    $retorno = mysqli_query($con, $sql);
    if($reg = mysqli_fetch_array($retorno)){
      $nome = $reg["nome"];
      $assunto = "Recuperação de Senha Adot.org";
      $mensagem = "<h4>Olá, $nome!</h4><br/><h4>Clique aqui para alterar sua senha</h4><br/><a href='http://localhost/TCC_Adot.org_2022-v3/workspace/php/altera_senha.php'>Alterar senha</a>";
      $header = "MIME-Version: 1.0\r\n";
      $header .= "Content-Type: text/html; charset=UTF-8\r\n";
      $header .= "from: Contato Adot.org<contato.adotorg@gmail.com>";
  
      $success = mail($email, $assunto, $mensagem, $header);
      if($success){
          echo "Email enviado com sucesso";
      }else{
          echo "Ocorreu um erro!";
      }        
    } else {
        echo "E-mail não cadastrado";
    }
    mysqli_close($con);
  }
?>