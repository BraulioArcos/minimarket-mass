<?php require __DIR__ . '/../layout/navbar.php'; ?>
<?php require __DIR__ . '/../layout/sidebar.php'; ?>

<main>
  <h1>✏️ Editar producto</h1>

  <?php if (!empty($error)): ?>
    <div style="background:#fef2f2;border:1px solid #f3c2c2;color:#b91c1c;padding:10px;border-radius:8px;font-size:13px;margin-bottom:16px;">
      <?= htmlspecialchars($error) ?>
    </div>
  <?php endif; ?>

  <div style="background:white;border-radius:12px;padding:28px;max-width:480px;box-shadow:0 2px 8px rgba(0,0,0,.07);">
    <form method="POST" action="index.php?accion=actualizar-producto">
      <input type="hidden" name="codigo" value="<?= htmlspecialchars($producto->getCodigo()) ?>">

      <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px;">Código de barras</label>
      <input type="text" value="<?= htmlspecialchars($producto->getCodigo()) ?>" readonly
             style="width:100%;padding:10px;border:1px solid #d7dde6;border-radius:8px;font-size:14px;background:#f0f2f5;color:#888;margin-bottom:14px;">

      <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px;">Nombre</label>
      <input type="text" name="nombre" value="<?= htmlspecialchars($producto->getNombre()) ?>" required
             style="width:100%;padding:10px;border:1px solid #d7dde6;border-radius:8px;font-size:14px;margin-bottom:14px;">

      <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px;">Precio (S/)</label>
      <input type="number" name="precio" step="0.01" min="0" value="<?= htmlspecialchars((string)$producto->getPrecio()) ?>" required
             style="width:100%;padding:10px;border:1px solid #d7dde6;border-radius:8px;font-size:14px;margin-bottom:14px;">

      <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px;">Stock</label>
      <input type="number" name="stock" min="0" value="<?= htmlspecialchars((string)$producto->getStock()) ?>" required
             style="width:100%;padding:10px;border:1px solid #d7dde6;border-radius:8px;font-size:14px;margin-bottom:20px;">

      <button type="submit"
              style="width:100%;padding:11px;border:none;border-radius:8px;background:#4a8c6a;color:#fff;font-weight:700;font-size:15px;cursor:pointer;">
        💾 Guardar cambios
      </button>
    </form>
    <p style="margin-top:14px;font-size:13px;">
      <a href="index.php?accion=catalogo" style="color:#4a8c6a;">← Volver al catálogo</a>
    </p>
  </div>
</main>

<?php require __DIR__ . '/../layout/footer.php'; ?>