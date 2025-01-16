<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
//error_reporting(E_ALL);
//error_reporting(E_ALL ^ E_NOTICE);
set_time_limit(900); // 15 minutes
//Nombre de usuario de mysql
define("USER", "root");

//Servidor de mysql
define("SERVER", "localhost");

//Nombre de la base de datos
define("BD", "scw");

//ContraseÃ±a de myqsl
define("PASS", "toor");

//Carpeta donde se almacenaran las copias de seguridad
define("BACKUP_PATH", "./backup-files/");

/*ConfiguraciÃ³n de zona horaria de tu paÃ­s para mÃ¡s informaciÃ³n visita
    http://php.net/manual/es/function.date-default-timezone-set.php
    http://php.net/manual/es/timezones.php
*/
date_default_timezone_set('America/Managua');


class SGBD{
    //Funcion para hacer consultas a la base de datos
    /*public static function sql($query){
        if(!$con=mysql_connect(SERVER,USER,PASS)){
            echo "Error en el servidor, verifique sus datos";
        }else{
            if (!mysql_select_db(BD)) {
                echo "Error al conectar con la base de datos, verifique el nombre de la base de datos";
            }else{
                mysql_set_charset('utf8',$con);
                mysql_query("SET AUTOCOMMIT=0;",$con);
                mysql_query("BEGIN;",$con);
                if (!$consul = mysql_query($query,$con)) {
                    echo 'Error en la consulta SQL ejecutada';
                    mysql_query("ROLLBACK;",$con);
                }else{
                    mysql_query("COMMIT;",$con);
                }
                return $consul;
            }
        }
    }  */

    public static function sql($query){
        $mysqli = @new mysqli(SERVER, USER, PASS, BD);
        if ($mysqli->connect_errno) {
            error_log('Connection error: ' . $mysqli->connect_errno);
        }else{
                $mysqli->set_charset('utf8mb4');
                $consul = $mysqli->query($query);
                return $consul;
        }
    }  


    //Funcion para limpiar variables que contengan inyeccion SQL
    public static function limpiarCadena($valor) {
        $valor=addslashes($valor);
        $valor = str_ireplace("<script>", "", $valor);
        $valor = str_ireplace("</script>", "", $valor);
        $valor = str_ireplace("SELECT * FROM", "", $valor);
        $valor = str_ireplace("DELETE FROM", "", $valor);
        $valor = str_ireplace("UPDATE", "", $valor);
        $valor = str_ireplace("INSERT INTO", "", $valor);
        $valor = str_ireplace("DROP TABLE", "", $valor);
        $valor = str_ireplace("TRUNCATE TABLE", "", $valor);
        $valor = str_ireplace("--", "", $valor);
        $valor = str_ireplace("^", "", $valor);
        $valor = str_ireplace("[", "", $valor);
        $valor = str_ireplace("]", "", $valor);
        $valor = str_ireplace("\\", "", $valor);
        $valor = str_ireplace("=", "", $valor);
        return $valor;
    }
}
