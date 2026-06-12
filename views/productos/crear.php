<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/navbar.php'; ?>

<style>
  .card-formulario {
    max-width: 460px;
    margin: 30px auto;
    background: #fff;
    border-radius: 12px;
    padding: 26px;
    box-shadow: 0 8px 25px rgba(0,0,0,.08);
  }
  .card-formulario h1 { color: #0066B3; font-size: 21px; margin-bottom: 16px; margin-top: 0; }
  .card-formulario label { display: block; font-size: 13px; font-weight: 600; margin: 12px 0 4px; color: #333; text-align: left; }
  .card-formulario input, .card-formulario select { width: 100%; padding: 10px; border: 1px solid #d7dde6; border-radius: 8px; font-size: 14px; }
  .card-formulario button { width: 100%; margin-top: 18px; padding: 11px; border: none; border-radius: 8px; background: #0066B3; color: #fff; font-weight: 700; font-size: 15px; cursor: pointer; }
  .card-formulario .error { background: #fef2f2; border: 1px solid #f3c2c2; color: #b91c1c; padding: 10px; border-radius: 8px; font-size: 13px; margin-bottom: 8px; }
  .card-formulario a { color: #0066B3; font-size: 13px; text-decoration: none; }
</style>

<div class="contenedor">
  <?php require __DIR__ . '/../layout/sidebar.php'; ?>
  
  <main class="contenido">
    
    <div class="card-formulario">
      <h1>Registrar nuevo producto</h1>
      
      <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" action="index.php?accion=guardar-producto">
        <label>Código de barras</label>
        <input type="text" name="codigo" required>
        
        <label>Nombre</label>
        <input type="text" name="nombre" required>
        
        <label>Marca</label>
        <input type="text" name="marca">
        
        <label>Categoría</label>
        <select name="categoria">
          <option value="1">Abarrotes</option>
          <option value="2">Bebidas</option>
          <option value="3">Lácteos</option>
          <option value="4">Limpieza</option>
          <option value="5">Aseo Personal</option>
          <option value="6">Panadería</option>
          <option value="7">Frutas y Verduras</option>
        </select>
        
        <label>Precio (S/)</label>
        <input type="number" step="0.01" name="precio" required>
        
        <label>Stock</label>
        <input type="number" name="stock" required>
        
        <button type="submit">Guardar producto</button>
      </form>
      
      <div style="margin-top: 12px;">
          <a href="index.php?accion=catalogo" 
             style="display: block; 
                    width: 100%; 
                    text-align: center; 
                    padding: 11px; 
                    border: 1px solid #ced4da; 
                    border-radius: 8px; 
                    background: #f8f9fa; 
                    color: #495057; 
                    font-weight: 700; 
                    font-size: 15px; 
                    text-decoration: none; 
                    transition: background 0.2s;"
             onmouseover="this.style.background='#e9ecef'" 
             onmouseout="this.style.background='#f8f9fa'">
             ← Volver al catálogo
          </a>
      </div>

    </div>

  </main>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>