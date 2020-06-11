<?php

/**
 * Description of sys_dpto_m
 *
 * @author GIOVANNI ZARATE : Fecha:31/05/2019
 */
class dia_m extends fs_model{
    
    public $id_dia;
    public $descripcion;
    
    public function __construct($d=FALSE) {
        parent::__construct('dia');
        if ($d) {
            $this->id_dia = $d['id_dia'];
            $this->descripcion = $d['descripcion'];
        } else {
            $this->id_dia = 0;
            $this->descripcion = '';
        }
    }
    
    public function install() {
        $this->clean_cache();        
    }

    public function delete() {
        $this->clean_cache();
        return $this->db->exec("DELETE FROM " . $this->table_name . " WHERE id_dia = " . $this->var2str($this->id_dia) . ";");
    }

    public function exists() {
        if (is_null($this->id_dia)) {
            return FALSE;
        } else
            return $this->db->select("SELECT * FROM " . $this->table_name . " WHERE id_dia = " . $this->var2str($this->id_dia) . ";");
    }

    public function save() {
        if ($this->test()) {
            $this->clean_cache();
            if ($this->exists()) {
                $sql = "UPDATE " . $this->table_name . " SET descripcion = " . $this->var2str($this->descripcion) .
                        "  WHERE id_dia = " . $this->var2str($this->id_dia) . ";";
            } else {
                $sql = "INSERT INTO " . $this->table_name . " (descripcion) VALUES
                     ("  . $this->var2str($this->descripcion) . ");";
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
        $this->cache->delete('m_dia_all');
    }

    
     /**
     * Comprueba los datos del pais, devuelve TRUE si son correctos
     * @return boolean
     */
    public function test() {
        $status = FALSE;

       // $this->id_dia = trim($this->id_dia);
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
        if (is_null($this->id_dia)) {
            return "index.php?page=dia";
        } else
            return "index.php?page=dia_edit&cod=" . $this->id_dia;
    }
    
    /**
     * Devuelve un array con profesiones.
     * @return \dpto
     */
    public function all() {
        /// leemos esta lista de la caché
        $lista = $this->cache->get_array('m_dia_all');
        if (!$lista) {
            /// si no está en caché, leemos de la base de datos
            $data = $this->db->select("SELECT id_dia,trim(descripcion) descripcion "
                    . "FROM " . $this->table_name . "  ORDER BY id_dia ASC;");

            if ($data) {
                foreach ($data as $a) {
                    $lista[] = new dia_m($a);
                }
            }

            /// guardamos la lista en caché
            $this->cache->set('m_dia_all', $lista);
        }

        return $lista;
    }
    
    /**
     * Devuelve el empleado/agente con codagente = $cod
     * @param type $cod
     * @return \|boolean
     */
    public function get($cod) {
        $a = $this->db->select("SELECT id_dia,trim(descripcion) descripcion "
                . "FROM " . $this->table_name . " WHERE id_dia = " . $this->var2str($cod) . ";");
        if ($a) {
            return new dia_m($a[0]);
        } else
            return FALSE;
    }
    
  
    
    //PARA EL COMBO POR DEFECTO
   public function is_default(){
      return FALSE;
   }
}
