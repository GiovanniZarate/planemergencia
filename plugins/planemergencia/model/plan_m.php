<?php

/*
  FECHA CREACION = 31/05/2019 AUTOR = GIOVANNI ZARATE
 */

/**
 * Description of 
 *
 * @author GIOVANNI
 */
class plan_m extends fs_model {

    public $id_plan;
    public $introduccion;
    public $objetivos;
    public $alcance;
    public $politica;
    public $marco_legal;
    public $historia;
    public $plano_sitio;
    public $razon_social;
    public $ruc;
    public $direccion;
    public $telefono;    
    public $correo_electronico;
    public $actividad;    
    public $representante_legal;
    public $responsable_plan;
    public $id_departamento;
    public $id_ciudad;
    public $id_barrio;
    public $lindero_norte;
    public $lindero_sur;
    public $lindero_este;
    public $lindero_oeste;
    public $mapa_sector;
    public $fecha_construccion;
    public $nro_estructuras;
    public $nro_pisos;
    public $area_total;
    public $descripcion_techos;
    public $acabado_pisos;
    public $acabado_paredes;
    public $acabado_cielorrasos;
    public $acabado_divisiones;
    
    public $servicio_medico;
    public $servicio_medicopersonal;
    public $alcantarillado;
    public $acueducto;
    public $energia_electrica;
    public $telefono_servicio;
    public $gas_natural;
    public $gas_propano;
    public $ups;
    public $tanque_reserva;
    public $hidrantes_externo;
    public $redhidraulica_contraincendio;
    public $aire_acondicionado;
    public $organigrama_institucion;
    public $definicion;
    public $objetivo_especifico;

   
    public function __construct($c = FALSE) {
        parent::__construct('plan');
        if ($c) {
            $this->id_plan = $c['id_plan'];
            $this->introduccion = $c['introduccion'];
            $this->objetivos = $c['objetivos'];
            $this->alcance = $c['alcance'];
            $this->politica = $c['politica'];
            $this->marco_legal = $c['marco_legal'];
            $this->historia = $c['historia'];
            $this->plano_sitio = NULL;
            $this->razon_social = $c['razon_social'];
            $this->ruc = $c['ruc'];      
            $this->direccion = $c['direccion'];
            $this->telefono = $c['telefono'];                 
            $this->correo_electronico = $c['correo_electronico'];               
            $this->actividad =  $c['actividad']; 
            $this->representante_legal = $c['representante_legal'];     
            $this->responsable_plan = $c['responsable_plan'];     
            $this->id_departamento = $c['id_departamento'];     
            $this->id_ciudad = $c['id_ciudad'];   
            $this->id_barrio = $c['id_barrio'];   
            $this->lindero_norte = $c['lindero_norte'];   
            $this->lindero_sur = $c['lindero_sur'];   
            $this->lindero_este = $c['lindero_este'];   
            $this->lindero_oeste = $c['lindero_oeste'];   
            
            $this->mapa_sector = $c['mapa_sector']; ;
            
            $this->fecha_construccion = NULL;
            if ($c['fecha_construccion'] != '') {
                $this->fecha_construccion = Date('d-m-Y', strtotime($c['fecha_construccion']));
            }
             
            $this->nro_estructuras = $c['nro_estructuras'];
            $this->nro_pisos = $c['nro_pisos'];
            $this->area_total = $c['area_total'];
            $this->descripcion_techos = $c['descripcion_techos'];
            $this->acabado_pisos = $c['acabado_pisos'];
            $this->acabado_paredes = $c['acabado_paredes'];
            $this->acabado_cielorrasos = $c['acabado_cielorrasos'];
            $this->acabado_divisiones = $c['acabado_divisiones'];
            
            $this->servicio_medico = $c['servicio_medico'];
            $this->servicio_medicopersonal = $c['servicio_medicopersonal'];
            $this->alcantarillado = $c['alcantarillado'];
            $this->acueducto = $c['acueducto'];
            $this->energia_electrica = $c['energia_electrica'];
            $this->telefono_servicio = $c['telefono_servicio'];
            $this->gas_natural = $c['gas_natural'];
            $this->gas_propano = $c['gas_propano'];
            $this->ups = $c['ups'];
            $this->tanque_reserva = $c['tanque_reserva'];
            $this->hidrantes_externo = $c['hidrantes_externo'];
            $this->redhidraulica_contraincendio = $c['redhidraulica_contraincendio'];
            $this->aire_acondicionado = $c['aire_acondicionado'];
            $this->organigrama_institucion = $c['organigrama_institucion'];
            $this->definicion = $c['definicion'];
            $this->objetivo_especifico = $c['objetivo_especifico'];
            
        } else {
           $this->id_plan = 0;
            $this->introduccion = '';
            $this->objetivos = '';
            $this->alcance = '';
            $this->politica = '';
            $this->marco_legal = '';
            $this->historia = '';
            $this->plano_sitio = null;
            $this->razon_social = '';
            $this->ruc = '';      
            $this->direccion = '';
            $this->telefono = '';                 
            $this->correo_electronico = '';               
            $this->actividad =  '' ;
            $this->representante_legal = '';     
            $this->responsable_plan = '';     
            $this->id_departamento = 0;     
            $this->id_ciudad = 0;   
            $this->id_barrio = 0;   
            $this->lindero_norte = '';   
            $this->lindero_sur = '';   
            $this->lindero_este = '';   
            $this->lindero_oeste = '';   
            
            $this->mapa_sector = null;
            $this->fecha_construccion = Date('d-m-Y'); 
            $this->nro_estructuras = 0;
            $this->nro_pisos = 0;
            $this->area_total = 0;
            $this->descripcion_techos = '';
            $this->acabado_pisos = '';
            $this->acabado_paredes = '';
            $this->acabado_cielorrasos = '';
            $this->acabado_divisiones = '';
            
            $this->servicio_medico = '';
            $this->servicio_medicopersonal = '';
            $this->alcantarillado =  '';
            $this->acueducto =  '';
            $this->energia_electrica =  '';
            $this->telefono_servicio =  '';
            $this->gas_natural =  '';
            $this->gas_propano =  '';
            $this->ups =  '';
            $this->tanque_reserva =  '';
            $this->hidrantes_externo =  '';
            $this->redhidraulica_contraincendio =  '';
            $this->aire_acondicionado = '';
            $this->organigrama_instituacion = '';
            $this->definicion = '';
            $this->objetivo_especifico = '';
            
        }
    }

