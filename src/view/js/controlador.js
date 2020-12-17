
$(document).ready(function(){
    $("header").load("/view/templates/header.php");
    $("#modalRegister").load("/view/modals/modal_register.php");
    $("#modalDinero").load("/view/modals/modal_dinero.php");
    $("#modalInfoUser").load("/view/modals/modal_info_user.php");
    if(comprobarCookie('opcion')){
        jugar();
        let interval = async () =>{
            await delay(3000);
            setInterval(jugar, 180000);
        }
        interval();
    } 
});

async function delay(ms) {
    return await new Promise((resolve) =>{
        setTimeout(resolve, ms);
    });
}

function pararIntervalor(){
    interval.clearInterval();
}

// Peticiones

function obtenerHistorial(){
    if(!comprobarCookie('id')){
        return false;
    }
    var id = Cookies.get('id');
        

    axios({
        method: 'GET',
        url: "/server/api/historial_juegos.php?id="+ id +"&jugador=true",
        responseType: 'json'
        }).then(response =>{
            if(response.data.datos != null){
                $("#contentTable").addClass("justify-content-center text-center p-5");
                $("#contentTable").removeClass("divHidden");
                $("table tbody").html("");
                $.each(response.data.datos, function(i){
                    var textDiferencia;
                    if(this.diferencia_dinero < 0){
                        textDiferencia = "<td style='color: red'>"+ this.diferencia_dinero+"</td><tr>";
                    }else{
                        textDiferencia = "<td style='color: green'>+"+ this.diferencia_dinero+"</td><tr>";
                    }
                    $("table tbody").append("<tr><td>"+ (i+1) +"</td>"
                    + "<td>"+ this.usuario_jugador +"</td>"
                    + "<td>"+ this.opcion +"</td>"
                    + "<td>"+ this.resultado_historial +"</td>"
                    + "<td>"+ this.apuesta_historial+"</td>"
                    + textDiferencia);
                });                    
            }else{
                $("#contentTable").html("");
                $("#vacio").fadeIn("slow");
                $("#vacio").addClass("row justify-content-center text-center p-5");
            }     
        });
    
}

function obtenerOpciones() {
    axios({
        method: 'GET',
        url: "/server/api/opcion_apuesta.php?",
        responseType: 'json'
        }).then(response =>{
            if(response.data.datos != null){
                $.each(response.data.datos, function(i){
                    var html = '';
                    if(comprobarCookie('opcion')){
                        opcion = Cookies.get('opcion').trim();
                        if(opcion == this.id_opcion){
                            html = '<input type="radio" onclick="obtenerOpcion()" class="btn-check" name="opcion"; id="'+this.id_opcion+'" value="'+this.id_opcion+'" autocomplete="off" checked>'
                            + '<label class="btn btn-outline-primary" for="'+this.id_opcion+'">'+this.opcion+'</label'
                        }else{
                            html = '<input type="radio" onclick="obtenerOpcion()" class="btn-check" name="opcion"; id="'+this.id_opcion+'" value="'+this.id_opcion+'" autocomplete="off">'
                            + '<label class="btn btn-outline-primary" for="'+this.id_opcion+'">'+this.opcion+'</label'
                        }
                    }else{
                        html = '<input type="radio" onclick="obtenerOpcion()" class="btn-check" name="opcion"; id="'+this.id_opcion+'" value="'+this.id_opcion+'" autocomplete="off">'
                        + '<label class="btn btn-outline-primary" for="'+this.id_opcion+'">'+this.opcion+'</label'
                    }
                    $("#opciones").append(html);
                });
            }else{
                $("#opciones").html("");
                $("#vacio").fadeIn("slow");
                $("#vacio").addClass("row justify-content-center text-center p-5");
            }     
        });

}

function obtenerOpcion(){
    opcion = $("#formOpciones input:checked").val();
    Cookies.set("opcion", opcion);
}

