<?php session_start() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link REL=StyleSheet HREF="/view/css/estilos.css" TYPE="text/css" MEDIA=screen>
    <link rel="stylesheet" href="/view/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="../js/controlador.js"></script>
    <title>Ruleta</title>
</head>
<body>
    
    <header></header>
    <!-- Empieza pantalla de carga -->
    <div class="loader" id="pageLoader" style="display: none"></div>
    <!-- Termina pantalla de carga -->
    <!-- Fondo -->
    <div id="capa"></div>
    <!-- Fondo -->
    <!-- Empieza tabla historial -->
    <div class="container-fluid">
        <div id="vacio" class="divHidden">
            <div class="">
                <br> <h3 class=titleStyle> No se encontraron registros <h3>
                <br> <img class="" src='/view/assets/images/clean.png' alt='vacio' width='200' />
            </div>
        </div>
        <div class='divHidden' id="contentTable" >
            <h3 class="titleStyle">Historial de Juego</h3><br>
            <div style="color:red; margin-left:auto; margin-right:auto;" id="erroresPage"></div>
            <table class='table-dark table-hover centerContent' border=1 id="table" style="width: 80%">
                <thead class= ''>
                    <tr>
                        <th>#</th>
                        <th>Usuario</th>
                        <th>Opcion</th>
                        <th>Resultado</th>                            
                        <th>Cantidad Apostada</th>
                        <th>Perdió/Ganó</th>                                         
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
        <br>
    </div>
    <!-- Termina tabla historial -->

    <?php if(isset($_COOKIE['token']) ){?>
        <!-- Opciones juego -->
        <div class="row container justify-content-center">
            <form id="formOpciones" >
                <div class="btn-group-vertical" role="group" id="opciones" aria-label="Basic radio toggle button group"></div>
            </form>
            <div class="fomr-group text-center">
                <h3 id="resultado" class="titleStyle ml-2 text-center">RESULTADO</h3>
                <button type="button" class="btn btn-primary" onclick="jugar()">JUGAR</button>
            </div>
        </div>
        <!-- Opciones juego -->
    <?php } ?>
    
    <div class="modal-dialog modal fade modal-dialog-scrollable" id="modalRegister" tabindex="-1" role="dialog" aria-labelledby="modalRegisterLabel" aria-hidden="true"></div>

    <!-- Empieza Modal Login -->
    <?php if(!isset($_COOKIE['token'])) {?>
    <div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="modalLoginLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 450px" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLoginTitle">Iniciar Sesion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert-danger" id="erroresLogin" style="display: none"></div>
                    <form action="" name="formLogin" id="formLogin">
                        <div class="form-group">
                            <label for="correo">Correo Electronico</label>
                            <input type="text" class="form-control" id="correo" name="correo" placeholder="Ingrese su correo electronico">
                        </div>
                        <div class="form-group">
                            <label for="clave">Clave</label>
                            <input type="password" class="form-control" id="clave" name="clave" placeholder="Ingrese su clave">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="row" style="margin-left: auto; margin-right: auto">
                        <button type="button" style="width: 100px; margin-right: 10px;" onclick="verificarUsuario()" class="btn btn-primary">Validar</button>
                        <button type="button" style="width: 100px" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <!-- Termina Modal Login -->
    
    <div class="modal fade" id="modalDinero" tabindex="-1" role="dialog" aria-labelledby="modalDineroLabel" aria-hidden="true"></div>
    <div class="modal fade" id="modalInfoUser" tabindex="-1" role="dialog" aria-labelledby="modalInfoUserLabel" aria-hidden="true"></div>

</body>
</html>