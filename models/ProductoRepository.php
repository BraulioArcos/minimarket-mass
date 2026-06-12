<?php
declare(strict_types=1);
require_once __DIR__ . '/Producto.php';
require_once __DIR__ . '/../config/conexion.php';

class ProductoRepository {

    public function obtenerTodos(): array {
        try {
            $pdo = getConexion();

            $stmt = $pdo->query(
                "SELECT codigo_barras AS codigo, nombre, precio, stock
                 FROM productos
                 WHERE activo = 1
                 ORDER BY nombre"
            );

            $productos = [];
            foreach ($stmt->fetchAll() as $f) {
                $productos[] = new Producto(
                    $f['codigo'],
                    $f['nombre'],
                    (float) $f['precio'],
                    (int)   $f['stock']
                );
            }
            return $productos;

        } catch (PDOException $e) {
            error_log('[ProductoRepository::obtenerTodos] ' . $e->getMessage());
            return [];
        }
    }

    public function buscarPorCodigo(string $codigo): ?Producto {
        try {
            $pdo = getConexion();

            $stmt = $pdo->prepare(
                "SELECT codigo_barras AS codigo, nombre, precio, stock
                 FROM productos
                 WHERE codigo_barras = :codigo
                 AND activo = 1"
            );
            $stmt->execute([':codigo' => $codigo]);

            $fila = $stmt->fetch();
            if ($fila === false) {
                return null;
            }

            return new Producto(
                $fila['codigo'],
                $fila['nombre'],
                (float) $fila['precio'],
                (int)   $fila['stock']
            );

        } catch (PDOException $e) {
            error_log('[ProductoRepository::buscarPorCodigo] ' . $e->getMessage());
            return null;
        }
    }

    public function buscarPorNombre(string $termino): array {
        try {
            $pdo = getConexion();

            $stmt = $pdo->prepare(
                "SELECT codigo_barras AS codigo, nombre, precio, stock
                 FROM productos
                 WHERE nombre LIKE :termino
                 AND activo = 1
                 ORDER BY nombre"
            );
            $stmt->execute([':termino' => '%' . $termino . '%']);

            $productos = [];
            foreach ($stmt->fetchAll() as $f) {
                $productos[] = new Producto(
                    $f['codigo'],
                    $f['nombre'],
                    (float) $f['precio'],
                    (int)   $f['stock']
                );
            }
            return $productos;

        } catch (PDOException $e) {
            error_log('[ProductoRepository::buscarPorNombre] ' . $e->getMessage());
            return [];
        }
    }

    public function obtenerPorCategoria(int $categoriaId): array {
        try {
            $pdo = getConexion();

            $stmt = $pdo->prepare(
                "SELECT codigo_barras AS codigo, nombre, precio, stock
                 FROM productos
                 WHERE categoria_id = :id
                 AND activo = 1
                 ORDER BY nombre"
            );
            $stmt->execute([':id' => $categoriaId]);

            $productos = [];
            foreach ($stmt->fetchAll() as $f) {
                $productos[] = new Producto(
                    $f['codigo'],
                    $f['nombre'],
                    (float) $f['precio'],
                    (int)   $f['stock']
                );
            }
            return $productos;

        } catch (PDOException $e) {
            error_log('[ProductoRepository::obtenerPorCategoria] ' . $e->getMessage());
            return [];
        }
    }

    public function obtenerBajoStock(int $umbral): array {
        try {
            $pdo = getConexion();

            $stmt = $pdo->prepare(
                "SELECT codigo_barras AS codigo, nombre, precio, stock
                 FROM productos
                 WHERE stock < :umbral
                 AND activo = 1
                 ORDER BY stock ASC"
            );
            $stmt->execute([':umbral' => $umbral]);

            $productos = [];
            foreach ($stmt->fetchAll() as $f) {
                $productos[] = new Producto(
                    $f['codigo'],
                    $f['nombre'],
                    (float) $f['precio'],
                    (int)   $f['stock']
                );
            }
            return $productos;

        } catch (PDOException $e) {
            error_log('[ProductoRepository::obtenerBajoStock] ' . $e->getMessage());
            return [];
        }
    }

