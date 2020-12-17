<?php session_start() ?>
<!-- Empieza Modal Info Usuario -->
<?php if(isset($_COOKIE['token'])) {?>
    
        <div class="modal-dialog" style="width: 450px" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalInfoUserTitle">Modificar Informacion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert-danger" id="erroresInfoUser" style="display: none"></div>
                    <form action="" name="formInfoUser" id="formInfoUser">
                        <div class="form-group">
                            <label for="nombre">Nombre completo</label>
                            <input type="text" class="form-control" id="nombreInfo" name="nombre" placeholder="Nombre completo">
                            <div id="nombreHelpBlock" class="form-text">
                                No debe tener caracteres especiales
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="usuario">Usuario</label>
                            <input type="text" class="form-control" id="usuarioInfo" name="usuario" placeholder="Usuario">
                            <div id="usuarioHelpBlock" class="form-text">
                                Debe tener entre 5-15 caracteres sin espacios ni caracteres especiales
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-link" onclick="eliminarUsuario()">Eliminar mi cuenta</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="row" style="margin-left: auto; margin-right: auto">
                        <button type="button" style="width: 100px; margin-right: 10px;" onclick="actualizarInformacion()" class="btn btn-primary">Validar</button>
                        <button type="button" style="width: 100px" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <!-- Termina Modal Info Usuario -->