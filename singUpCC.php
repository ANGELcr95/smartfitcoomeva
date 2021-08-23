<?php
error_reporting(0);
session_start();
require 'database.php';

$resp = NULL;
$_SESSION['correo']= $_POST['email']; //aqui exportro em email
$correo = $_POST['email'];
$user = $_SESSION['user_asociado'];

$message = '¡Hola! ' .$user. ", ingresa tu correo electrónico, para el envío de tu CUPON. ";
$documento = $_SESSION['user_documento'];

if (!empty($_POST['email'])) {
    $data = [
        'correo' => $correo,
        'documento' => $documento,
    ];
    $sql = "UPDATE usuarios SET emailUsuario=:correo WHERE documento=:documento";
    $stmt= $conn->prepare($sql);
    $stmt->execute($data);

    

    if($stmt->execute($data)){

        $stmtc = $conn->prepare("SELECT *  FROM codigossmartfit WHERE idUsuario IS NULL limit 1;");
        $stmtc->execute();
        $userc = $stmtc->fetch(PDO::FETCH_ASSOC);
        $respid = $userc['id'];
        $respcodigo = $userc['codigo'];

        if($stmtc->execute()){
            $datab = [
                'documento' => $documento,
                'respid' => $respid
            ];
            $sql = "UPDATE codigossmartfit SET idUsuario=:documento WHERE id=:respid";
            $stmt= $conn->prepare($sql);
            $stmt->execute($datab);

        } 
        if($stmt->execute($datab)){
            $records = $conn->prepare("SELECT * FROM codigossmartfit WHERE idUsuario=:documento ORDER BY codigosSmartFit.id DESC LIMIT 1"); 
            $records->bindParam(':documento', $documento); 
            $records->execute();  
            $results = $records->fetch(PDO::FETCH_ASSOC);
            $_SESSION['codigo'] = $results['codigo'];  //aqui exportro em codigo
            $codigoresp = $results['codigo'];

            $offset=5*60*60;
            $dateFormat="Y-m-d H:i:s";
            $timeNdate=gmdate($dateFormat, time()-$offset);

            $datac = [
                'timeNdate' => $timeNdate,
                'documento' => $documento
            ];
            $sql = "UPDATE codigossmartfit SET fechaRedime=:timeNdate WHERE idUsuario=:documento";
            $stmt= $conn->prepare($sql);
            $stmt->execute($datac);

            $recordsa = $conn->prepare('SELECT * FROM codigossmartfit WHERE idUsuario=:documento'); 
		    $recordsa->bindParam(':documento', $results['documento']); 
		    $recordsa->execute();
            $resultsa = $recordsa->fetch(PDO::FETCH_ASSOC);
            $fecha = $resultsa['fechaRedime'];
            
            if( $recordsa->execute()){

                $name = $_SESSION['user_asociado'];
                $asunto = "Envio de CUPON";
                $msg = "Este es un mensaje el cual anexa un cupon $codigoresp Smarfit";
                $email = $_POST['email'];
                $header = "From: mcamacho@gekoestudio.com" ."\r\n";
                $header.= "Reply-To: $correo " ."\r\n";
                $header .= "X-Mailer: PHP/". phpversion();
                $mail = @mail($email,$asunto,$msg,$header);
                header('Location:logout.php');
                if($mail) {
                    echo "enviado con exito";
                    
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8"/>
        <title>Smartfit Coomeva</title>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1,maximum-scale=1, minimum-scale=1">
		<link rel="stylesheet" href="SingUpCC.css">
		<link rel="stylesheet" href="conditions.css">
    </head>

    <header>
        <div class="contenedor">
            <h1>Smartfit Coomeva</h1>

            <div class="contenedor">
                <img src="images/cropped-logo.png" style="margin-bottom:35px;">
                <h2 style="color: white; margin-bottom: 40px; font-weight: lighter;">¡Redime tus cupones de <b>SmartFit</b> aquí!</h3>
            </div>
            
            <div class="nameUser">
                <?php if(!empty($message )) : ?> 
                    <p><?=$message ?></p>
                <?php endif; ?>
            </div>
            
            <form action="singUpCC.php" method="post" id="formulario" >
                <div class="formulario__grupo" id="grupo__email">
                    <div class="formulario__grupo-input">
                        <input type="email" id="password1"  class="formulario__input" name="email" placeholder="Ingresa tu email" >
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">El correo debe tener la siguiente estructura: correo@outlook.com</p>
                </div>
                <input type="submit" id="into1" value="Send" >
            </form>
        </div>

        <script src="jsSingUpCC.js"></script>
        <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
	</header>
</html>