function actualizarSesion() {
    if(!comprobarCookie('id')){
        return false;
    }
    var id = Cookies.get('id');
        

    axios({
        method: 'GET',
        url: "/server/api/jugadores.php?id="+ id,
        responseType: 'json'
        }).then(response =>{
            if(response.data != null){
                Cookies.set('usuario', response.data.datos.usuario_jugador);
                Cookies.set('correo', response.data.datos.correo_electronico_jugador);
                Cookies.set('dinero', response.data.datos.dinero_jugador);
                $("header").load("/view/templates/header.php");
                return true;
            }else{
                var html = "<h5>Error en los datos, por favor vuelva a iniciar sesion</h5>"
                $("#modalInfoUsu").modal("hide");
                $("#erroresPage").fadeIn("slow");
                $("#erroresPage").html(html);
                setTimeout(function(){
                    $("#erroresPage").fadeOut("slow");
                    $("#erroresPage").html("");
                }, 10000);
                return false;
            }     
        });
}

function obtenerInformacionUsuario(){
    if(!comprobarCookie('id')){
        return false;
    }
    var id = Cookies.get('id');
        

    axios({
        method: 'GET',
        url: "/server/api/jugadores.php?id="+ id,
        responseType: 'json'
        }).then(response =>{
            if(response.data != null){
                $("#formInfoUser #nombreInfo").val(response.data.datos.nombre_jugador);
                $("#formInfoUser #usuarioInfo").val(response.data.datos.usuario_jugador);
                return true;
            }else{
                var html = "<h5>Error en los datos, por favor vuelva a iniciar sesion</h5>"
                $(".show").modal("hide");
                $("#erroresPage").fadeIn("slow");
                $("#erroresPage").html(html);
                setTimeout(function(){
                    $("#erroresPage").fadeOut("slow");
                    $("#erroresPage").html("");
                }, 10000);
                return false;
            }     
        });
    
}

function jugar(){
    if(validarOpcion()){
        if(comprobarCookie('id')){
            $("#pageLoader").fadeIn("fast");
            id = Cookies.get("id");
            dinero = Cookies.get("dinero");
            var datos = {
                opcion : Cookies.get('opcion'),
                dinero : dinero
            }
            console.log(datos);
            axios({
                url: "/server/api/juego.php?",
                data: datos,
                method: 'POST',
                responseType: 'json'
            }).then(response =>{
                $("#pageLoader").fadeOut("fast");
                if(response.data != null){
                    if(response.data.codigoResultado == 0){
                        var msg = response.data.mensaje
                        alert(msg);
                    }else{
                        $("#resultado").html(response.data.ganador);
                        alert(response.data.resultado);
                        obtenerHistorial();
                        actualizarSesion();
                        $("header").load("/view/templates/header.php");
                    }
                }
            }).catch(error =>{
                console.log(error);
            }); 
        }
    }
}

function verificarUsuario(){
    if(validarLogin()){
        $("#pageLoader").fadeIn("fast");
        var datos = {
            correo : document.getElementById("correo").value,
            clave : document.getElementById("clave").value
        }
        
        axios({
            url: "/server/api/login.php",
            data: datos,
            method: 'POST',
            responseType: 'json'
        }).then(response =>{
            $("#pageLoader").fadeOut("fast");
            if(response.data != null){
                if(response.data.codigoResultado == 0){
                    var html = "<ul>"+ response.data.mensaje +"</ul>"
                    $("#erroresLogin").html(html);
                    $("#erroresLogin").fadeIn("slow");
                }else{
                    $("#modalLogin").modal('hide');
                    location.reload();
                    obtenerOpciones();
                }
            }
        }).catch(error =>{
            console.log(error);
        }); 
    }
}

function realizarRegistro(){
    if(validarRegistro()){
        $("#pageLoader").fadeIn("fast");
        var datos = {
            usuario : document.getElementById("usuarioRegistro").value.trim(),
            nombre : document.getElementById("nombreRegistro").value.trim(),
            correo : document.getElementById("correoRegistro").value.trim(),
            clave : document.getElementById("claveRegistro").value
        };
        axios({
            url: "/server/api/jugadores.php",
            data: datos,
            method: 'POST',
            responseType: 'json'
        }).then(response =>{
            $("#pageLoader").fadeOut("fast");
            if(response.data != null){
                if(response.data.codigoResultado == 0){
                    var html = "<ul>"+ response.data.error +"</ul>"
                    $("#erroresRegister").html(html);
                    $("#erroresRegister").fadeIn("slow");
                }else{
                    $("#modalRegister").modal('hide');
                }
            }
        });
        
    }
}

