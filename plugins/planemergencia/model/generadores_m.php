<?php


/**
 * Description of estudio medico
 *
 * @author INFO_14_GIOVANNI  10/08/2019
 */
class generadores_m extends fs_model{
    public $id_generadores;
    public $id_plan;    
    public $descripcion;
    public $capacidad;
    
    
    public function __construct($o = FALSE) {
        parent::__construct('generadores');
        if($o){
            $this->id_generadores = $o['id_generadores'];
            $this->id_plan = $o['id_plan'];
            $this->descripcion = $o['descripcion'];            
            $this->capacidad = $o['capacidad'];
            
        }else{
            $this->id_generadores = NULL;
            $this->id_plan = NULL;
            $this->descripcion ='';
            $this->capacidad = NULL;
            
        }
    }

    protected function install() {
        
    }

    public function delete() {
        
    }

    public function exists() {
       if (is_null($this->id_generadores)) {
            return FALSE;
        } else {
            return $this->db->select("SELECT * FROM " . $this->table_name . " WHERE id_generadores = " . $this->var2str($this->id_generadores) . ";");
        }  
    }

    public function save() {
        if ($this->test()) {
            if ($this->exists()) {
                $sql = "UPDATE " . $this->table_name . " SET  "
                        . "  descripcion = " . $this->var2str($this->descripcion)                        
                        . ", capacidad = " . $this->var2str($this->capacidad)                                                 
                        . "  WHERE id_generadores = " . $this->var2str($this->id_generadores) . ";";

            } else {
                //$this->new_numero();
                $sql = "INSERT INTO " . $this->table_name . " (id_plan,descripcion,capacidad)
                   VALUES (" . $this->var2str($this->id_plan)
                        . "," . $this->var2str($this->descripcion)
                        . "," . $this->var2str($this->capacidad).");";        
            }
              return $this->db->exec($sql);
        }else {
            return FALSE;
        }
    }
    
    public function test() {
        $status = FALSE;

        $this->capacidad = trim($this->capacidad);
        $this->capacidad = trim($this->no_html($this->capacidad));
        $this->id_plan = trim($this->no_html($this->id_plan));

//        if ($this->capacidad!=0) {
//            if (empty($this->capacidad)){
//                   $this->new_error_msg("Médico no Puede estar vacio."); 
//            }            
//        } else 
        
        if (empty($this->id_plan)) {
            $this->new_error_msg("Plan no Puede estar vacio.");
        } else if (empty($this->descripcion)) {
            $this->new_error_msg("Descripcion no puede estar vacio.");        
        } else
            $status = TRUE;

        return $status;
    }
    
    public function url() {
        if (is_null($this->id_generadores)) {
            return 'index.php?page=generadores';
        } else
            return 'index.php?page=generadores_edit&cod=' . trim ($this->id_generadores);
    }

     /**
     * Devuelve el asiento con el $id solicitado.
     * @param type $id
     * @return \asiento|boolean
     */
    public function get($id) {
        if (isset($id)) {
            $repro = $this->db->select("SELECT * "
                    . "FROM " . $this->table_name . " h  "
                    . "WHERE id_plan = " . $this->var2str($id) . ";");
            if ($repro) {
                return new generadores_m($repro[0]);
            } else
                return FALSE;
        } else
            return FALSE; 
    }
    
    public function getgeneradores($id) {
        if (isset($id)) {
            $repro = $this->db->select("SELECT *  "
                    . "FROM " . $this->table_name . "   "
                    . "WHERE id_generadores = " . $this->var2str($id) . ";");
            if ($repro) {
                return new generadores_m($repro[0]);
            } else
                return FALSE;
        } else
            return FALSE; 
    }
   
    
    public function all_from_generadores($cod)
    {
        $dirlist = array();
        $sql = "SELECT *  "
                . "FROM " . $this->table_name . " "
                . " WHERE id_plan = " . $this->var2str($cod)
            . " ORDER BY id_generadores ;";

        $data = $this->db->select($sql);
        if ($data) {
            foreach ($data as $d) {
                $dirlist[] = new \generadores_m($d);
            }
        }

        return $dirlist;
    }
    
    
    public function all() {
        /// leemos esta lista de la caché
        $lista = $this->cache->get_array('m_generadores_all');
        if (!$lista) {
            /// si no está en caché, leemos de la base de datos
            $data = $this->db->select("SELECT * FROM " . $this->table_name . ";");

            if ($data) {
                foreach ($data as $a) {
                    $lista[] = new generadores_m($a);
                }
            }

            /// guardamos la lista en caché
            $this->cache->set('m_generadores_all', $lista);
        }

        return $lista;
    }
    
    
    public function elimina_generador($ciconyuge){       
        $sql = "DELETE FROM " . $this->table_name . " " .                                                             
                "  WHERE id_generadores = " . $this->var2str($ciconyuge) . ";";
         return $this->db->exec($sql);
    }
   
    
    
    

}
