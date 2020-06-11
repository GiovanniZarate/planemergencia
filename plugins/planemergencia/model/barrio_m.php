<?php

/**
 * Description of sys_distrito_m
 *
 * @author GIOVANNI ZARATE : Fecha: 31/05/2019
 */
class barrio_m extends fs_model{
    public $id_barrio;
    public $descripcion;
    public $id_ciudad;
    
    public function __construct($c=FALSE) {
        parent::__construct('barrio');
        if($c){
            $this->id_barrio = $c['id_barrio'];
            $this->descripcion = $c['descripcion'];
            $this->id_ciudad = $c['id_ciudad'];

          }else{
            $this->id_barrio=0;
            $this->descripcion='';
            $this->id_ciudad=0;
          }          
    }

    protected function install() {
        $this->clean_cache();
     }
     
    public function delete() {
        $this->clean_cache();
        return $this->db->exec("DELETE FROM ".$this->table_name." WHERE id_barrio = ".$this->var2str($this->id_barrio).";");
    }

    public function exists() {
        if( is_null($this->id_barrio) )
        {
           return FALSE;
        }
        else
           return $this->db->select("SELECT * FROM ".$this->table_name." WHERE id_barrio = ".$this->var2str($this->id_barrio).";");
    }

    public function save() {
        if( $this->test() ){      
            $this->clean_cache();
               if( $this->exists() )
               {
                  $sql = "UPDATE ".$this->table_name." SET descripcion = ".$this->var2str($this->descripcion).                    
                          " ,id_ciudad=".$this->var2str($this->id_ciudad)." "
                          . "WHERE id_barrio = ".$this->var2str($this->id_barrio).";";
               }
               else
               {
                  $sql = "INSERT INTO ".$this->table_name." (descripcion,id_ciudad) VALUES
                           (".$this->var2str($this->descripcion).",".$this->var2str($this->id_ciudad).");";
               }

               return $this->db->exec($sql);
           }  else {
              return FALSE;
           }
    }
    
    
    /**
    * Limpiamos la caché
    */
   private function clean_cache()
   {
      $this->cache->delete('sys_distrito_all');
   }
   
   /**
    * Comprueba los datos del pais, devuelve TRUE si son correctos
    * @return boolean
    */
   public function test(){
      $status = FALSE;
      
      //$this->iddistrito = trim($this->iddistrito);
      $this->descripcion = $this->no_html($this->descripcion);
      $this->id_ciudad = trim($this->id_ciudad);
      
      if( strlen($this->descripcion) < 1 OR strlen($this->descripcion) > 60 )
      {
         $this->new_error_msg("Nombre no válido.");
      }
      else if( empty($this->id_ciudad) )
      {
         $this->new_error_msg("Código de Ciudad. no válido.");
      }
      else
         $status = TRUE;
      
      return $status;
   }
  
   /**
    * Devuelve la url donde se pueden ver/modificar estos datos
    * @return string
    */
   public function url()
   {
      if( is_null($this->id_barrio) )
      {
         return "index.php?page=barrio";
      }
      else
         return "index.php?page=barrio_edit&cod=".$this->id_barrio;
   }
   
   /**
    * Devuelve un array con profesiones.
    * @return \
    */
   public function all()
   {
      /// leemos esta lista de la caché
      $lista = $this->cache->get_array('sys_distrito_all');
      if(!$lista)
      {
         /// si no está en caché, leemos de la base de datos
         $data = $this->db->select("SELECT id_barrio,descripcion,id_ciudad FROM ".$this->table_name."  ORDER BY descripcion ASC;");
         
         if($data)
         {
            foreach($data as $a)
            {
               $lista[] = new barrio_m($a);
            }
         }
         
         /// guardamos la lista en caché
         $this->cache->set('sys_distrito_all', $lista);
      }
      
      return $lista;
   }
   
   /**
    * Devuelve el empleado/agente con codagente = $cod
    * @param type $cod
    * @return \agente|boolean
    */
   public function get($cod)
   {
      $a = $this->db->select("SELECT id_barrio,trim(descripcion) descripcion, "
              . "id_ciudad "
              . "FROM ".$this->table_name." WHERE id_barrio = ".$this->var2str($cod).";");
      if($a)
      {
         return new barrio_m($a[0]);
      }
      else
         return FALSE;
   }
   
   /**
    * Genera un nuevo codigo de empleado
    * @return int
    */
   public function get_new_codigo()
   {
      $sql = "SELECT MAX(".$this->db->sql_to_int('id_barrio').") as cod FROM ".$this->table_name.";";
      $cod = $this->db->select($sql);
      if($cod)
      {
         return 1 + intval($cod[0]['cod']);
      }
      else
         return 1;
   }
 

}
