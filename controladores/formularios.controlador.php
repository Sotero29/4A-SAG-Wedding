<?php 
class ControladorFormularios
{   
    static public function crtRegistro()
    {
        if (isset($_POST["registerName"])) {
            /*return $_POST["registerName"] . "<br>" . $_POST["registerEmail"] . "<br>" .$_POST["registerPassword"] . "<br>";*/
            $tabla = "registros_sag";

            $datos = array(
                "nombre" => $_POST["registerName"],
                "email" => $_POST["registerEmail"],
                "password" => $_POST["registerPassword"]
            );
            $respuesta = ModeloFormularios::mdlRegistro($tabla, $datos);
            return $respuesta;
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
            if ($_POST["updatePassword"] != "") {
                $password = $_POST["updatePassword"];
            } else {
                $password = $_POST["passwordActual"];
            }
            $tabla = "registros_sag";

            $datos = array(
                "id" => $_POST["id"],
                "nombre" => $_POST["updateName"],
                "email" => $_POST["updateEmail"],
                "password" => $password
            );
            $actualizar = ModeloFormularios::mdlActualizarRegistros($tabla, $datos);
            return $actualizar;
        }
    }

    public function ctrEliminarRegistro()
    {
        if (isset($_POST["deleteRegistro"])) {

            $tabla = "registros_sag";
            $valor = $_POST["deleteRegistro"];
            $respuesta = ModeloFormularios::mdlEliminarRegistro($tabla, $valor);

            if ($respuesta == "ok") {
                echo '<script>
                if (window.history.replaceState){
                    window.history.replaceState(null, null, window.location.href);
                }
                </script>    ';
                echo '<div class="alert-success"> Usuario eliminado! </div>
                    <script>
                    setTimeout(function(){
                    window.location = "index.php?pagina=inicio";
                    },3000);
                    </script>
                    ';
            }
        }
    }
}
?>
    
