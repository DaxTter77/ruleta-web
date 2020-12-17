
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/">RULETA</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <?php if(isset($_COOKIE['token'])){ ?>
        <div class="collapse navbar-collapse centerContent">
        <ul class="nav navbar-nav ml-auto">
            <li>
                <a class="navbar-brand" href="javascript: abrirInfoUsuario()">
                    <img src="/view/assets/images/user_icon.png" alt="" width="35" height="35" class="d-inline-block align-top">
                    <?php echo $_COOKIE['usuario'] ?>
                </a>
            </li>
            <li>
                <a class="navbar-brand" href="javascript: $('#modalDinero').modal()">
                    <img src="/view/assets/images/money_icon.png" alt="" width="35" height="35" class="d-inline-block align-top">
                    <?php echo $_COOKIE['dinero'] ?>
                </a>
            </li>
        </ul>
        </div>
    <?php } ?>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="nav navbar-nav ml-auto">
            
                <?php  
                if(isset($_COOKIE['token'])){
                    echo '<li class="nav-item active">';
                    echo '<a class="btn btn-danger btn-sm" href="/server/api/logout.php">Salir</a>';
                }else{
                    
                    echo '<li class="nav-item active mr-3">';
                    echo '<button type="button" data-toggle="modal" data-target="#modalLogin" class="btn btn-primary btn-sm" id="login_button" href="/">Ingresar</a>';
                    echo '</li>';
                    echo '<li class="nav-item active">';
                    echo '<button type=button" data-toggle="modal" data-target="#modalRegister" class="btn btn-secondary btn-sm" id="register_button" href="/">Registrar</a>';
                }
                ?>
            </li>
        </ul>
    </div>
</nav>