    public function contarTotalProductos(): int {
        try {
            $pdo = getConexion();
            $stmt = $pdo->query("SELECT COUNT(*) FROM productos WHERE activo = 1");
            return (int) $stmt->fetchColumn();

        } catch (PDOException $e) {
            error_log('[ProductoRepository::contarTotalProductos] ' . $e->getMessage());
            return 0;
        }
    }

    public function obtenerMasCaros(int $limite): array {
        try {
            $pdo = getConexion();

            $stmt = $pdo->prepare(
                "SELECT codigo_barras AS codigo, nombre, precio, stock
                 FROM productos
                 WHERE activo = 1
                 ORDER BY precio DESC
                 LIMIT :limite"
            );
            $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
            $stmt->execute();

            $productos = [];
            foreach ($stmt->fetchAll() as $f) {
                $productos[] = new Producto(
                    $f['codigo'],
                    $f['nombre'],
                    (float) $f['precio'],
                    (int)   $f['stock']
                );
            }
            return $productos;

        } catch (PDOException $e) {
            error_log('[ProductoRepository::obtenerMasCaros] ' . $e->getMessage());
            return [];
        }
    }

    public function obtenerPaginado(int $limite, int $offset): array {
        try {
            $pdo = getConexion();

            $stmt = $pdo->prepare(
                "SELECT codigo_barras AS codigo, nombre, precio, stock
                 FROM productos
                 WHERE activo = 1
                 ORDER BY nombre ASC
                 LIMIT :limite OFFSET :offset"
            );
            $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            $productos = [];
            foreach ($stmt->fetchAll() as $f) {
                $productos[] = new Producto(
                    $f['codigo'],
                    $f['nombre'],
                    (float) $f['precio'],
                    (int)   $f['stock']
                );
            }
            return $productos;

        } catch (PDOException $e) {
            error_log('[ProductoRepository::obtenerPaginado] ' . $e->getMessage());
            return [];
        }
    }

    public function crear(array $d): bool {
        try {
            $pdo  = getConexion();
            $stmt = $pdo->prepare(
                "INSERT INTO productos (codigo_barras, nombre, marca, categoria_id, precio, stock)
                 VALUES (:codigo, :nombre, :marca, :categoria, :precio, :stock)"
            );
            return $stmt->execute([
                ':codigo'    => $d['codigo'],
                ':nombre'    => $d['nombre'],
                ':marca'     => $d['marca'],
                ':categoria' => $d['categoria'],
                ':precio'    => $d['precio'],
                ':stock'     => $d['stock'],
            ]);
        } catch (PDOException $e) {
            error_log('[ProductoRepository::crear] ' . $e->getMessage());
            return false;
        }
    }

    public function actualizar(Producto $producto): bool {
        try {
            $pdo  = getConexion();
            $stmt = $pdo->prepare(
                "UPDATE productos
                 SET nombre = :nombre, precio = :precio, stock = :stock
                 WHERE codigo_barras = :codigo
                 AND activo = 1"
            );
            return $stmt->execute([
                ':nombre' => $producto->getNombre(),
                ':precio' => $producto->getPrecio(),
                ':stock'  => $producto->getStock(),
                ':codigo' => $producto->getCodigo(),
            ]);
        } catch (PDOException $e) {
            error_log('[ProductoRepository::actualizar] ' . $e->getMessage());
            return false;
        }
    }

    public function desactivar(string $codigo_barras): bool {
        try {
            $pdo  = getConexion();
            $stmt = $pdo->prepare(
                "UPDATE productos SET activo = 0 WHERE codigo_barras = ?"
            );
            return $stmt->execute([$codigo_barras]);
        } catch (PDOException $e) {
            error_log('[ProductoRepository::desactivar] ' . $e->getMessage());
            return false;
        }
    }
}