<?php $accionActual = $_GET['accion'] ?? 'catalogo'; ?>
<aside class="sidebar">
  <a href="index.php?accion=catalogo"
     class="<?= $accionActual === 'catalogo' ? 'activo' : '' ?>">
    📦 Catálogo
  </a>
  <a href="index.php?accion=nuevo-producto"
     class="<?= $accionActual === 'nuevo-producto' ? 'activo' : '' ?>">
    ➕ Nuevo producto
  </a>
  <a href="index.php?accion=reporte-pdf" target="_blank">🧾 Reporte PDF
  </a>
</aside>