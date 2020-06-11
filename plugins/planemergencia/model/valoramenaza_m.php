<?php

/**
 * Description of sys_dpto_m
 *
 * @author GIOVANNI ZARATE : Fecha:31/05/2019
 */
class valoramenaza_m extends fs_model{
    
    public $id_valoramenaza;
    public $descripcion;
    public $color;
    public $imgantes;
    public $imgdespues;
    
    public function __construct($d=FALSE) {
        parent::__construct('valoramenaza');
        if ($d) {
            $this->id_valoramenaza = $d['id_valoramenaza'];
            $this->descripcion = $d['descripcion'];
            $this->color = $d['color'];
            $this->imgantes = $d['imgantes'];
            $this->imgdespues = $d['imgdespues'];
        } else {
            $this->id_valoramenaza = 0;
            $this->descripcion = '';
            $this->color = '';
            $this->imgantes = '';
            $this->imgdespues = '';
        }
    }
    
    public function install() {
        $this->clean_cache();        
    }

    public function delete() {
        $this->clean_cache();
        return $this->db->exec("DELETE FROM " . $this->table_name . " WHERE id_valoramenaza = " . $this->var2str($this->id_valoramenaza) . ";");
    }

    public function exists() {
        if (is_null($this->id_valoramenaza)) {
            return FALSE;
        } else
            return $this->db->select("SELECT * FROM " . $this->table_name . " WHERE id_valoramenaza = " . $this->var2str($this->id_valoramenaza) . ";");
    }

    public function save() {
        if ($this->test()) {
            $this->clean_cache();
            if ($this->exists()) {
                $sql = "UPDATE " . $this->table_name . " "
                        . "SET descripcion = " . $this->var2str($this->descripcion) .
                        " color = " . $this->var2str($this->color) .
                        " imgantes = " . $this->var2str($this->imgantes) .
                        " imgdespues = " . $this->var2str($this->imgdespues) .
                        "  WHERE id_valoramenaza = " . $this->var2str($this->id_valoramenaza) . ";";
            } else {
                $sql = "INSERT INTO " . $this->table_name . 
                        " (descripcion,color,imgantes,imgdespues) VALUES
                     ("  . $this->var2str($this->descripcion) . ","
                        . ""  . $this->var2str($this->color) . ","
                        . ""  . $this->var2str($this->imgantes) . ","
                        . ""  . $this->var2str($this->imgdespues) . ");";
            }

            return $this->db->exec($sql);
        } else {
            return FALSE;
        }
    }
    
    
     /**
     * Limpiamos la caché
     */
    private function clean_cache() {
        $this->cache->delete('m_valoramenaza_all');
    }

    
     /**
     * Comprueba los datos del pais, devuelve TRUE si son correctos
     * @return boolean
     */
    public function test() {
        $status = FALSE;

       // $this->id_valoramenaza = trim($this->id_valoramenaza);
        $this->descripcion = $this->no_html($this->descripcion);

        if (strlen($this->descripcion) < 1 OR strlen($this->descripcion) > 50) {
            $this->new_error_msg("Nombre no válido.");
        } else
            $status = TRUE;

        return $status;
    }
    
    /**
     * Devuelve la url donde se pueden ver/modificar estos datos
     * @return string
     */
    public function url() {
        if (is_null($this->id_valoramenaza)) {
            return "index.php?page=tipo";
        } else
            return "index.php?page=tipo_edit&cod=" . $this->id_valoramenaza;
    }
    
    /**
     * Devuelve un array con profesiones.
     * @return \dpto
     */
    public function all() {
        /// leemos esta lista de la caché
        $lista = $this->cache->get_array('m_valoramenaza_all');
        if (!$lista) {
            /// si no está en caché, leemos de la base de datos
            $data = $this->db->select("SELECT id_valoramenaza,trim(descripcion) descripcion, color,imgantes, imgdespues "
                    . "FROM " . $this->table_name . "  ORDER BY descripcion ASC;");

            if ($data) {
                foreach ($data as $a) {
                    $lista[] = new valoramenaza_m($a);
                }
            }

            /// guardamos la lista en caché
            $this->cache->set('m_valoramenaza_all', $lista);
        }

        return $lista;
    }
    
    /**
     * Devuelve el empleado/agente con codagente = $cod
     * @param type $cod
     * @return \|boolean
     */
    public function get($cod) {
        $a = $this->db->select("SELECT id_valoramenaza,trim(descripcion) descripcion, color,imgantes, imgdespues "
                . "FROM " . $this->table_name . " WHERE id_valoramenaza = " . $this->var2str($cod) . ";");
        if ($a) {
            return new valoramenaza_m($a[0]);
        } else
            return FALSE;
    }
    
  
    
    //PARA EL COMBO POR DEFECTO
   public function is_default(){
      return FALSE;
   }
}
