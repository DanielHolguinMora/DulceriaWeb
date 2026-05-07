<?php

class Producto
{
    private $conn;
    private $table_name = "productos";

    public $id;
    public $categoria_id;
    public $marca_id;
    public $nombre;
    public $precio;
    public $imagen_frontal;
    public $imagen_trasera;
    public $descripcion;
    public $stock;
    public $categoria_nombre;
    public $marca_nombre;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function readAll($categoria_id = null, $search = null)
    {
        $query = "SELECT p.*, c.nombre as categoria_nombre, m.nombre as marca_nombre 
                  FROM " . $this->table_name . " p
                  LEFT JOIN categoria c ON p.categoria_id = c.id
                  LEFT JOIN marca m ON p.marca_id = m.id
                  WHERE 1=1";

        if ($categoria_id) {
            $query .= " AND p.categoria_id = :categoria_id";
        }

        if ($search) {
            $query .= " AND p.nombre LIKE :search";
        }

        $query .= " ORDER BY p.id DESC";

        $stmt = $this->conn->prepare($query);

        if ($categoria_id) {
            $stmt->bindParam(':categoria_id', $categoria_id);
        }

        if ($search) {
            $searchParam = "%{$search}%";
            $stmt->bindParam(':search', $searchParam);
        }

        $stmt->execute();
        return $stmt;
    }

    /**
     * @param array $params
     * @return PDOStatement|bool
     */
    public function readFiltered($params = [])
    {
        $query = "SELECT p.*, c.nombre as categoria_nombre, m.nombre as marca_nombre 
                  FROM " . $this->table_name . " p
                  LEFT JOIN categoria c ON p.categoria_id = c.id
                  LEFT JOIN marca m ON p.marca_id = m.id
                  WHERE 1=1";

        if (!empty($params['search'])) {
            $query .= " AND (p.nombre LIKE :search OR p.descripcion LIKE :search)";
        }

        if (!empty($params['categorias']) && is_array($params['categorias'])) {
            $catIds = implode(',', array_map('intval', $params['categorias']));
            if (!empty($catIds)) {
                $query .= " AND p.categoria_id IN ($catIds)";
            }
        }

        if (!empty($params['marcas']) && is_array($params['marcas'])) {
            $marcaIds = implode(',', array_map('intval', $params['marcas']));
            if (!empty($marcaIds)) {
                $query .= " AND p.marca_id IN ($marcaIds)";
            }
        }

        $orderBy = "p.id DESC";
        if (!empty($params['order'])) {
            switch ($params['order']) {
                case 'alpha_asc':
                    $orderBy = "p.nombre ASC";
                    break;
                case 'alpha_desc':
                    $orderBy = "p.nombre DESC";
                    break;
                case 'price_asc':
                    $orderBy = "p.precio ASC";
                    break;
                case 'price_desc':
                    $orderBy = "p.precio DESC";
                    break;
                case 'relevance':
                    $orderBy = "p.id DESC";
                    break;
            }
        }
        $query .= " ORDER BY $orderBy";

        $stmt = $this->conn->prepare($query);

        if (!empty($params['search'])) {
            $searchParam = "%{$params['search']}%";
            $stmt->bindParam(':search', $searchParam);
        }

        $stmt->execute();
        return $stmt;
    }

    public function readOne()
    {
        $query = "SELECT p.*, c.nombre as categoria_nombre, m.nombre as marca_nombre 
                  FROM " . $this->table_name . " p
                  LEFT JOIN categoria c ON p.categoria_id = c.id
                  LEFT JOIN marca m ON p.marca_id = m.id
                  WHERE p.id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->nombre = $row['nombre'];
            $this->precio = $row['precio'];
            $this->imagen_frontal = $row['imagen_frontal'];
            $this->imagen_trasera = $row['imagen_trasera'];
            $this->descripcion = $row['descripcion'];
            $this->stock = $row['stock'];
            $this->categoria_id = $row['categoria_id'];
            $this->marca_id = $row['marca_id'];
            $this->categoria_nombre = $row['categoria_nombre'];
            $this->marca_nombre = $row['marca_nombre'];
            return true;
        }
        return false;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET categoria_id=:categoria_id, marca_id=:marca_id, nombre=:nombre, precio=:precio, 
                      imagen_frontal=:imagen_frontal, imagen_trasera=:imagen_trasera, 
                      descripcion=:descripcion, stock=:stock";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));

        $stmt->bindParam(":categoria_id", $this->categoria_id);
        $stmt->bindParam(":marca_id", $this->marca_id);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":imagen_frontal", $this->imagen_frontal);
        $stmt->bindParam(":imagen_trasera", $this->imagen_trasera);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":stock", $this->stock);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update()
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET categoria_id=:categoria_id, marca_id=:marca_id, nombre=:nombre, precio=:precio, 
                      descripcion=:descripcion, stock=:stock";

        if (!empty($this->imagen_frontal)) {
            $query .= ", imagen_frontal=:imagen_frontal";
        }
        if (!empty($this->imagen_trasera)) {
            $query .= ", imagen_trasera=:imagen_trasera";
        }

        $query .= " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));

        $stmt->bindParam(":categoria_id", $this->categoria_id);
        $stmt->bindParam(":marca_id", $this->marca_id);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":stock", $this->stock);
        $stmt->bindParam(":id", $this->id);

        if (!empty($this->imagen_frontal)) {
            $stmt->bindParam(":imagen_frontal", $this->imagen_frontal);
        }
        if (!empty($this->imagen_trasera)) {
            $stmt->bindParam(":imagen_trasera", $this->imagen_trasera);
        }

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>