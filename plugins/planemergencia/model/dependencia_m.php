<?php

/**
 * Description of sys_dpto_m
 *
 * @author GIOVANNI ZARATE : Fecha:31/05/2019
 */
class dependencia_m extends fs_model{
    
    public $id_dependencia;
    public $descripcion;
    
    public function __construct($d=FALSE) {
        parent::__construct('dependencia');
        if ($d) {
            $this->id_dependencia = $d['id_dependencia'];
            $this->descripcion = $d['descripcion'];
        } else {
            $this->id_dependencia = 0;
            $this->descripcion = '';
        }
    }
    
    public function install() {
        $this->clean_cache();        
    }

    public function delete() {
        $this->clean_cache();
        return $this->db->exec("DELETE FROM " . $this->table_name . " WHERE id_dependencia = " . $this->var2str($this->id_dependencia) . ";");
    }

    public function exists() {
        if (is_null($this->id_dependencia)) {
            return FALSE;
        } else
            return $this->db->select("SELECT * FROM " . $this->table_name . " WHERE id_dependencia = " . $this->var2str($this->id_dependencia) . ";");
    }

    public function save() {
        if ($this->test()) {
            $this->clean_cache();
            if ($this->exists()) {
                $sql = "UPDATE " . $this->table_name . " SET descripcion = " . $this->var2str($this->descripcion) .
                        "  WHERE id_dependencia = " . $this->var2str($this->id_dependencia) . ";";
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
        $this->cache->delete('m_dependencia_all');
    }

    
     /**
     * Comprueba los datos del pais, devuelve TRUE si son correctos
     * @return boolean
     */
    public function test() {
        $status = FALSE;

       // $this->id_dependencia = trim($this->id_dependencia);
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
        if (is_null($this->id_dependencia)) {
            return "index.php?page=dependencia";
        } else
            return "index.php?page=dependencia_edit&cod=" . $this->id_dependencia;
    }
    
    /**
     * Devuelve un array con profesiones.
     * @return \dpto
     */
    public function all() {
        /// leemos esta lista de la caché
        $lista = $this->cache->get_array('m_dependencia_all');
        if (!$lista) {
            /// si no está en caché, leemos de la base de datos
            $data = $this->db->select("SELECT id_dependencia,trim(descripcion) descripcion FROM " . $this->table_name . "  ORDER BY descripcion ASC;");

            if ($data) {
                foreach ($data as $a) {
                    $lista[] = new dependencia_m($a);
                }
            }

            /// guardamos la lista en caché
            $this->cache->set('m_dependencia_all', $lista);
        }

        return $lista;
    }
    
    /**
     * Devuelve el empleado/agente con codagente = $cod
     * @param type $cod
     * @return \|boolean
     */
    public function get($cod) {
        $a = $this->db->select("SELECT id_dependencia,trim(descripcion) descripcion "
                . "FROM " . $this->table_name . " WHERE id_dependencia = " . $this->var2str($cod) . ";");
        if ($a) {
            return new dependencia_m($a[0]);
        } else
            return FALSE;
    }
    
  
    
    //PARA EL COMBO POR DEFECTO
   public function is_default(){
      return FALSE;
   }
}
