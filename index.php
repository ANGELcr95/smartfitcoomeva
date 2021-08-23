<?php
error_reporting(0);
session_start();
require 'database.php';

$message = NULL;
$message1 = NULL;

if (!empty($_POST['number'])) { 
	$records = $conn->prepare('SELECT  documento, nombre_asociado FROM usuarios WHERE documento=:number'); 
	$records->bindParam(':number', $_POST['number']); 
	$records->execute();  
	$results = $records->fetch(PDO::FETCH_ASSOC);

	if (($_POST['number']) == $results['documento']) {
		$_SESSION['user_documento'] = $results['documento'];
		$_SESSION['user_asociado'] = $results['nombre_asociado']; //aqui exportro el nombre de la persona
		$user = $results['nombre_asociado'];

		$datebring = NULL;
		$dir = array();
		$cont = 0;

		$recordsa = $conn->prepare('SELECT * FROM codigossmartfit WHERE idUsuario=:documento'); 
		$recordsa->bindParam(':documento', $results['documento']); 
		$recordsa->execute();  
		while($resultsa = $recordsa->fetch(PDO::FETCH_ASSOC)) {
			$dir[$cont] = $resultsa['idUsuario'];
			$cont++;
		}

		if($cont > 1 )  {
			$message1 = 'Hola ' .$user. ", ya redimiste tus dos cupones!";
		} else {
			header('Location:singUpCC.php');
		}

  	} else {

    $message = 'El número de identificación no se encuentra habilitado en nuestra base de datos ';
		session_start();

		session_unset();

		session_destroy();
  	}
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8"/>
        <title>Smartfit Coomeva</title>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1,maximum-scale=1, minimum-scale=1">
		<link rel="stylesheet" href="index.css">
		<link rel="stylesheet" href="conditions.css">
    </head>

    <header>

	
		<div class="contenedor">
			<h1>Smartfit Coomeva</h1>
			<div class="contenedor">
                <img src="images/cropped-logo.png" style="margin-bottom:35px;">
                <h2 style="color: white; margin-bottom: 40px; font-weight: lighter;">¡Redime tus cupones de <b>SmartFit</b> aquí!</h3>
            </div>
			<form action="index.php" method="post" id="formulario" >
				<div class="formulario__grupo" id="grupo__number">
					<div class="formulario__grupo-input">
						<input type="number" id="usuario" class="formulario__input" name="number" placeholder="Ingresa tu cedula Aqui" >
						<i class="formulario__validacion-estado fas fa-times-circle"></i>
					</div>
					<p class="formulario__input-error">El numero de cedula solo debe contener numeros, al menos cuantro digitos.</p>
				</div>
				<input type="submit" id="into1" value="Enviar" >
			</form> 
				
			<div class="formulario__grupo" id="grupo__condiciones">
					<input type="checkbox" id="condiciones" name ="condiciones"  >
					<button  id="conditions">Terminos y condiciones</button> 
					<i class="formulario__validacion-estado fas fa-times-circle"></i>
				<p class="formulario__input-error">Debe aceptar terminos y condiciones</p>
			</div>
				
			<div>
				<div id="modal_container" class="modal-container">
					<div class="modal">
						<h2>Terminos y condiciones</h2>
						<p>
							Haciendo clic aquí aceptas las condiciones del sitio, recibir de vez en cuando nuestros mensajes y materiales de promoción, via correo electrónico o cualquier otro formulario de contacto que nos proporciones. Si no deseas recibir dichos materiales o avisos de promociones, simplemente avísanos en cualquier momento.
						</p>
						<button id="close">Cerrar</button>
					</div>
				</div>
			</div>

			<?php if(isset($message)) : ?> 
				<div id="modal_container3"  class="modal-container3 show3">
					<div class="modal3">
						<?php if(!empty($message )) : ?> 
							<p class="message"><?=$message ?></p>
						<?php endif; ?>
						<button id="close3">Cerrar</button>
					</div>
				</div>
			<?php endif; ?>

			<?php if(isset($message1)) : ?> 
				<div id="modal_container2"  class="modal-container2 show2">
					<div class="modal2">
						<?php if(!empty($message1 )) : ?> 
							<p class="message"><?=$message1 ?></p>
						<?php endif; ?>
						<button id="close2">Cerrar</button>
					</div>
				</div>
			<?php endif; ?>

		</div>
		
		<script src="js.js"></script>
		<script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
	</header> 
</html>



			