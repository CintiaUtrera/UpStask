<div class="contenedor crear">
<?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>
    <div class="contenedor-sm">
    <p class="descripcion-pagina">Crea tu cuenta en UpTask</p>
    <form action="/crear" class="formulario" method="POST">

        <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" />
        </div>

        <div class="campo">
            <label for="email">Email</label>
            <input type="email" name="email" id="email"  />
        </div>

        <div class="campo">
            <label for="password">Password</label>
            <input type="password" name="password" id="password"  />
        </div>

        <div class="campo">
            <label for="password2">Repetir Password</label>
            <input type="password" name="password2" id="password2"  />
        </div>

        <input type="submit" class="boton" value="Iniciar Sesión"  />
    </form>

    <div class="acciones">
        <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
        <a href="/olvide">¿Olvidaste tu Password? </a>
    </div>

    </div> <!--. contenedor-sm -->
</div>