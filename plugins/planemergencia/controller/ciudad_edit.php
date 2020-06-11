<?php

/**
 * Description of in_ciudad_edit
 *
 * @author INFO_14_GIOVANNI
 */

//agregar los modelos para utilizar
require_model('ciudad_m.php');
require_model('departamento_m.php');

class ciudad_edit extends fs_controller{
    public $ciudad;
    public $allow_delete;
    public $departamento;
    
    public function __construct() {
        parent::__construct(__CLASS__, 'Editar Ciudad', 'Definiciones', FALSE, FALSE);
    }
    
    protected function private_core() {
        $this->ppage = $this->page->get('ciudad');
        /// ¿El usuario tiene permiso para eliminar en esta página?
         $this->allow_delete = $this->user->allow_delete_on(__CLASS__);
      
        $this->ciudad = FALSE;
        
        $this->departamento = new departamento_m();
        
         //SE SE PASA POR EL METODO _GET UN VALOR cod 
        if( isset($_GET['cod'])){
             //una instancia nueva del modelo correspondiente
             $ciudad = new ciudad_m();
              //CARGA LA VARIABLE PUBLICA enviando como parametro el codigo seleccionado//
             //EL METODO get() tiene que estar creado en el modelo
              $this->ciudad = $ciudad->get($_GET['cod']);             
        }
        //SI CARGA LOS DATOS CON EL CODIGO ENVIADO
        if($this->ciudad){
             //$this->page->title .= ' ' . $this->profesion->pn_codigo;
           //SI VIENE UNA VARIABLE DEFINIDA DE CARGA
            if( isset($_POST['vnombrelargo'])){
                //CAPTURA LOS DATOS DE EDICION CON EL VALOR CARGADO
                $this->ciudad->id_departamento = $_POST['vdpto'];
                $this->ciudad->nombre_largo = $_POST['vnombrelargo'];
                $this->ciudad->nombre_corto = $_POST['vnombrecorto'];
                //SI GRABA LOS DATOS
                if( $this->ciudad->save()){
                    $this->new_message("Datos grabados correctamente...");
                }else{
                    $this->new_error_msg("Imposible grabar los datos...");
                }
            }
        }else{
            $this->new_error_msg("Ciudad no encontrado.", 'error', FALSE, FALSE);
        }
    }
    
    
    public function url(){
      if( !isset($this->ciudad) )
      {
         return parent::url();
      }
      else if($this->ciudad)
      {
         return $this->ciudad->url();
      }
      else
         return $this->page->url();
   }
}