function agregarDinero(){
    if(validarDinero()){
        if(!comprobarCookie('id')){
            return false;
        }
        var id = Cookies.get('id');
    
        $("#pageLoader").fadeIn("fast");
        var datos = {
            dinero : document.getElementById("cantidad_dinero").value
        }
        axios({
            url: "/server/api/jugadores.php?id="+id+"&dineroAdd=true",
            data: datos,
            method: 'PUT',
            responseType: 'json'
        }).then(response =>{
            $("#pageLoader").fadeOut("fast");
            if(response.data != null){
                if(response.data.codigoResultado == 0){
                    var html = "<ul>"+ response.data.error +"</ul>"
                    $("#erroresDinero").html(html);
                    $("#erroresDinero").fadeIn("slow");
                }else{
                    $("#modalDinero").modal('hide');
                    actualizarSesion();
                    $("header").load("/view/templates/header.php");
                }
            }
        });
        
    }
}

function actualizarInformacion(){
    if(validarInformacion()){
        if(!comprobarCookie('id')){
            return false;
        }
        if(!comprobarCookie('usuario')){
            return false;
        }
        var id = Cookies.get('id');
        var usuario = Cookies.get('usuario');
        get = "";
        if(!usuario == $("#usuarioInfo").val().trim()){
            get += '&newUsuario=true'
        }
        $("#pageLoader").fadeIn("fast");
        var datos = {
            usuario : document.getElementById("usuarioInfo").value.trim(),
            nombre : document.getElementById("nombreInfo").value.trim()
        }
        axios({
            url: "/server/api/jugadores.php?id="+id+get,
            data: datos,
            method: 'PUT',
            responseType: 'json'
        }).then(response =>{
            $("#pageLoader").fadeOut("fast");
            if(response.data != null){
                if(response.data.codigoResultado == 0){
                    var html = "<ul>"+ response.data.error +"</ul>"
                    $("#erroresInfoUser").html(html);
                    $("#erroresInfoUser").fadeIn("slow");
                }else{
                    $("#modalInfoUser").modal('hide');
                    actualizarSesion();
                    $("header").load("/view/templates/header.php");
                }
            }
        });
        
    }
}

function eliminarUsuario(){
    if(confirm('¿Deseas eliminar tu cuenta?')){
        if(!comprobarCookie('id')){
            return false;
        }
        
        var id = Cookies.get('id');
    
        axios({
            url: "/server/api/jugadores.php?id="+id,
            method: 'DELETE',
            responseType: 'json'
        }).then(response =>{
            if(response.data != null){
                if(response.data.codigoResultado == 0){
                    var html = "<ul>"+ response.data.error +"</ul>"
                    $("#erroresInfoUser").html(html);
                    $("#erroresInfoUser").fadeIn("slow");
                }else{
                    $("#modalInfoUser").modal('hide');
                    $("#pageLoader").fadeOut("fast");
                    setTimeout(function(){
                        window.location.replace("/server/api/logout.php");
                    }, 2000);
                }
            }
        });
    }
}   

function comprobarCookie(nombre){
    if(document.cookie.split(';').filter((item) => item.trim().startsWith(nombre+'=')).length){
        return true;
    }else{
        return false;
    }
}

function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

function abrirInfoUsuario(){
    obtenerInformacionUsuario()
    $("#modalInfoUser").modal();
}
$("#modalLogin").on('shown.bs.modal', function (){
    alert("Se abrio el modal");
    if(comprobarCookie('token')){
        $("#modalLogin").modal("hide");
    }
});
// Cuando los modales se cierran
$("#modalLogin").on('hidden.bs.modal', function (){
    if($("#erroresLogin").html() != ""){
        $("#erroresLogin").html("");
        $("#erroresLogin").css("display", "none");
    }

    if($("#correo").val() != ""){
        $("#correo").val("")
    }

    if($("#clave").val() != ""){
        $("#clave").val("")
    }
});

