<?php session_start() ?>
<!-- Empieza Modal Login -->

    <div class="modal-dialog" style="width: 450px" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegisterTitle">Registrarse</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert-danger" id="erroresRegister" style="display: none"></div>
                <form action="" name="formRegistro" id="formRegistro">
                    <div class="form-group">
                        <label for="nombre">Nombre completo</label>
                        <input type="text" class="form-control" id="nombreRegistro" name="nombre" placeholder="Ingrese su nombre completo">
                        <div id="nombreHelpBlock" class="form-text">
                            No debe tener caracteres especiales
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <input type="text" class="form-control" id="usuarioRegistro" name="usuario" placeholder="Ingrese su usuario">
                        <div id="usuarioHelpBlock" class="form-text">
                            Debe tener entre 5-15 caracteres sin espacios ni caracteres especiales
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="clave">Clave</label>
                        <input type="password" class="form-control" id="claveRegistro" name="clave" placeholder="Ingrese su clave">
                        <div id="passwordHelpBlock" class="form-text">
                            Debe tener entre 8-20 caracteres
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo electronico</label>
                        <input type="text" class="form-control" id="correoRegistro" name="correo" placeholder="Ingrese su correo electronico">
                    </div>
                    <div class="form-group">
                        <div class="centerContent">
                            <button class='btn btn-link'>¿Ya tienes una cuenta? Ingresa</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="row" style="margin-left: auto; margin-right: auto">
                    <button type="button" style="width: 100px; margin-right: 10px;" onclick="realizarRegistro()" class="btn btn-primary">Validar</button>
                    <button type="button" style="width: 100px" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

<!-- Termina Modal Register -->