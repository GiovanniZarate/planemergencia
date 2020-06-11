<?php


/**
 * Description of sys_distrito_edit
 *
 * @author GIOVANNI ZARATE 28/03/2018
 */
require_model('ciudad_m.php');
require_model('barrio_m.php');

class barrio_edit extends fs_controller{
    public $barrio;
    public $allow_delete;
    //PARA EL COMBO
    public $departamento;
    
    public function __construct() {
        parent::__construct(__CLASS__, 'Editar Barrio', '');
    }
    
    protected function private_core() {
        $this->ppage = $this->page->get('barrio');
        
        /// ¿El usuario tiene permiso para eliminar en esta página?
        $this->allow_delete = $this->user->allow_delete_on(__CLASS__);

        $this->barrio = FALSE;

         //PARA INICIAR EL COMBO DE TIPO PROFESION
        $this->departamento = new ciudad_m();
        
        //SE SE PASA POR EL METODO _GET UN VALOR cod 
        if ( isset($_GET['cod'])){ 
          //una instancia nueva de empleado_m
          $distrito = new barrio_m();
          //CARGA LA VARIABLE PUBLICA empleado con los datos del empleado con el codigo enviado
          $this->barrio = $distrito->get(trim($_GET['cod']));
        }
        
        //SI CARGA LOS DATOS 
          if ($this->barrio){
               $this->page->title .= ' ' . $this->barrio->id_barrio;
               //SI VIENE UNA VARIABLE DEFINIDA DE CARGA
               if ( isset($_POST['vnombre'])){
                    // $this->profesion->pn_codigo = $_POST['pn_codigo'];
                     $this->barrio->descripcion = $_POST['vnombre'];
                     $this->barrio->id_ciudad = $_POST['vdpto'];
                     //SI GUARDA LOS DATOS MUESTRA MENSAJE SATISFACTORIO
                     if( $this->barrio->save() )
                     {
                        $this->new_message("Datos de Barrio guardados correctamente.");
                     }
                     else
                        $this->new_error_msg("¡Imposible guardar los datos!");
               }
            }else{
               $this->new_error_msg("Barrio no encontrado.", 'error', FALSE, FALSE);
            }
        
    }
    
    public function url()
   {
      if( !isset($this->barrio) )
      {
         return parent::url();
      }
      else if($this->barrio)
      {
         return $this->barrio->url();
      }
      else
         return $this->page->url();
   }
    
    
}
