<?php

/**
 * Description of in_ciudad_m
 *
 * @author INFO_14_GIOVANNI
 */
class ciudad_m  extends fs_model{
    public $id_departamento;
    public $id_ciudad;
    public $nombre_corto;
    public $nombre_largo;
    public $nombredepartamento;
    
    public function __construct($c=FALSE) {
        parent::__construct('ciudad');
        if($c){
            $this->id_departamento = $c['id_departamento'];
            $this->id_ciudad = $c['id_ciudad'];
            $this->nombre_corto = $c['nombre_corto'];
            $this->nombre_largo = $c['nombre_largo'];
            $this->nombredepartamento = $c['nombredepartamento'];
        }else{
            $this->id_departamento= 0;
            $this->id_ciudad= 0;
            $this->nombre_corto= '';
            $this->nombre_largo= '';
            $this->nombredepartamento= '';
            
        }
    }

    protected function install() {
         $this->clean_cache();
    }

    public function delete() {
        $this->clean_cache();
        return $this->db->exec("DELETE FROM ".$this->table_name." WHERE id_ciudad = ".$this->var2str($this->id_ciudad).";");
    }

     /**
    * Comprueba los datos del pais, devuelve TRUE si son correctos
    * @return boolean
    */
    public function test(){
       $status = FALSE;

       $this->id_ciudad = trim($this->id_ciudad);
       $this->nombre_largo = $this->no_html($this->nombre_largo);

       if( empty($this->id_ciudad) ){
          $this->new_error_msg("Código No puede estar Vacio");
       }
       else if( strlen($this->nombre_largo) < 3 OR strlen($this->nombre_largo) > 35 ){
          $this->new_error_msg("Nombre no válido.");
       }
       else
          $status = TRUE;

       return $status;
    }
   
    public function exists() {
        if(is_null($this->id_ciudad)){
            return FALSE;
        }else{
            return $this->db->select("SELECT * FROM ".$this->table_name." WHERE id_ciudad = ".$this->var2str($this->id_ciudad).";");
        }
    }

    public function save() {
        if($this->test()){
            $this->clean_cache();
            if($this->exists()){
                $sql = "UPDATE ".$this->table_name." SET nombre_corto = ".$this->var2str($this->nombre_corto)
                        .", nombre_largo = ".$this->var2str($this->nombre_largo)
                        .", id_departamento = ".$this->var2str($this->id_departamento).
                        "WHERE id_ciudad = ".$this->var2str($this->id_ciudad).";";
            }  else {
                $sql = "INSERT INTO ".$this->table_name. " (id_departamento,id_ciudad,nombre_corto,nombre_largo) VALUES ".
                    "(".$this->var2str($this->id_departamento).",".$this->var2str($this->id_ciudad).",".$this->var2str($this->nombre_corto).",".$this->var2str($this->nombre_largo).");";
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
      $this->cache->delete('m_ciudad_all');
   }
   ///SE CREA CUANDO VA A CARGAR LOS DATOS EN LA GRILLA PORQUE HACE REFERENCIA A EL
     /**
    * Devuelve la url donde se pueden ver/modificar estos datos
    * @return string
    */
   public function url()
   {
      if( is_null($this->id_ciudad) )
      {
         return "index.php?page=ciudad";
      }
      else
         return "index.php?page=ciudad_edit&cod=".$this->id_ciudad;
   }
   //SE CREA EL METODO AUTONUMERICO QUE SE USA EN EL MODELO PARA GUARDAR UN NUEVO DATO
   /**
    * Genera un nuevo codigo
    * @return int
    */
   public function get_new_codigo()
   {
      $sql = "SELECT MAX(".$this->db->sql_to_int('id_ciudad').") as cod FROM ".$this->table_name.";";
      $cod = $this->db->select($sql);
      if($cod)
      {
         return 1 + intval($cod[0]['cod']);
      }
      else
         return 1;
   }
   ///SE CREA EL METOD GET PARA TRAER LOS DATOS EN CASO DE EDITAR O ELIMINAR UN DATO
   /**
    * Devuelve el empleado/agente con codagente = $cod
    * @param type $cod
    * @return \agente|boolean
    */
   public function get($cod)
   {
      $a = $this->db->select("SELECT id_departamento,id_ciudad,trim(nombre_corto) nombre_corto,trim(nombre_largo) nombre_largo "
              . "FROM ".$this->table_name." WHERE id_ciudad = ".$this->var2str($cod).";");
      if($a)
      {
         return new ciudad_m($a[0]);
      }
      else
         return FALSE;
   }
   
   
     ///TRAE TODOS LOS DATOS DE LA TABLA -- SE USA PARA CARGAR EL COMBO EN TABLAS RELACIONADAS
   public function all(){
      // $this->cache->delete('m_ciudad_all');
      /// Leemos la lista de la caché
      $lista = $this->cache->get_array('m_ciudad_all');
      if(!$lista)
      {
         /// si no encontramos los datos en caché, leemos de la base de datos
         $data = $this->db->select("SELECT * , descripcion nombredepartamento FROM ".$this->table_name." c join "
                 . " departamento d on c.id_departamento=d.id_departamento "
                 . "ORDER BY id_ciudad ASC;");
         if($data)
         {
            foreach($data as $p)
            {
               $lista[] = new ciudad_m($p);
            }
         }         
         /// guardamos la lista en caché
         $this->cache->set('m_ciudad_all', $lista);
      }      
      return $lista;
   }
   //PARA EL COMBO POR DEFECTO
   public function is_default(){
      return FALSE;
   }
}
