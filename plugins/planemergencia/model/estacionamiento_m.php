<?php


/**
 * Description of estudio medico
 *
 * @author INFO_14_GIOVANNI  10/08/2019
 */
class estacionamiento_m extends fs_model{
    public $id_estacionamiento;
    public $id_plan;    
    public $area;
    public $capacidad;
    
    
    
    public function __construct($o = FALSE) {
        parent::__construct('estacionamiento');
        if($o){
            $this->id_estacionamiento = $o['id_estacionamiento'];
            $this->id_plan = $o['id_plan'];
            $this->area = $o['area'];            
            $this->capacidad = $o['capacidad'];
            
        }else{
            $this->id_estacionamiento = NULL;
            $this->id_plan = NULL;
            $this->area ='';
            $this->capacidad = NULL;
            
        }
    }

    protected function install() {
        
    }

    public function delete() {
        
    }

    public function exists() {
       if (is_null($this->id_estacionamiento)) {
            return FALSE;
        } else {
            return $this->db->select("SELECT * FROM " . $this->table_name . " WHERE id_estacionamiento = " . $this->var2str($this->id_estacionamiento) . ";");
        }  
    }

    public function save() {
        if ($this->test()) {
            if ($this->exists()) {
                $sql = "UPDATE " . $this->table_name . " SET  "
                        . "  area = " . $this->var2str($this->area)                        
                        . ", capacidad = " . $this->var2str($this->capacidad)                                                 
                        . "  WHERE id_estacionamiento = " . $this->var2str($this->id_estacionamiento) . ";";

            } else {
                //$this->new_numero();
                $sql = "INSERT INTO " . $this->table_name . " (id_plan,area,capacidad)
                   VALUES (" . $this->var2str($this->id_plan)
                        . "," . $this->var2str($this->area)
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
        } else if (empty($this->area)) {
            $this->new_error_msg("Area no puede estar vacio.");        
        } else
            $status = TRUE;

        return $status;
    }
    
    public function url() {
        if (is_null($this->id_estacionamiento)) {
            return 'index.php?page=estacionamiento';
        } else
            return 'index.php?page=estacionamiento_edit&cod=' . trim ($this->id_estacionamiento);
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
                return new estacionamiento_m($repro[0]);
            } else
                return FALSE;
        } else
            return FALSE; 
    }
    
    public function getestacionamiento($id) {
        if (isset($id)) {
            $repro = $this->db->select("SELECT *  "
                    . "FROM " . $this->table_name . "   "
                    . "WHERE id_estacionamiento = " . $this->var2str($id) . ";");
            if ($repro) {
                return new estacionamiento_m($repro[0]);
            } else
                return FALSE;
        } else
            return FALSE; 
    }
   
    
    public function all_from_estacionamiento($cod)
    {
        $dirlist = array();
        $sql = "SELECT *  "
                . " FROM " . $this->table_name . " "
                . " WHERE id_plan = " . $this->var2str($cod)
            . " ORDER BY id_estacionamiento;";

        $data = $this->db->select($sql);
        if ($data) {
            foreach ($data as $d) {
                $dirlist[] = new \estacionamiento_m($d);
            }
        }

        return $dirlist;
    }
    
    
    public function all() {
        /// leemos esta lista de la caché
        $lista = $this->cache->get_array('m_estacionamiento_all');
        if (!$lista) {
            /// si no está en caché, leemos de la base de datos
            $data = $this->db->select("SELECT * FROM " . $this->table_name . ";");

            if ($data) {
                foreach ($data as $a) {
                    $lista[] = new estacionamiento_m($a);
                }
            }

            /// guardamos la lista en caché
            $this->cache->set('m_estacionamiento_all', $lista);
        }

        return $lista;
    }
    
   
    
     public function elimina_estacionamiento($ciconyuge){       
        $sql = "DELETE FROM " . $this->table_name . " " .                                                             
                "  WHERE id_estacionamiento = " . $this->var2str($ciconyuge) . ";";
         return $this->db->exec($sql);
    }
    
    
    

}
