<?php

/**
 * Description of sys_dpto_edit
 *
 * @author GIOVANNI ZARATE : Fecha: 31/05/2019 
 */
require_model('departamento_m.php');

class departamento_edit extends fs_controller{
    
    public $instanciamodel;
    public $allow_delete;
    
    public function __construct() {
        parent::__construct(__CLASS__, 'Editar Dpto', 'admin', FALSE, FALSE, FALSE);
    }
    
    protected function private_core() {
        $this->ppage = $this->page->get('departamento');
        /// ¿El usuario tiene permiso para eliminar en esta página?
        $this->allow_delete = $this->user->allow_delete_on(__CLASS__);

        $this->instanciamodel = FALSE;
        
        //SE SE PASA POR EL METODO _GET UN VALOR cod 
        if (isset($_GET['cod'])) {
            //una instancia nueva de empleado_m
            $instancianuevamodel = new departamento_m();
            //CARGA LA VARIABLE PUBLICA empleado con los datos del empleado con el codigo enviado
            $this->instanciamodel = $instancianuevamodel->get($_GET['cod']);
        }
        
        //SI CARGA LOS DATOS 
        if ($this->instanciamodel) {
            $this->page->title .= ' ' . $this->instanciamodel->id_departamento;

            //SI VIENE UNA VARIABLE DEFINIDA DE CARGA
            if (isset($_POST['vnombre'])) {
                // $this->profesion->pn_codigo = $_POST['pn_codigo'];
                $this->instanciamodel->descripcion = $_POST['vnombre'];
       
                //SI GUARDA LOS DATOS MUESTRA MENSAJE SATISFACTORIO
                if ($this->instanciamodel->save()) {
                    $this->new_message("Datos de Departamento guardados correctamente.");
                } else
                    $this->new_error_msg("¡Imposible guardar los datos!");
            }
        }else {
            $this->new_error_msg("Departamento no encontrado.", 'error', FALSE, FALSE);
        }
    }
    
    public function url() {
        if (!isset($this->instanciamodel)) {
            return parent::url();
        } else if ($this->instanciamodel) {
            return $this->instanciamodel->url();
        } else
            return $this->page->url();
    }
}
