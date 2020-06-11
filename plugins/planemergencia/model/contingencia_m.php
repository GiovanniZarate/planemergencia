<?php


/**
 * Description of estudio medico
 *
 * @author INFO_14_GIOVANNI  13/08/2019
 */
class contingencia_m extends fs_model{
    public $id_contingencia;
    public $id_plan;    
    public $id_bloque;
    public $id_dependencia;
    public $id_tipo;
    public $id_dia;
    public $hora_desde;
    public $hora_hasta;
    public $bloquedes;
    public $dependenciades;
    public $tipodes;
    public $diades;
    
    
    public function __construct($o = FALSE) {
        parent::__construct('contingencia');
        if($o){
            $this->id_contingencia = $o['id_contingencia'];
            $this->id_plan = $o['id_plan'];
            $this->id_bloque = $o['id_bloque'];            
            $this->id_dependencia = $o['id_dependencia'];
            $this->id_tipo = $o['id_tipo'];
            $this->id_dia = $o['id_dia'];
            $this->hora_desde = $o['hora_desde'];
            $this->hora_hasta = $o['hora_hasta'];
            $this->bloquedes = $o['bloquedes'];
            $this->dependenciades = $o['dependenciades'];
            $this->tipodes = $o['tipodes'];
            $this->diades = $o['diades'];
            
        }else{
            $this->id_contingencia = NULL;
            $this->id_plan = NULL;
            $this->id_bloque ='';
            $this->id_dependencia = NULL;
            $this->id_tipo = 0;
            $this->id_dia = 0;
            $this->hora_desde = '';
            $this->hora_hasta = '';
            $this->bloquedes = '';
            $this->dependenciades = '';
            $this->tipodes ='';
            $this->diades = '';
            
        }
    }

    protected function install() {
        
    }

    public function delete() {
        
    }

    public function exists() {
       if (is_null($this->id_contingencia)) {
            return FALSE;
        } else {
            return $this->db->select("SELECT * FROM " . $this->table_name . " WHERE id_contingencia = " . $this->var2str($this->id_contingencia) . ";");
        }  
    }

    public function save() {
        if ($this->test()) {
            if ($this->exists()) {
                $sql = "UPDATE " . $this->table_name . " SET  "
                        . "  id_bloque = " . $this->var2str($this->id_bloque)                        
                        . ", id_dependencia = " . $this->var2str($this->id_dependencia)
                        . ", id_tipo = " . $this->var2str($this->id_tipo)
                        . ", id_dia = " . $this->var2str($this->id_dia)
                        . ", hora_desde = " . $this->var2str($this->hora_desde)
                        . ", hora_hasta = " . $this->var2str($this->hora_hasta)
                        . "  WHERE id_contingencia = " . $this->var2str($this->id_contingencia) . ";";

            } else {
                //$this->new_numero();
                $sql = "INSERT INTO " . $this->table_name . " 
                    (id_plan,id_bloque,id_dependencia,id_tipo,id_dia,hora_desde,hora_hasta)
                   VALUES (" . $this->var2str($this->id_plan)
                        . "," . $this->var2str($this->id_bloque)
                        . "," . $this->var2str($this->id_dependencia)
                        . "," . $this->var2str($this->id_tipo)
                        . "," . $this->var2str($this->id_dia)
                        . "," . $this->var2str($this->hora_desde)
                        . "," . $this->var2str($this->hora_hasta).");";        
            }
              return $this->db->exec($sql);
        }else {
            return FALSE;
        }
    }
    
    public function test() {
        $status = FALSE;

        $this->id_bloque = trim($this->id_bloque);
        $this->id_dependencia = trim($this->no_html($this->id_dependencia));
        $this->id_plan = trim($this->no_html($this->id_plan));

//        if ($this->id_dependencia!=0) {
//            if (empty($this->id_dependencia)){
//                   $this->new_error_msg("Médico no Puede estar vacio."); 
//            }            
//        } else 
        
        if (empty($this->id_plan)) {
            $this->new_error_msg("Plan no Puede estar vacio.");
        } else if (empty($this->id_bloque)) {
            $this->new_error_msg("Bloque no puede estar vacio.");        
        } else
            $status = TRUE;

        return $status;
    }
    
    public function url() {
        if (is_null($this->id_contingencia)) {
            return 'index.php?page=contingencia';
        } else
            return 'index.php?page=contingencia_edit&cod=' . trim ($this->id_contingencia);
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
                return new contingencia_m($repro[0]);
            } else
                return FALSE;
        } else
            return FALSE; 
    }
    
    public function getcontingencia($id) {
        if (isset($id)) {
            $repro = $this->db->select("SELECT *  "
                    . "FROM " . $this->table_name . "   "
                    . "WHERE id_contingencia = " . $this->var2str($id) . ";");
            if ($repro) {
                return new contingencia_m($repro[0]);
            } else
                return FALSE;
        } else
            return FALSE; 
    }
   
    
    public function all_from_contingencia($cod)
    {
        
       /* SELECT *,b.descripcion bloquedes,d.descripcion dependenciades,t.descripcion tipodes,di.descripcion diades
        FROM contingencia c 
        JOIN bloque b ON c.id_bloque=b.id_bloque
        JOIN dependencia d ON c.id_dependencia=d.id_dependencia
        JOIN tipo t ON c.id_tipo=t.id_tipo
        JOIN dia di ON c.id_dia=di.id_dia*/
        
        $dirlist = array();
        $sql = "SELECT * ,b.descripcion bloquedes,d.descripcion dependenciades,t.descripcion tipodes,di.descripcion diades "
                . "FROM " . $this->table_name . " c "
                . "JOIN bloque b ON c.id_bloque=b.id_bloque
                JOIN dependencia d ON c.id_dependencia=d.id_dependencia
                JOIN tipo t ON c.id_tipo=t.id_tipo
                JOIN dia di ON c.id_dia=di.id_dia"
                . " WHERE id_plan = " . $this->var2str($cod)
            . " ORDER BY id_contingencia ;";

        
        $data = $this->db->select($sql);
        if ($data) {
            foreach ($data as $d) {
                $dirlist[] = new \contingencia_m($d);
            }
        }

        return $dirlist;
    }
    
    
    public function all() {
        /// leemos esta lista de la caché
        $lista = $this->cache->get_array('m_contingencia_all');
        if (!$lista) {
            /// si no está en caché, leemos de la base de datos
            $data = $this->db->select("SELECT * FROM " . $this->table_name . ";");

            if ($data) {
                foreach ($data as $a) {
                    $lista[] = new contingencia_m($a);
                }
            }

            /// guardamos la lista en caché
            $this->cache->set('m_contingencia_all', $lista);
        }

        return $lista;
    }
    
    
    public function elimina_contingencia($ciconyuge){       
        $sql = "DELETE FROM " . $this->table_name . " " .                                                             
                "  WHERE id_contingencia = " . $this->var2str($ciconyuge) . ";";
         return $this->db->exec($sql);
    }
   
    
    
    

}
