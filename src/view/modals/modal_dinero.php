<?php session_start() ?>
<!-- Empieza Modal Dinero -->
<?php if(isset($_COOKIE['token'])) {?>
    
        <div class="modal-dialog" style="width: 450px" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDineroTitle">Ingresar Dinero</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert-danger" id="erroresDinero" style="display: none"></div>
                    <form action="" name="formDinero" id="formDinero">
                        <div class="form-group">
                            <label for="cantidad_dinero">Cantidad de dinero a adicionar</label>
                            <input type="number" class="form-control" id="cantidad_dinero" name="dinero" placeholder="Ingrese la cantidad de dinero">
                            <div id="dineroHelpBlock" class="form-text">
                                Maximo $20.000
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="row" style="margin-left: auto; margin-right: auto">
                        <button type="button" style="width: 100px; margin-right: 10px;" onclick="agregarDinero()" class="btn btn-primary">Ingresar</button>
                        <button type="button" style="width: 100px" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <!-- Termina Modal Dinero -->