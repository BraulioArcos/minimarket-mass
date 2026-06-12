<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/navbar.php'; ?>

<div class="contenedor">
  <?php require __DIR__ . '/../layout/sidebar.php'; ?>

  <main class="contenido">
    <h1>Catálogo del Minimarket Mass</h1>
    <p>Total de productos: <strong><?= $total ?></strong></p>

    <table>
      <thead>
        <tr>
          <th>Código</th>
          <th>Nombre</th>
          <th>Precio</th>
          <th>Precio con IGV</th>
          <th>Stock</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($productos as $p): ?>
        <tr>
          <td><?= htmlspecialchars($p->getCodigo()) ?></td>
          <td><?= htmlspecialchars($p->getNombre()) ?></td>
          <td class="precio">S/ <?= number_format($p->getPrecio(), 2) ?></td>
          <td class="precio">S/ <?= number_format($p->precioConIGV(), 2) ?></td>
          <td <?= $p->getStock() === 0 ? 'class="sin-stock"' : '' ?>>
            <?= $p->getStock() ?> unidades
          </td>
          <td class="acciones">
            <a href="index.php?accion=editar-producto&codigo=<?= urlencode($p->getCodigo()) ?>" class="btn-editar">
              Editar
            </a>
            <button 
              class="btn-eliminar" 
              onclick="abrirModal('<?= htmlspecialchars($p->getCodigo()) ?>', '<?= htmlspecialchars($p->getNombre()) ?>')"
            >
              Eliminar
            </button>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php if ($totalPaginas > 1): ?>
<nav class="pagination">
    <ul style="display:flex; gap:5px; list-style:none; padding:0;">
        <?php if ($pagina > 1): ?>
            <li><a href="index.php?accion=listar&pagina=<?= $pagina - 1 ?>">&laquo; Anterior</a></li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <li>
                <a href="index.php?accion=listar&pagina=<?= $i ?>"
                   style="<?= $i === $pagina ? 'font-weight:bold; text-decoration:underline;' : '' ?>">
                    <?= $i ?>
                </a>
            </li>
        <?php endfor; ?>

        <?php if ($pagina < $totalPaginas): ?>
            <li><a href="index.php?accion=listar&pagina=<?= $pagina + 1 ?>">Siguiente &raquo;</a></li>
        <?php endif; ?>
    </ul>
</nav>
<?php endif; ?>
  </main>
</div>

<!-- MODAL ELIMINAR -->
<div id="modalEliminar" class="modal-overlay" style="display:none;">
    <div class="modal-caja">
        <div class="modal-icono">⚠️</div>
        <h3 class="modal-titulo">¿Eliminar producto?</h3>
        <p class="modal-mensaje">
            Vas a desactivar <strong id="modalNombreProducto"></strong>. 
            No aparecerá en el catálogo.
        </p>
        <div class="modal-botones">
            <button class="btn-cancelar" onclick="cerrarModal()">Cancelar</button>
            <a id="modalLinkConfirmar" href="#" class="btn-confirmar">Sí, eliminar</a>
        </div>
    </div>
</div>

<style>
.acciones {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}
.btn-editar {
    background-color: #4a8c6a;
    color: white;
    padding: 5px 12px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 0.85rem;
}
.btn-editar:hover {
    background-color: #3d7a5c;
}
.btn-eliminar {
    background-color: #e74c3c;
    color: white;
    border: none;
    padding: 5px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.85rem;
}
.btn-eliminar:hover {
    background-color: #c0392b;
}

/* Modal */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}
.modal-caja {
    background: white;
    border-radius: 10px;
    padding: 2rem;
    width: 90%;
    max-width: 400px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    animation: modalEntrar 0.2s ease;
}
@keyframes modalEntrar {
    from { transform: scale(0.85); opacity: 0; }
    to   { transform: scale(1);    opacity: 1; }
}
.modal-icono { font-size: 2.5rem; margin-bottom: 0.5rem; }
.modal-titulo { color: #2d6a4f; margin-bottom: 0.75rem; }
.modal-mensaje { color: #555; margin-bottom: 1.5rem; font-size: 0.95rem; }
.modal-botones { display: flex; gap: 1rem; justify-content: center; }
.btn-cancelar {
    background: #d4edda;
    color: #2d6a4f;
    border: none;
    padding: 0.6rem 1.4rem;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.95rem;
    font-weight: 600;
}
.btn-cancelar:hover { background: #b8dfc4; }
.btn-confirmar {
    background: #e74c3c;
    color: white;
    padding: 0.6rem 1.4rem;
    border-radius: 6px;
    text-decoration: none;
    font-size: 0.95rem;
    font-weight: 600;
}
.btn-confirmar:hover { background: #c0392b; }
</style>

<script>
function abrirModal(codigo, nombre) {
    document.getElementById('modalNombreProducto').textContent = nombre;
    document.getElementById('modalLinkConfirmar').href = 'index.php?accion=eliminar-producto&codigo=' + encodeURIComponent(codigo);
    document.getElementById('modalEliminar').style.display = 'flex';
}
function cerrarModal() {
    document.getElementById('modalEliminar').style.display = 'none';
}
document.getElementById('modalEliminar').addEventListener('click', function(e) {
    if (e.target === this) cerrarModal();
});
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>