$("#modalDinero").on('hidden.bs.modal', function (){
    if($("#erroresDinero").html() != ""){
        $("#erroresDinero").html("");
        $("#erroresDinero").css("display", "none");
    }

    if($("#cantidad_dinero").val() != ""){
        $("#cantidad_dinero").val("")
    }
});

$("#modalRegister").on('hidden.bs.modal', function (){
    if($("#erroresRegister").html() != ""){
        $("#erroresRegister").html("");
        $("#erroresRegister").css("display", "none");
    }

    if($("#correoInfo").val() != ""){
        $("#correoInfo").val("")
    }

    if($("#claveInfo").val() != ""){
        $("#claveInfo").val("")
    }
    if($("#usuarioInfo").val() != ""){
        $("#usuarioInfo").val("")
    }

    if($("#nombreInfo").val() != ""){
        $("#nombreInfo").val("")
    }
});

$("#modalInfoUser").on('hidden.bs.modal', function (){
    if($("#erroresInfoUser").html() != ""){
        $("#erroresInfoUser").html("");
        $("#erroresInfoUser").css("display", "none");
    }

    if($("#correoRegistro").val() != ""){
        $("#correoRegistro").val("")
    }

    if($("#claveRegistro").val() != ""){
        $("#claveRegistro").val("")
    }
    if($("#usuarioRegistro").val() != ""){
        $("#usuarioRegistro").val("")
    }

    if($("#nombreRegistro").val() != ""){
        $("#nombreRegistro").val("")
    }
});

$("#formLogin").submit(function(e){
    e.preventDefault();
});

$("#formLogin input").keyup(function(e){
    if(e.key == "Enter"){
        verificarUsuario();
    }
});
$("#formRegister").submit(function(e){
    e.preventDefault();
});

$("#formRegister input").keyup(function(e){
    if(e.key == "Enter"){
        realizarRegistro();
    }
});
$("#formDinero").submit(function(e){
    e.preventDefault();
});

$("#formDinero input").keyup(function(e){
    if(e.key == "Enter"){
        agregarDinero();
    }
});
$("#formInfoUser").submit(function(e){
    e.preventDefault();
});

$("#formInfoUser input").keyup(function(e){
    if(e.key == "Enter"){
        actualizarInformacion();
    }
});

// Validaciones de campos
function validarLogin(){
    if(comprobarCookie('token')){
        return;
    }
    correo = document.getElementById("correo").value;
    clave = document.getElementById("clave").value;
    regexCorreo = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    msg = "<ul>";
    formOk = true;

    if(correo == ""){
        msg += "<li>El correo no puede ir vacío</li>";
        formOk = false;
    }else if(!regexCorreo.test(correo)){
        msg += "<li>El correo debe ir bien estructurado: example@hostexample.com</li>";
        formOk = false;
    }

    if(clave == ""){
        msg += "<li>La clave no puede ir vacía</li>";
        formOk = false;
    }

    if(!formOk){
        $("#erroresLogin").html(msg);
        $("#erroresLogin").fadeIn("slow");
    }else{
        $("#erroresLogin").html(msg);
        $("#erroresLogin").fadeOut("slow", function(){
            $("#erroresLogin").html("");
        });
    }

    return formOk;
}

