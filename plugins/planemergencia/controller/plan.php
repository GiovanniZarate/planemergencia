<?php

/**
 * Description of plan
 *
 * @author GIOVANNI ZARATE : 31/05/2019
 */
require_model('plan_m.php');

class plan extends fs_controller {

    public $plan;
    public $resultados;
    public $total_resultados;
    public $allow_delete;
    
    //PARA COMBOS
    public $departamento;
    public $ciudad;
    public $barrio;

    public $nroplan;
    
  
    
    
    public function __construct() {
        parent::__construct(__CLASS__, 'Plan de Emergencia', 'Movimientos');
    }

    protected function private_core() {
        //Instancia el modelo
        $this->bien = new plan_m();
        
        //PARA COMBOS
        /*$this->cuenta = new af_cuentas_m();
        $this->estado = new af_estado_m();
        $this->origen = new af_origen_m();*/             

        //2 PARA LA PAGINACIÓN
        $this->offset = 0;
        if (isset($_GET['offset'])) {
            $this->offset = intval($_GET['offset']);
        }

        ///GRABAR DESDE LA OTRA PAGINA DE CARGA
        if (isset($_POST['vruc'])) {
            // $this->new_message("GRABAR");
            $plan = new plan_m(); 
            
            $plan->id_plan = $plan->get_new_codigo();
            $this->nroplan = $plan->get_new_codigo();
            
            $plan->razon_social = $_POST['vrazon'];
            $plan->ruc = $_POST['vruc'];
            $plan->direccion = $_POST['vdireccion'];
            $plan->telefono = $_POST['vtelefono'];
            $plan->correo_electronico = $_POST['vcorreo'];
            $plan->actividad = $_POST['vactividad'];
            $plan->representante_legal = $_POST['vrepresentante'];
            $plan->responsable_plan = $_POST['vresponsable'];
            ///GUARDA LOS DATOS SI NO DA ERROR
            if ($plan->save()) {
                $this->new_message("Plan " . $plan->razon_social . " guardado correctamente.");
                //PARA ENVIAR A LA PAGINA DE BUSQUEDA UNA VEZ GRABADO
                //"index.php?page=af_bien_edit&cod=".$this->idbien;
                 header('location: ' . 'index.php?page=plan_edit&cod='.$this->nroplan);
            } else
                $this->new_error_msg("¡Imposible guardar!");
        } else if (isset($_GET['delete'])) {
            $plan = $this->plan->get($_GET['delete']);
            if ($plan) {
                if ($plan->delete()) {
                    $this->new_message("Plan " . $plan->razon_social . " eliminado correctamente.");
                } else
                    $this->new_error_msg("¡Imposible eliminar!");
            } else
                $this->new_error_msg("¡Plan no encontrado!");
        }
        //3-PARA ORDENAR DE ACUERDO A LOS PARAMETROS
        $this->orden = 'id_plan ASC';
        if (isset($_REQUEST['orden'])) {
            $this->orden = $_REQUEST['orden'];
        }

        //4-FUNCION BUSCAR DATOS 
        $this->buscar();
    }

    //5-METODO PRIVADO PARA CONSULTAR LOS DATOS EN LA BASE DE DATOS, FILTRANDO ORDENANDO,ECT
    private function buscar() {
        $this->total_resultados = 0;
        $query = mb_strtolower($this->empresa->no_html($this->query), 'UTF8');
        $sql = " FROM plan ";
        $and = ' WHERE ';
        //is_numeric = Comprueba si una variable es un número o un string numérico
        if (is_numeric($query)) {
            $sql .= $and . "(id_plan LIKE '%" . $query . "%')";
            $and = ' AND ';
        } else {
            $buscar = str_replace(' ', '%', $query);
            $sql .= $and . "(lower(ruc) LIKE '%" . $buscar . "%'"
                    . "OR lower(razon_social) LIKE '%" . $buscar . "%' "
                    . "OR lower(actividad) LIKE '%" . $buscar . "%' "
                    . "OR lower(introduccion) LIKE '%" . $buscar . "%' "
                    . "OR lower(representante_legal) LIKE '%" . $buscar . "%')";
            $and = ' AND ';
        }
        $data = $this->db->select("SELECT COUNT(*) as total" . $sql . ';');
        if ($data) {
            $this->total_resultados = intval($data[0]['total']);

            $data2 = $this->db->select_limit("SELECT * " . $sql . " ORDER BY " . $this->orden, FS_ITEM_LIMIT, $this->offset);
            if ($data2) {
                foreach ($data2 as $d) {
                    $this->resultados[] = new plan_m($d);
                }
            }
        }
    }

    //6- PARA HACER LA PAGINACION
    public function paginas() {
        $url = $this->url() . "&query=" . $this->query
                //."&idpais=".$this->pais     
                . "&orden=" . $this->orden;

        $paginas = array();
        $i = 0;
        $num = 0;
        $actual = 1;

        /// añadimos todas la página
        while ($num < $this->total_resultados) {
            $paginas[$i] = array(
                'url' => $url . "&offset=" . ($i * FS_ITEM_LIMIT),
                'num' => $i + 1,
                'actual' => ($num == $this->offset)
            );

            if ($num == $this->offset) {
                $actual = $i;
            }

            $i++;
            $num += FS_ITEM_LIMIT;
        }

        /// ahora descartamos
        foreach ($paginas as $j => $value) {
            $enmedio = intval($i / 2);

            /**
             * descartamos todo excepto la primera, la última, la de enmedio,
             * la actual, las 5 anteriores y las 5 siguientes
             */
            if (($j > 1 AND $j < $actual - 5 AND $j != $enmedio) OR ( $j > $actual + 5 AND $j < $i - 1 AND $j != $enmedio)) {
                unset($paginas[$j]);
            }
        }

        if (count($paginas) > 1) {
            return $paginas;
        } else {
            return array();
        }
    }

}
