<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="contenedor-sm">
    <div class="contenedor-nueva-tarea">
        <button class="agregar-tarea" type="button" id="agregar-tarea">&#43; Nueva Tarea</button>
    </div>
    <ul id="listado-tareas" class="listado-tareas"></ul>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>

<?php

$script = '
    <script src="build/js/tareas.js"></script>
';

?>