<?php
require_once '../../../../wp-load.php';

$miembros = cargarMiembros();
$ciudades = $miembros['ciudades'];
$companias = $miembros['companias'];
$apellidos = $miembros['apellidos'];
$ids = $miembros['ids'];

//--BUSQUEDA POR ID
if (isset($_POST['id'])) {		
	$id = $_POST['id'];
	$miembro = $ids[$id][0];
	if ($miembro) {
		$resultado = array();
		$resultado[]=$miembro;	
	}
}
//--BUSQUEDA POR CIUDAD, COMPAÑIA Y APELLIDO
else{	
	$city = $_POST['city'];
	$company = $_POST['company'];	
	$lastname = $_POST['lastname'];	
	if ($city != '' && $company != '' && $lastname != '') {
		$resultado = array();
		foreach ($ciudades as $nombreCiudad => $ciudad) {
			if (stristr($nombreCiudad, $city)) {
				foreach ($ciudad as $c) {
					foreach ($ids[$c] as $miembro) {
						if ( (stristr($miembro->CITY, $city)) && (stristr($miembro->COMPANY, $company)) && (stristr($miembro->LAST_NAME, $lastname)) ) {
							$resultado[]=$miembro;
						}
					}
				}
			}
		}
	}
//--BUSQUEDA POR CIUDAD
	elseif ($city != '' && $company == '' && $lastname == '') {
		$resultado = array();
		foreach ($ciudades as $nombreCiudad => $ciudad) {
			if (stristr($nombreCiudad, $city)) {
				foreach ($ciudad as $c) {
					foreach ($ids[$c] as $miembro) {
						if (stristr($miembro->CITY, $city)) {
							$resultado[]=$miembro;
						}
					}
				}
			}
		}
	}
//--BUSQUEDA POR COMPAÑIA
	elseif ($city == '' && $company != '' && $lastname == ''){
		$resultado = array();
		foreach ($companias as $nombreCompania => $compania) {
			if (stristr($nombreCompania, $company)) {
				foreach ($compania as $c) {
					foreach ($ids[$c] as $miembro) {
						if (stristr($miembro->COMPANY, $company)) {
							$resultado[]=$miembro;
						}
					}
				}
			}
		}
	}
//--BUSQUEDA POR APELLIDO
	elseif ($city == '' && $company == '' && $lastname != ''){
		$resultado = array();
		foreach ($apellidos as $apeKey => $apeliido) {
			if (stristr($apeKey, $lastname)) {
				foreach ($apeliido as $a) {
					foreach ($ids[$a] as $miembro) {
						if (stristr($miembro->LAST_NAME, $lastname)) {
							$resultado[]=$miembro;
						}
					}
				}
			}
		}
	}
//--BUSQUEDA POR CIUDAD Y COMPAÑIA
	elseif ($city != '' && $company != '' && $lastname == '') {
		$resultado = array();
		foreach ($ciudades as $nombreCiudad => $ciudad) {
			if (stristr($nombreCiudad, $city)) {
				foreach ($ciudad as $c) {
					foreach ($ids[$c] as $miembro) {
						if ( (stristr($miembro->CITY, $city)) && (stristr($miembro->COMPANY, $company)) ) {
							$resultado[]=$miembro;
						}
					}
				}
			}
		}
	}
//--BUSQUEDA POR CIUDAD Y APELLIDO
	elseif ($city != '' && $company == '' && $lastname != '') {
		$resultado = array();
		foreach ($ciudades as $nombreCiudad => $ciudad) {
			if (stristr($nombreCiudad, $city)) {
				foreach ($ciudad as $c) {
					foreach ($ids[$c] as $miembro) {
						if ( (stristr($miembro->CITY, $city)) && (stristr($miembro->LAST_NAME, $lastname)) ) {
							$resultado[]=$miembro;
						}
					}
				}
			}
		}
	}
//--BUSQUEDA POR APELLIDO Y COMPAÑIA
	elseif ($city == '' && $company != '' && $lastname != '') {
		$resultado = array();
		foreach ($companias as $nombreCompania => $compania) {
			if (stristr($nombreCompania, $company)) {
				foreach ($compania as $c) {
					foreach ($ids[$c] as $miembro) {
						if ( (stristr($miembro->COMPANY, $company)) && (stristr($miembro->LAST_NAME, $lastname)) ) {
							$resultado[]=$miembro;
						}
					}
				}
			}
		}
	}
}

//--TABLA RESULTADOS	

//--CANTIDAD DE RESULTADOS A MOSTRAR
$cantidadAMostrar = 20;

if(!$resultado){
	echo "There are no results that match the filter you used";
}
else{
	$cantidad = count($resultado);
	$i = 0;
	$mostrar = '';
	?>
	<table border="0">

	<?php
	foreach ($resultado as $miembro) {
		$i++;
		if ($i > $cantidadAMostrar) {
			$mostrar = 'style=display:none; class="hidden-tr"';
		} ?>			 
		<tr <?php echo $mostrar; ?>>					
			<td>&nbsp&nbsp<strong><?php echo $miembro->FULL_NAME; ?></strong>  |  <?php echo $miembro->TITLE; ?><br>
			&nbsp&nbsp <img src="<?php bloginfo('template_directory'); ?>/images/w.png" alt="<?php echo $miembro->CITY; ?>" height="22" width="23"> <?php echo $miembro->ADDRESS_1; ?>  |  <?php echo $miembro->ADDRESS_2; ?>   |  <?php echo $miembro->CITY; ?>,  <?php echo $miembro->STATE_PROVINCE; ?>  <?php echo $miembro->ZIP; ?><br>
			&nbsp&nbsp <img src="<?php bloginfo('template_directory'); ?>/images/m.png" alt="<?php echo $miembro->EMAIL; ?>" height="22" width="23"> <?php echo $miembro->EMAIL; ?><br>
			&nbsp&nbsp <img src="<?php bloginfo('template_directory'); ?>/images/p.png" alt="<?php echo $miembro->WORK_PHONE; ?> " height="22" width="23"> <?php echo $miembro->WORK_PHONE; ?>  |  <?php echo $miembro->FAX; ?></td>
		</tr>

		<?php }	?>
	</table>
	&nbsp&nbspTotal Count: <?php echo $cantidad ?>
	<?php
	if ($cantidad > $cantidadAMostrar) {
		?><input id="more" type="button" value="More"><?php 
	}
	}



	