function validarRegistro(){
    if(comprobarCookie('token')){
        return;
    }
    
    usuario = document.getElementById("usuarioRegistro").value.trim();
    nombre = document.getElementById("nombreRegistro").value.trim();
    correo = document.getElementById("correoRegistro").value.trim();
    clave = document.getElementById("claveRegistro").value;
    regexCorreo = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    regexUsuario = /[A-Za-z0-9_-]{5,15}/;
    regexNombre = /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/g;
    msg = "<ul>";
    formOk = true;
    if(nombre == ""){
        msg += "<li>El nombre no puede ir vacío</li>";
        formOk = false;
    }else if(!regexNombre.test(nombre)){
        msg += "<li>El nombre no debe tener caracteres especiales</li>";
        formOk = false;
    }

    if(usuario == ""){
        msg += "<li>El usuario no puede ir vacío</li>";
        formOk = false;
    }else if(!regexUsuario.test(usuario)){
        msg += "<li>El usuario debe tener entre 5-15 caracteres sin espacios ni caracteres especiales</li>";
        formOk = false;
    }

    if(correo == ""){
        msg += "<li>El correo no puede ir vacío</li>";
        formOk = false;
    }else if(!regexCorreo.test(correo)){
        msg += "<li>El correo debe ir bien estructurado: example@hostexample.com</li>";
        formOk = false;
    }

    if(clave == ""){
        msg += "<li>La clave no puede ir vacía</li>";
        formOk = false;
    }else if(clave.length < 8 || clave.length > 20){
        msg += "<li>La clave debe tener entre 8-20 caracteres</li>";
        formOk = false;
    }

    if(!formOk){
        $("#modalRegister #erroresRegister").html(msg);
        $("#modalRegister #erroresRegister").fadeIn("slow");
    }else{
        $("#modalRegister #erroresRegister").html(msg);
        $("#modalRegister #erroresRegister").fadeOut("slow", function(){
            $("#modalRegister #erroresRegister").html("");
        });
    }

    return formOk;
}

function validarInformacion(){
    if(!comprobarCookie('token')){
        return;
    }
    
    usuario = document.getElementById("usuarioInfo").value.trim();
    nombre = document.getElementById("nombreInfo").value.trim();
    regexCorreo = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    regexUsuario = /[A-Za-z0-9_-]{5,15}/;
    regexNombre = /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/g;
    msg = "<ul>";
    formOk = true;
    if(nombre == ""){
        msg += "<li>El nombre no puede ir vacío</li>";
        formOk = false;
    }else if(!regexNombre.test(nombre)){
        msg += "<li>El nombre no debe tener caracteres especiales</li>";
        formOk = false;
    }

    if(usuario == ""){
        msg += "<li>El usuario no puede ir vacío</li>";
        formOk = false;
    }else if(!regexUsuario.test(usuario)){
        msg += "<li>El usuario debe tener entre 5-15 caracteres sin espacios ni caracteres especiales</li>";
        formOk = false;
    }

    if(!formOk){
        $("#modalInfoUser #erroresInfoUser").html(msg);
        $("#modalInfoUser #erroresInfoUser").fadeIn("slow");
    }else{
        $("#modalInfoUser #erroresInfoUser").html(msg);
        $("#modalInfoUser #erroresInfoUser").fadeOut("slow", function(){
            $("#modalInfoUser #erroresInfoUser").html("");
        });
    }

    return formOk;
}

function validarDinero(){
    if(!comprobarCookie('token')){
        return;
    }
    dinero = document.getElementById("cantidad_dinero").value;
    msg = "<ul>";
    formOk = true;

    if(dinero == ""){
        msg += "<li>El valor no puede vacio</li>";
        formOk = false;
    }else{
        if(!isNumeric(dinero)){
            msg += "<li>El valor solo puede ser un numero</li>";
            formOk = false;
        }else if(parseFloat(dinero) < 0 && parseFloat(dinero) >= 20000){
            msg += "<li>El valor no puede exceder los 20000</li>";
            formOk = false;
        }
    }

    if(!formOk){
        $("#erroresDinero").html(msg);
        $("#erroresDinero").fadeIn("slow");
    }else{
        $("#erroresDinero").html(msg);
        $("#erroresDinero").fadeOut("slow", function(){
            $("#erroresDinero").html("");
        });
    }

    return formOk;
}

function validarOpcion(){
    if(!comprobarCookie('token')){
        return;
    }
    opcion = $("#formOpciones input:checked").val();
    formOk = true;

    if(opcion == "" || opcion == "undefined"){
        msg = "Selecciona una opcion";
        alert(msg);
        formOk = false;
    }else if(!comprobarCookie('opcion')){
        msg = "Selecciona una opcion";
        alert(msg);
        formOk = false;
    }
    return formOk
}
obtenerHistorial();
obtenerOpciones();
