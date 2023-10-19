<?php 
class ControladorFormularios
{   
    static public function crtRegistro()
    {
        if (isset($_POST["registroNombre"])) {
            if (
                preg_match("/^[a-zA-Z ]+$/", $_POST["registroNombre"]) && 
                preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})+$/', $_POST ["registroEmail"]) && 
                preg_match('/^[0-9a-zA-Z]+$/', $_POST ["registroPassword"])){
                
                $tabla = "registros_sag";
                $token = md5($_POST["registroNombre"] . "+" . $_POST ["registroEmail"]);
                
                $datos = array("token" => $token,
                    "nombre" => $_POST["registroNombre"],
                    "email" => $_POST["registroEmail"],
                    "password" => $_POST["registroPassword"]
                );
                
                $respuesta = ModeloFormularios::mdlRegistro($tabla, $datos);
                return $respuesta;
            }else{
                $respuesta ="error";
                return $respuesta;

            }

        }
    }
    static public function ctrSeleccionarRegistros($item, $valor)
    {
        if ($item == null && $valor == null) {
            $tabla = "registros_sag";

            $respuesta = ModeloFormularios::mdlSeleccionarRegistros($tabla, null, null);

            return $respuesta;
        } else {
            $tabla = "registros_sag";

            $respuesta = ModeloFormularios::mdlSeleccionarRegistros($tabla, $item, $valor);

            return $respuesta;
        }
    } 
    public function ctrIngreso()
    {
        if (isset($_POST["ingresoEmail"])) {
            $tabla = "registros_sag";
            $item = "email";
            $valor = $_POST["ingresoEmail"];

            $respuesta = ModeloFormularios::mdlSeleccionarRegistros($tabla, $item, $valor);

            if (is_array($respuesta)) {
                if ($respuesta["email"] == $_POST["ingresoEmail"] && $respuesta["password"] == $_POST["ingresoPassword"]) {

                    $_SESSION["validarIngreso"] = "ok";

                    echo "Bienvenido";

                    echo '<script>
                        if (window.history.replaceState){
                            window.history.replaceState(null, null, window.location.href);
                        }
                        setTimeout(function(){
                            window.location.href = "index.php?pagina=inicio";
                        }, 1000);
                    </script>';
                } else {
                    echo '<script>
                        if (window.history.replaceState){
                            window.history.replaceState(null, null, window.location.href);
                        }
                    </script>';
                    echo '<div class="alert alert-danger">Error</div>';
                }
            } else {
                echo '<script>
                    if (window.history.replaceState){
                        window.history.replaceState(null, null, window.location.href);
                    }
                </script>';
                echo '<div class="alert alert-danger">Error ';
            }
        }
    }

    static public function ctrActualizarRegistro()
    {
        if (isset($_POST["updateName"])) {

            if (
                preg_match("/^[a-zA-Z ]+$/", $_POST["updateName"]) && 
                preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})+$/', $_POST ["updateEmail"])){
                    $usuario = ModeloFormularios::mdlSeleccionarRegistros("registros_sag", "token", $_POST["tokenUsuario"]);
            $compararToken = md5($usuario["nombre"] . "+" . $usuario["email"]);

            if ($compararToken == $_POST["tokenUsuario"]) {
                if ($_POST["updatePassword"] != "") {
                    if ( preg_match('/^[0-9a-zA-Z]+$/', $_POST ["updatePassword"])) {
                    }
                    $password = $_POST["updatePassword"];
                } else {
                    $password = $_POST["passwordActual"];
                }
                $tabla = "registros_sag";
    
                $datos = array(
                    "token" => $_POST["tokenUsuario"],
                    "nombre" => $_POST["updateName"],
                    "email" => $_POST["updateEmail"],
                    "password" => $password
                ); 
                $actualizar = ModeloFormularios::mdlActualizarRegistros($tabla, $datos);
                return $actualizar;
            }
            else {
                $actualizar = "error";
                return $actualizar;
            }
            }else {
                $actualizar = "error";
                return $actualizar; 
            }
        }
    }

    public function ctrEliminarRegistro()
    {
        if (isset($_POST["deleteRegistro"])) {

            $usuario = ModeloFormularios::mdlSeleccionarRegistros("registros_sag", "token", $_POST["deleteRegistro"]);
            $compararToken = md5($usuario["nombre"] . "+" . $usuario["email"]);
            if ($compararToken == $_POST["deleteRegistro"]) {

                $tabla = "registros_sag";
                $valor = $_POST["deleteRegistro"];
                $respuesta = ModeloFormularios::mdlEliminarRegistro($tabla, $valor);
    
                if ($respuesta == "ok") {
                    echo '<script>
                    if (window.history.replaceState){
                        window.history.replaceState(null, null, window.location.href);
                    }
                    window.location = "index.php?pagina=inicio";
                    </script>';
                }
            }

        }
    }
}

    
