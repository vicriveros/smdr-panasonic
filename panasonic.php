<?php
//conexion a base de datos 
error_reporting(0);
$bd_host = "localhost";
$bd_base= "panasonic";
$bd_usuario= "user";
$bd_password= "pass";
$conn_string= "host=".$bd_host." port=5432 dbname=".$bd_base." user=".$bd_usuario." password=".$bd_password;
$con = pg_connect($conn_string);

$fp = stream_socket_client("192.168.1.14:2300", $errno, $errstr, 30); //se pasa como parametro la ip y el puerto de la central
	stream_set_blocking ( $fp , FALSE );
if (!$fp) {
    echo "$errstr ($errno)<br />\n";
} else {
    fwrite($fp, "SMDR\r\n"); //usuario para conexion smdr
    fwrite($fp, "PCCSMDR\r\n"); //pass de conexion smdr

echo "--------------------------------------------------------";
echo "\n";
echo "SMDR Panasonic - ".date('d-m-Y \a\t H:i:s');
echo "\n";
echo "--------------------------------------------------------";
echo "\n";
//la linea obtenida de la central no tiene formato, se determinan el dato por el espacio que le asigna la central a cada dato

    while (!feof($fp)) {

        $linea = fgets($fp);
        $linea1= substr($linea, 0,2);
		if(is_numeric($linea1)) {
				
				$fecha1=str_replace(' ', '',substr($linea, 0,8));
				$hora=str_replace(' ', '',substr($linea, 9,7));
				$extension=str_replace(' ', '',substr($linea, 17,5));
				$lineaco=str_replace(' ', '',substr($linea, 23,2));
				$numero=str_replace(' ', '',substr($linea, 26,25));
				$ring=str_replace(' ', '',substr($linea, 52,4));
				$duracion=str_replace("'", ":",str_replace(' ', '',substr($linea, 57,8)));
				$atendido=str_replace(' ', '',substr($linea, 77,2));

				list($di,$me,$an)=explode("/", $fecha1);
				$fecha='20'.$an.'-'.$me.'-'.$di;
				


					$sql="INSERT INTO llamadas 
					(fecha, hora, duracion, extension, direccion, nro, atendido) VALUES 
					('".$fecha."','".$hora."', '".$duracion."', '".$extension."', '".$direccion."', '".$numero."', '".$atendido."')";
					pg_query ($con, $sql) or die ("Problemas en $-campos insert:".pg_last_error ());

					echo $linea;
				}
			
		}
    }
    fclose($fp);
}

?>
