<?php
    session_start();
    session_destroy();
    setcookie("token", "", time()-1,"/");
    setcookie("usuario", "", time()-1,"/");
    setcookie("correo", "", time()-1,"/");
    setcookie("dinero", "", time()-1,"/");
    setcookie("id", "", time()-1,"/");
    setcookie("opcion", "", time()-1,"/");
    header("Location: /");