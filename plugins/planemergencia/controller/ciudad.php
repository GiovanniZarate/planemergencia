<?php


/**
 * Description of in_ciudad
 *
 * @author INFO_14_GIOVANNI
 */
require_model('ciudad_m.php');
require_model('departamento_m.php');

class ciudad extends fs_controller{
    
     public $total_resultados;
     public $resultados;
     public $ciudad;
     
     public $departamento;
     
    public function __construct() {
        parent::__construct(__CLASS__, 'Ciudad', 'Definiciones', FALSE, TRUE);
    }
    protected function private_core() {
        //INSTANCIA EL MODELO in_profesion_m 
      $this->ciudad = new ciudad_m();
      
      $this->departamento = new departamento_m();
      
      if( isset($_POST['vnombrelargo'])){
          //CREA UNA NUEVA INSTANCIA DEL MODELO  PARA ENVIAR LOS DATOS Y GUARDAR EN LA BASE DE DATOS
          $ciudad = new ciudad_m();
          
          //PASA LOS PARAMETROS AL MODELO CAMPO POR CAMPO QUE VIENE DEL METODO POST DE LA VISTA OSEA EL HTML
          $ciudad->id_ciudad = $ciudad->get_new_codigo();        //SE CREA EL METODO EN EL MODELO PARA GENERAR EL AUTONUMERICO
          $ciudad->id_departamento = $_POST['vdpto'];
          $ciudad->nombre_corto = $_POST['vnombrecorto'];
          $ciudad->nombre_largo = $_POST['vnombrelargo'];
          
          //LLAMA AL METODO GUARDAR PARA GRABAR LOS DATOS SI TODO ESTA CORRECTO
          if($ciudad->save()){
              $this->new_message("Ciudad ".$ciudad->nombre_largo." guardado correctamente.");
          }else{
              $this->new_error_msg("Imposible grabar los datos");
          }
      }
      //SI ENCUENTRA UNA VARIABLE DELETE ENVIADO DESDE LA VISTA PARA ELIMINAR delete -> CONTIENE EL CODIGO SELECCIONADO
      else if(isset ($_GET['delete'])){          
          $ciudad = $this->ciudad->get($_GET['delete']);
          if($ciudad){
              if($ciudad->delete()){
                  $this->new_message("Ciudad ".$ciudad->nombre_largo. " Eliminado correctamente.");
              }else{
                  $this->new_error_msg("Imposible Eliminar");
              }
          }else{
              $this->new_error_msg("Ciudad no encontrado");
          }
      }
      
       //PARA HACER LA PAGINACION
      $this->offset = 0;
      if( isset($_GET['offset']) )
      {
         $this->offset = intval($_GET['offset']);
      }
      //PARA ORDENAR DE ACUERDO A LOS PARAMETROS
      $this->orden = 'nombre_largo ASC';
      if( isset($_REQUEST['orden']) )
      {
         $this->orden = $_REQUEST['orden'];
      }
      
      $this->buscar();
    }
    
      //METODO PARA BUSCAR DATOS
  private function buscar(){
      $this->total_resultados = 0;
      $query = mb_strtolower( $this->empresa->no_html($this->query), 'UTF8' );
      $sql = " FROM ciudad c join departamento d on c.id_departamento=d.id_departamento ";
      $and = ' WHERE ';
     //is_numeric = Comprueba si una variable es un número o un string numérico
      if( is_numeric($query) )
      {
         $sql .= $and."(id_ciudad LIKE '%".$query."%'"
                 . "OR nombre_corto LIKE '%".$query."%'"
                 . " OR nombre_largo LIKE '%".$query."%')";
         $and = ' AND ';
      }
      else
      {
         $buscar = str_replace(' ', '%', $query);
         $sql .= $and."(lower(nombre_largo) LIKE '%".$buscar."%')";
         $and = ' AND ';
      }                 
      $data = $this->db->select("SELECT COUNT(id_ciudad) as total".$sql.';');
      if($data)
      {
         $this->total_resultados = intval($data[0]['total']);
         
         $data2 = $this->db->select_limit("SELECT * , descripcion nombredepartamento ".$sql." ORDER BY ".$this->orden, FS_ITEM_LIMIT, $this->offset);
         if($data2)
         {
            foreach($data2 as $d)
            {
               $this->resultados[] = new ciudad_m($d);
            }
         }
      }
   }
   
  //PARA HACER LA PAGINACION
   public function paginas(){
      $url = $this->url()."&query=".$this->query
                 //."&idpais=".$this->pais     
                 ."&orden=".$this->orden;
      
      $paginas = array();
      $i = 0;
      $num = 0;
      $actual = 1;
      
      /// añadimos todas la página
      while($num < $this->total_resultados)
      {
         $paginas[$i] = array(
             'url' => $url."&offset=".($i*FS_ITEM_LIMIT),
             'num' => $i + 1,
             'actual' => ($num == $this->offset)
         );
         
         if($num == $this->offset)
         {
            $actual = $i;
         }
         
         $i++;
         $num += FS_ITEM_LIMIT;
      }
      
      /// ahora descartamos
      foreach($paginas as $j => $value)
      {
         $enmedio = intval($i/2);
         
         /**
          * descartamos todo excepto la primera, la última, la de enmedio,
          * la actual, las 5 anteriores y las 5 siguientes
          */
         if( ($j>1 AND $j<$actual-5 AND $j!=$enmedio) OR ($j>$actual+5 AND $j<$i-1 AND $j!=$enmedio) )
         {
            unset($paginas[$j]);
         }
      }
      
      if( count($paginas) > 1 )
      {
         return $paginas;
      }
      else
      {
         return array();
      }
   }
}
