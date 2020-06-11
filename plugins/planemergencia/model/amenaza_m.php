<?php


/**
 * Description of estudio medico
 *
 * @author INFO_14_GIOVANNI  13/08/2019
 */
class amenaza_m extends fs_model{
    public $id_amenaza;
    public $id_plan;    
    public $amenaza; 
    public $origen;
    public $id_tipo;
    public $clase;
    public $probabilidadantescontrol;
    public $impactoantescontrol;
    public $controlexistente;
    public $probabilidaddespuescontrol;
    public $impactodespuescontrol;
    
    public $tipodes;
    
    
    
    
    public function __construct($o = FALSE) {
        parent::__construct('amenaza');
        if($o){
            $this->id_amenaza = $o['id_amenaza'];
            $this->id_plan = $o['id_plan'];
            $this->amenaza = $o['amenaza'];            
            $this->origen = $o['origen'];
            $this->id_tipo = $o['id_tipo'];
            $this->clase = $o['clase'];
            $this->probabilidadantescontrol = $o['probabilidadantescontrol'];
            $this->impactoantescontrol = $o['impactoantescontrol'];
            $this->controlexistente = $o['controlexistente'];
            $this->probabilidaddespuescontrol = $o['probabilidaddespuescontrol'];
            $this->impactodespuescontrol = $o['impactodespuescontrol'];
            $this->tipodes = $o['tipodes'];
            
            
        }else{
            $this->id_amenaza = NULL;
            $this->id_plan = NULL;
            $this->amenaza ='';
            $this->origen = NULL;
            $this->id_tipo = 0;
            $this->clase = 0;
            $this->probabilidadantescontrol = '';
            $this->impactoantescontrol = '';
            $this->controlexistente = '';
            $this->probabilidaddespuescontrol = '';
            $this->impactodespuescontrol ='';
            $this->tipodes = '';
            
            
        }
    }

    protected function install() {
        
    }

    public function delete() {
        
    }

    public function exists() {
       if (is_null($this->id_amenaza)) {
            return FALSE;
        } else {
            return $this->db->select("SELECT * FROM " . $this->table_name . 
                    " WHERE id_amenaza = " . $this->var2str($this->id_amenaza) . ";");
        }  
    }

    public function save() {
        if ($this->test()) {
            if ($this->exists()) {
                $sql = "UPDATE " . $this->table_name . " SET  "
                        . "  amenaza = " . $this->var2str($this->amenaza)                        
                        . ", origen = " . $this->var2str($this->origen)
                        . ", id_tipo = " . $this->var2str($this->id_tipo)
                        . ", clase = " . $this->var2str($this->clase)
                        . ", probabilidadantescontrol = " . $this->var2str($this->probabilidadantescontrol)
                        . ", impactoantescontrol = " . $this->var2str($this->impactoantescontrol)
                        . "  WHERE id_amenaza = " . $this->var2str($this->id_amenaza) . ";";

            } else {
                //$this->new_numero();
                $sql = "INSERT INTO " . $this->table_name . " 
                    (id_plan,amenaza,origen,id_tipo,clase,probabilidadantescontrol,impactoantescontrol,
                    controlexistente,probabilidaddespuescontrol,impactodespuescontrol)
                   VALUES (" . $this->var2str($this->id_plan)
                        . "," . $this->var2str($this->amenaza)
                        . "," . $this->var2str($this->origen)
                        . "," . $this->var2str($this->id_tipo)
                        . "," . $this->var2str($this->clase)
                        . "," . $this->var2str($this->probabilidadantescontrol)
                        . "," . $this->var2str($this->impactoantescontrol)
                        . "," . $this->var2str($this->controlexistente)
                        . "," . $this->var2str($this->probabilidaddespuescontrol)
                        . "," . $this->var2str($this->impactodespuescontrol).");";        
            }
              return $this->db->exec($sql);
        }else {
            return FALSE;
        }
    }
    
    public function test() {
        $status = FALSE;

        $this->amenaza = trim($this->amenaza);
        $this->origen = trim($this->no_html($this->origen));
        $this->id_plan = trim($this->no_html($this->id_plan));

//        if ($this->origen!=0) {
//            if (empty($this->origen)){
//                   $this->new_error_msg("Médico no Puede estar vacio."); 
//            }            
//        } else 
        
        if (empty($this->id_plan)) {
            $this->new_error_msg("Plan no Puede estar vacio.");
        } else if (empty($this->amenaza)) {
            $this->new_error_msg("Amenaza no puede estar vacio.");        
        } else
            $status = TRUE;

        return $status;
    }
    
    public function url() {
        if (is_null($this->id_amenaza)) {
            return 'index.php?page=amenaza';
        } else
            return 'index.php?page=amenaza_edit&cod=' . trim ($this->id_amenaza);
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
                return new amenaza_m($repro[0]);
            } else
                return FALSE;
        } else
            return FALSE; 
    }
    
    public function getamenaza($id) {
        if (isset($id)) {
            $repro = $this->db->select("SELECT *  "
                    . "FROM " . $this->table_name . "   "
                    . "WHERE id_amenaza = " . $this->var2str($id) . ";");
            if ($repro) {
                return new amenaza_m($repro[0]);
            } else
                return FALSE;
        } else
            return FALSE; 
    }
   
    
    public function all_from_amenaza($cod)
    {
        
       /* SELECT *,b.descripcion bloquedes,d.descripcion dependenciades,t.descripcion tipodes,di.descripcion diades
        FROM amenaza c 
        JOIN bloque b ON c.amenaza=b.amenaza
        JOIN dependencia d ON c.origen=d.origen
        JOIN tipo t ON c.id_tipo=t.id_tipo
        JOIN dia di ON c.clase=di.clase*/
        
        $dirlist = array();
        $sql = "SELECT * ,t.descripcion tipodes "
                . "FROM " . $this->table_name . " c "
                . "JOIN tipo t ON c.id_tipo=t.id_tipo"
                . " WHERE id_plan = " . $this->var2str($cod)
            . " ORDER BY id_amenaza ;";

        
        $data = $this->db->select($sql);
        if ($data) {
            foreach ($data as $d) {
                $dirlist[] = new \amenaza_m($d);
            }
        }

        return $dirlist;
    }
    
    
    public function all() {
        /// leemos esta lista de la caché
        $lista = $this->cache->get_array('m_amenaza_all');
        if (!$lista) {
            /// si no está en caché, leemos de la base de datos
            $data = $this->db->select("SELECT * FROM " . $this->table_name . ";");

            if ($data) {
                foreach ($data as $a) {
                    $lista[] = new amenaza_m($a);
                }
            }

            /// guardamos la lista en caché
            $this->cache->set('m_amenaza_all', $lista);
        }

        return $lista;
    }
    
    
    public function elimina_amenaza($ciconyuge){       
        $sql = "DELETE FROM " . $this->table_name . " " .                                                             
                "  WHERE id_amenaza = " . $this->var2str($ciconyuge) . ";";
         return $this->db->exec($sql);
    }
   
    
    
    

}