    protected function install() {
        $this->clean_cache();
    }

    public function delete() {
        $this->clean_cache();
        return $this->db->exec("DELETE FROM " . $this->table_name . " WHERE id_plan = " . $this->var2str($this->id_plan) . ";");
    }

    public function exists() {
        if (is_null($this->id_plan)) {
            return FALSE;
        } else
            return $this->db->select("SELECT * FROM " . $this->table_name . " WHERE id_plan = " . $this->var2str($this->id_plan) . ";");
    }

    public function save() {
        if ($this->test()) {
            $this->clean_cache();
            //$hoy = date("Y-m-d");
            if ($this->exists()) {
                $sql = "UPDATE " . $this->table_name . " SET " .                        
                        " introduccion=" . $this->var2str($this->introduccion) .
                        " ,objetivos=" . $this->var2str($this->objetivos) .
                        " ,alcance=" . $this->var2str($this->alcance) .
                        " ,politica=" . $this->var2str($this->politica) .
                        " ,marco_legal=" . $this->var2str($this->marco_legal) .
                        " ,historia=" . $this->var2str($this->historia) .
                        " ,plano_sitio=" . $this->var2str($this->plano_sitio) .
                        " ,razon_social=" . $this->var2str($this->razon_social) .
                        " ,ruc=" . $this->var2str($this->ruc) .
                        " ,direccion=" . $this->var2str($this->direccion) .
                        " ,telefono=" . $this->var2str($this->telefono) .      
                        " ,correo_electronico=" . $this->var2str($this->correo_electronico) .     
                        ", actividad = " . $this->var2str($this->actividad) .   
                        ", representante_legal = " . $this->var2str($this->representante_legal) .   
                        ", responsable_plan = " . $this->var2str($this->responsable_plan) .   
                        ", id_departamento = " . $this->var2str($this->id_departamento) .   
                        ", id_ciudad = " . $this->var2str($this->id_ciudad) .   
                        ", id_barrio = " . $this->var2str($this->id_barrio) .   
                        ", lindero_norte = " . $this->var2str($this->lindero_norte) .   
                        ", lindero_sur = " . $this->var2str($this->lindero_sur) .   
                        ", lindero_este = " . $this->var2str($this->lindero_este) .   
                        ", lindero_oeste = " . $this->var2str($this->lindero_oeste) .   
                        ", mapa_sector = " . $this->var2str($this->mapa_sector) .   
                        ", fecha_construccion = " . $this->var2str($this->fecha_construccion) .   
                        ", nro_estructuras = " . $this->var2str($this->nro_estructuras) .   
                        ", nro_pisos = " . $this->var2str($this->nro_pisos) .   
                        ", area_total = " . $this->var2str($this->area_total) .   
                        ", descripcion_techos = " . $this->var2str($this->descripcion_techos) .   
                        ", acabado_pisos = " . $this->var2str($this->acabado_pisos) .
                        ", acabado_paredes = " . $this->var2str($this->acabado_paredes) .
                        ", acabado_cielorrasos = " . $this->var2str($this->acabado_cielorrasos) .
                        ", acabado_divisiones = " . $this->var2str($this->acabado_divisiones) .
                        ", servicio_medico = " . $this->var2str($this->servicio_medico) .
                        ", servicio_medicopersonal = " . $this->var2str($this->servicio_medicopersonal) .
                        ", alcantarillado = " . $this->var2str($this->alcantarillado) .
                        ", acueducto = " . $this->var2str($this->acueducto) .
                        ", energia_electrica = " . $this->var2str($this->energia_electrica) .
                        ", telefono_servicio = " . $this->var2str($this->telefono_servicio) .
                        ", gas_natural = " . $this->var2str($this->gas_natural) .
                        ", gas_propano = " . $this->var2str($this->gas_propano) .
                        ", ups = " . $this->var2str($this->ups) .
                        ", tanque_reserva = " . $this->var2str($this->tanque_reserva) .
                        ", hidrantes_externo = " . $this->var2str($this->hidrantes_externo) .
                        ", redhidraulica_contraincendio = " . $this->var2str($this->redhidraulica_contraincendio) .
                        ", aire_acondicionado = " . $this->var2str($this->aire_acondicionado) .
                        ", organigrama_institucion = " . $this->var2str($this->organigrama_institucion) .
                        ", definicion = " . $this->var2str($this->definicion) .
                        ", objetivo_especifico = " . $this->var2str($this->objetivo_especifico) .
                        
                        
                        " WHERE id_plan = " . $this->var2str($this->id_plan) . ";";                                            
            } else {
                $sql = "INSERT INTO " . $this->table_name . " 
                       (id_plan,ruc, razon_social, direccion, telefono, 
                        correo_electronico,representante_legal,responsable_plan, actividad) 
                        VALUES
                       (" . $this->var2str($this->id_plan)
                        . "," .$this->var2str($this->ruc)
                        . "," . $this->var2str($this->razon_social)
                        . "," . $this->var2str($this->direccion)
                        . "," . $this->var2str($this->telefono)
                        . "," . $this->var2str($this->correo_electronico)
                        . "," . $this->var2str($this->representante_legal)
                        . "," . $this->var2str($this->responsable_plan)
                        . "," . $this->var2str($this->actividad)                        
                        . ");";
            }
            if ($this->db->exec($sql)) {
                //$this->exists = TRUE;
                // $this->id_plan = $this->db->lastval();
                return TRUE;
            }
            //return $this->db->exec($sql);
        } else {
            return FALSE;
        }
    }

    /**
     * Comprueba los datos del pais, devuelve TRUE si son correctos
     * @return boolean
     */
    public function test() {
        $status = FALSE;

        $this->ruc = trim($this->ruc);
        $this->razon_social = trim($this->no_html($this->razon_social));
        $this->responsable_plan = trim($this->no_html($this->responsable_plan));
        $this->direccion = trim($this->no_html($this->direccion));
        $this->correo_electronico = trim($this->no_html($this->correo_electronico));
        $this->representante_legal = trim($this->no_html($this->representante_legal));

        if (empty($this->ruc)) {
            $this->new_error_msg("RUC No puede estar Vacio");
        } else if (strlen($this->razon_social) < 2 OR strlen($this->razon_social) > 200) {
            $this->new_error_msg("Razón Social no válido.");
        } else if (strlen($this->responsable_plan) < 2 OR strlen($this->responsable_plan) > 200) {
            $this->new_error_msg("Responsable del Plan no válido.");        
        } else if (empty($this->correo_electronico)) {
            $this->new_error_msg("Correo No puede estar Vacio");
        }else if (empty ($this->direccion)) {
            $this->new_error_msg("Dirección no válido."); 
        }else if (empty ($this->representante_legal)) {
            $this->new_error_msg("Representante Legal no válido.");   
            
        }else
            $status = TRUE;

        return $status;
    }

    /**
     * Limpiamos la caché
     */
    private function clean_cache() {
        $this->cache->delete('m_plan_all');
    }

    ///SE CREA CUANDO VA A CARGAR LOS DATOS EN LA GRILLA PORQUE HACE REFERENCIA A EL
    /**
     * Devuelve la url donde se pueden ver/modificar estos datos
     * @return string
     */
    public function url() {
        if (is_null($this->id_plan)) {
            return "index.php?page=plan";
        } else
            return "index.php?page=plan_edit&cod=" . $this->id_plan;
    }

    /**
     * Devuelve el empleado/agente con codagente = $cod
     * @param type $cod
     * @return \agente|boolean
     */
    public function get($cod) {
        $a = $this->db->select("SELECT 	id_plan, TRIM(introduccion) introduccion, objetivos, alcance, politica, marco_legal, historia, plano_sitio, 
                    razon_social, ruc, direccion, telefono, correo_electronico, actividad, representante_legal, 
                    responsable_plan, id_departamento, id_ciudad, id_barrio, lindero_norte, lindero_sur, 
                    lindero_este, lindero_oeste, mapa_sector, 
                    case when fecha_construccion is null then current_date else fecha_construccion end fecha_construccion, 
                    ifnull(nro_estructuras,0) nro_estructuras, ifnull(nro_pisos,0) nro_pisos, ifnull(area_total,0) area_total, descripcion_techos, 
                    acabado_pisos, acabado_paredes, acabado_cielorrasos, acabado_divisiones,servicio_medico,servicio_medicopersonal,
                    alcantarillado,acueducto,energia_electrica,telefono_servicio,gas_natural,gas_propano,ups,tanque_reserva,hidrantes_externo,
                    redhidraulica_contraincendio,aire_acondicionado, organigrama_institucion,definicion,objetivo_especifico "
                . "FROM " . $this->table_name . " WHERE id_plan = " . $this->var2str($cod) . ";");
        if ($a) {
            return new plan_m($a[0]);
        } else
            return FALSE;
    }
    
    
    public function actualizamapasector($codigoestudio){
        
        $sql = "UPDATE " . $this->table_name . " SET " .                                            
                 " mapa_sector = null ".               
                "  WHERE id_plan = " . $this->var2str($codigoestudio) . ";";
         return $this->db->exec($sql);
    }
    
     public function actualizaorganigrama_institucion($codigoestudio){
        
        $sql = "UPDATE " . $this->table_name . " SET " .                                            
                 " organigrama_institucion = null ".               
                "  WHERE id_plan = " . $this->var2str($codigoestudio) . ";";
         return $this->db->exec($sql);
    }
    
    
    public function get_estacionamiento()
    {
        $dir = new \estacionamiento_m;
        return $dir->all_from_estacionamiento($this->id_plan);
    }
    
    public function elimina_estacionamiento($ciconyuge)
    {
        $bc= new \estacionamiento_m;
        return $bc->elimina_estacionamiento($ciconyuge);//$dir->all_from_conyuge($this->cedula_titular);
    }
    
    
    public function get_generadores()
    {
        $dir = new \generadores_m;
        return $dir->all_from_generadores($this->id_plan);
    }
    
    public function elimina_generador($ciconyuge)
    {
        $bc= new \generadores_m;
        return $bc->elimina_generador($ciconyuge);//$dir->all_from_conyuge($this->cedula_titular);
    }
    
     public function get_contingencia()
    {
        $dir = new \contingencia_m;
        return $dir->all_from_contingencia($this->id_plan);
    }
    
    public function elimina_contingencia($ciconyuge)
    {
        $bc= new \contingencia_m;
        return $bc->elimina_contingencia($ciconyuge);//$dir->all_from_conyuge($this->cedula_titular);
    }
    
    public function get_amenaza()
    {
        $dir = new \amenaza_m;
        return $dir->all_from_amenaza($this->id_plan);
    }
    
    public function elimina_amenaza($ciconyuge)
    {
        $bc= new \amenaza_m;
        return $bc->elimina_amenaza($ciconyuge);//$dir->all_from_conyuge($this->cedula_titular);
    }
    
    
 /* ///se usa para buscar el contribuyente en la multa de transito  
  public function search($query, $offset = 0)
   {
      $clilist = array();
      $query = mb_strtolower( $this->no_html($query), 'UTF8' );
      
      $consulta = "SELECT * FROM ".$this->table_name." WHERE  ";
      if( is_numeric($query) )
      {
          //puse UPPER porque no trae con Ñ
          //lower(to_ascii(co_nomcomple, 'latin1'))
          //lower(to_ascii('%ferreteria ñandu%', 'latin1'))
         $consulta .= "(lower(nombre_titular) LIKE lower('%".$query."%')  "
                 . "OR lower(TRIM(apellido_titular)) LIKE lower('%".$query."%') "
                 . " OR TRIM(cedula_titular) LIKE '%".$query."%' )";
      }
      else
      {
         $buscar = str_replace(' ', '%', $query);
         $consulta .= "(lower(nombre_titular) LIKE lower('%".$buscar."%')   "
                . "OR lower(trim(apellido_titular)) LIKE lower('%".$buscar."%') "
                 . " OR trim(cedula_titular) LIKE '%".$buscar."%' )";
      }
      $consulta .= " ORDER BY nombre_titular ASC";
      
      $data = $this->db->select_limit($consulta, FS_ITEM_LIMIT, $offset);
      
      if($data)
      {
         foreach($data as $d)
         {
            $clilist[] = new paciente_m($d);
         }
      }
      
      return $clilist;
   }
*/
   
   /**
    * Devuelve el primer cliente que tenga $cifnif como cifnif.
    * Si el cifnif estÃ¡ en blanco y se proporciona una razÃ³n social,
    * se devuelve el primer cliente que tenga esa razÃ³n social.
    * @param type $cifnif
    * @param type $razon
    * @return boolean|\cliente
    */
   /*public function get_by_rmc($rmc, $razon = FALSE)
   {
      if($rmc == '' AND $razon)
      {
         $razon = $this->no_html( mb_strtolower($razon, 'UTF8') );
         $sql = "SELECT * FROM ".$this->table_name." WHERE trim(co_rmc) = '' "
                 . "AND lower(trim(co_nomcomple)) = ".$this->var2str($razon).";";
      }
      else
      {
         $rmc = mb_strtolower($rmc, 'UTF8');
         $sql = "SELECT * FROM ".$this->table_name." WHERE lower(trim(co_rmc)) = ".$this->var2str($rmc).";";
      }
      
      $data = $this->db->select($sql);
      if($data)
      {
         return new in_contribu_m($data[0]);
      }
      else
         return FALSE;
   }*/
   
   public function all(){
      /// Leemos la lista de la caché
      $lista = $this->cache->get_array('m_plan_all');
      if(!$lista)
      {
         /// si no encontramos los datos en caché, leemos de la base de datos
         $data = $this->db->select("SELECT * FROM ".$this->table_name." ORDER BY id_plan ASC;");
         if($data)
         {
            foreach($data as $p)
            {
               $lista[] = new plan_m($p);
            }
         }         
         /// guardamos la lista en caché
         $this->cache->set('m_plan_all', $lista);
      }      
      return $lista;
   }
   
    public function get_new_codigo()
    {
       $sql = "SELECT MAX(".$this->db->sql_to_int('id_plan').") as cod FROM ".$this->table_name.";";
       $cod = $this->db->select($sql);
       if($cod)
       {
          return 1 + intval($cod[0]['cod']);
       }
       else
          return 1;
    }
    
     /**
     * Devuelve la referencia codificada para poder ser usada en imágenes.
     * Evitamos así errores con caracteres especiales como / y \.
     * @param string $ref
     * @return string
     */
    public function image_ref($ref = FALSE)
    {
        if ($ref === FALSE) {
            $ref = $this->id_plan;
        }

        return str_replace(array('/', '\\'), array('_', '_'), $ref);
    }

    /**
     * Devuelve la url relativa de la imagen del plano del sitio.
     * @return boolean
     */
    public function imagen_url()
    {
        if (file_exists(FS_MYDOCS . 'images/planositio/' . $this->image_ref() . '-1.png')) {
            return 'images/planositio/' . $this->image_ref() . '-1.png';
        } else if (file_exists(FS_MYDOCS . 'images/planositio/' . $this->image_ref() . '-1.jpg')) {
            return 'images/planositio/' . $this->image_ref() . '-1.jpg';
        }

        return FALSE;
    }
    
     /**
     * Asigna una imagen al plano del sitio.
     * @param string $img
     * @param boolean $png
     */
    public function set_imagen($img, $png = TRUE)
    {
        $this->plano_sitio = NULL;

        if (file_exists(FS_MYDOCS . 'images/planositio/' . $this->image_ref() . '-1.png')) {
            unlink(FS_MYDOCS . 'images/planositio/' . $this->image_ref() . '-1.png');
        } else if (file_exists('images/planositio/' . $this->image_ref() . '-1.jpg')) {
            unlink(FS_MYDOCS . 'images/planositio/' . $this->image_ref() . '-1.jpg');
        }

        if ($img) {
            if (!file_exists(FS_MYDOCS . 'images/planositio')) {
                @mkdir(FS_MYDOCS . 'images/planositio', 0777, TRUE);
            }

            if ($png) {
                $f = @fopen(FS_MYDOCS . 'images/planositio/' . $this->image_ref() . '-1.png', 'a');
            } else {
                $f = @fopen(FS_MYDOCS . 'images/planositio/' . $this->image_ref() . '-1.jpg', 'a');
            }

            if ($f) {
                fwrite($f, $img);
                fclose($f);
            }
        }
    }

 /*  
   public function buscar_pacientes($query)
   {
      $query = $this->escape_string(mb_strtolower(trim($query), 'UTF8'));
      
      $sql = "SELECT cedula_titular, paciente "
                    . " FROM vs_paciente "
                    . " WHERE (cedula_titular LIKE '" . $query . "%' OR trim(paciente) LIKE '%" . $query . "%') order by paciente;";
      $resultado = $this->db->select($sql);
      if($resultado)
      {
         return $resultado;
      }
      else
         return array();
   }
   */
   
    
 /*  
   
    public function get_conyuges()
    {
        $dir = new \conyuge_m;
        return $dir->all_from_conyuge($this->cedula_titular);
    }
    
 
    public function get_hijos()
    {
        $dir = new \hijo_m;
        return $dir->all_from_hijo($this->cedula_titular);
    }
    
    public function baja_conyuge($ciconyuge)
    {
        $bc= new \conyuge_m;
        return $bc->baja_conyuge($ciconyuge);//$dir->all_from_conyuge($this->cedula_titular);
    }
    
    public function baja_hijo($cihijo)
    {
        $bh= new \hijo_m;
        return $bh->baja_hijo($cihijo);//$dir->all_from_conyuge($this->cedula_titular);
    }
    
    */
}
