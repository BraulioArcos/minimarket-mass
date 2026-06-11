<?php $u = usuarioActual(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Minimarket Mass</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Arial, sans-serif; }
    body { background: #f5f9f5; display: flex; flex-direction: column; min-height: 100vh; margin: 0; }

    /* NAVBAR */
    .navbar {
      background: #4a8c6a; color: #fff;
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 24px; height: 56px; position: sticky; top: 0; z-index: 100;
      box-shadow: 0 2px 8px rgba(0,0,0,.1);
    }
    .navbar .logo { font-size: 18px; font-weight: 800; letter-spacing: 1px; }
    .navbar .logo span { color: #d4edda; }
    .navbar .usuario { display: flex; align-items: center; gap: 14px; font-size: 14px; }
    .navbar .rol-badge {
      background: #d4edda; color: #2d6a4f;
      padding: 2px 10px; border-radius: 20px; font-size: 12px; font-weight: 700;
    }
    .navbar a.salir {
      background: #fff; color: #4a8c6a;
      padding: 6px 14px; border-radius: 8px;
      text-decoration: none; font-weight: 700; font-size: 13px;
      transition: background .2s;
    }
    .navbar a.salir:hover { background: #eaf4ec; }

    /* LAYOUT */
    .contenedor { display: flex; flex: 1; width: 100%; }

    /* SIDEBAR */
    .sidebar {
      width: 200px; min-width: 200px; background: #3d7a5c; padding: 20px 0;
      display: flex; flex-direction: column; min-height: calc(100vh - 56px - 40px);
    }
    .sidebar a {
      color: #d4edda; text-decoration: none;
      padding: 12px 20px; font-size: 14px; font-weight: 600;
      display: block; border-left: 3px solid transparent;
      transition: background .2s;
    }
    .sidebar a:hover { background: #2d6a4f; color: #fff; }
    .sidebar a.activo { background: #2d6a4f; color: #d4edda; border-left: 3px solid #d4edda; }
    .sidebar .separador { height: 1px; background: #2d6a4f; margin: 8px 16px; }
    .sidebar a.disabled { color: #8bbfa6; cursor: not-allowed; pointer-events: none; }

    /* MAIN */
    main { flex: 1; padding: 28px 32px; min-width: 0; }
    main h1 { color: #2d6a4f; border-bottom: 3px solid #b7dfc7; padding-bottom: 10px; margin-bottom: 18px; }
    table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 2px 8px rgba(0,0,0,.06); border-radius: 8px; overflow: hidden; }
    th { background: #4a8c6a; color: white; padding: 12px 14px; text-align: left; font-size: 14px; }
    td { padding: 10px 14px; border-bottom: 1px solid #eaf4ec; font-size: 14px; }
    tr:hover { background: #f0f8f2; }
    .precio { font-weight: bold; color: #2d6a4f; }
    .sin-stock { color: #c0392b; }

    /* BOTÓN NUEVO PRODUCTO */
    a[href*="nuevo-producto"] {
      display: inline-block; margin: 14px 0;
      padding: 10px 18px; background: #4a8c6a; color: #fff;
      border-radius: 8px; text-decoration: none; font-weight: 700;
      transition: background .2s;
    }
    a[href*="nuevo-producto"]:hover { background: #3d7a5c; }

    /* LINK EDITAR EN TABLA */
    td a { color: #4a8c6a; font-weight: 600; text-decoration: none; }
    td a:hover { text-decoration: underline; }

    /* FOOTER */
    .footer {
      background: #3d7a5c; color: #c2e0cc;
      text-align: center; padding: 12px;
      font-size: 12px;
    }
    .footer strong { color: #d4edda; }
  </style>
</head>
<body>

<nav class="navbar">
  <div class="logo">🛒 <span>MASS</span> · Sistema de Caja</div>
  <div class="usuario">
    👤 <strong><?= htmlspecialchars($u['nombre']) ?></strong>
    <span class="rol-badge"><?= htmlspecialchars(ucfirst($u['rol'])) ?></span>
    <?php if (!empty($u['ultimo_acceso'])): ?>
      <em style="font-size:12px;color:#d4edda;">
        Último acceso: <?= htmlspecialchars(date('d/m/Y H:i', strtotime($u['ultimo_acceso']))) ?>
      </em>
    <?php endif; ?>
    <a href="index.php?accion=logout" class="salir">Salir</a>
  </div>
</nav>

<div class="contenedor">