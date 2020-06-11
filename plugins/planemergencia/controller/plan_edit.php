<?php


/**
 * Description of 
 *
 * @author GIOVANNI ZARATE
 * FECHA : 03/06/2019
 */


require_model('departamento_m.php');
require_model('ciudad_m.php');
require_model('barrio_m.php');
require_model('estacionamiento_m.php');
require_model('generadores_m.php');
require_model('bloque_m.php');
require_model('dependencia_m.php');
require_model('tipo_m.php');
require_model('dia_m.php');
require_model('contingencia_m.php');
require_model('amenaza_m.php');

class plan_edit extends fs_controller{
    public $plan;
   
   
    public $departamento;
    public $ciudad;
    public $barrio;
    
    public $planxcodigo;
    
    public $estacionamiento;
    public $generadores;
    public $bloque;
    public $dependencia;
    public $tipo;
    public $dia;
    public $contingencia;
    public $amenaza;
     
    public function __construct() {
        parent::__construct(__CLASS__, 'Editar Plan de Emergencia', 'Movimientos', FALSE, FALSE, FALSE);
    }
    
    protected function private_core() {
        $this->ppage = $this->page->get('plan');
        $this->plan = new plan_m();               
        
        $this->allow_delete = $this->user->allow_delete_on(__CLASS__);

        $this->plan = FALSE;
        
        $this->departamento = new departamento_m();
        $this->ciudad = new ciudad_m();
        $this->barrio = new barrio_m();
        
        $this->estacionamiento = new estacionamiento_m();
        $this->generadores = new generadores_m();
        $this->bloque = new bloque_m();
        $this->dependencia = new dependencia_m();
        $this->tipo = new tipo_m();
        $this->dia = new dia_m();
        $this->contingencia = new contingencia_m();
        $this->amenaza = new amenaza_m();
 
         //SE SE PASA POR EL METODO _GET UN VALOR cod 
        if (isset($_GET['cod'])) {
            //una instancia nueva de empleado_m
            $plan = new plan_m();
            //CARGA LA VARIABLE PUBLICA empleado con los datos del empleado con el codigo enviado
            $this->plan = $plan->get(trim($_GET['cod']));
        }
        
         //SI CARGA LOS DATOS 
        if ($this->plan) {
            $this->page->title .= ' ' . $this->plan->id_plan;                                        
            if (isset($_POST['vmodifica1'])) {
                $this->modificar();
            }elseif (isset($_POST['vmodifica2'])) {                 
                if ($_POST['adjuntar']=true){
                     //PARA Q NO ENTRE CADA VEZ QUE MODIFIQUE OTROS CAMPSO
                    if( empty($this->plan->mapa_sector) ){                       
                     $this->cargaradjunto();
                    } if( empty($this->plan->organigrama_institucion)){                       
                     $this->cargaradjuntoorganigrama();
                    }
                }                 
                
                $this->modificar1();
            } elseif (isset($_POST['vmodifica3'])) {                                
                $this->modificar2();
            } 
            else  if (isset($_GET['veradjunto'])) { /// Ver Adjujnto
                $this->ver_adjunto($_GET['veradjunto']);
             }else if (isset($_GET['eliminaradjunto'])) { /// Eliminar Archivo adjunto
                $this->elimina_adjunto($_GET['eliminaradjunto']);
             }else  if (isset($_GET['veradjuntoorganigrama'])) { /// Ver Adjujnto
                $this->ver_adjuntoorganigrama($_GET['veradjuntoorganigrama']);
             }else if (isset($_GET['eliminaradjuntoorganigrama'])) { /// Ver Adjujnto
                 $this->elimina_adjuntoorganigrama($_GET['eliminaradjuntoorganigrama']);
             }else if (isset($_POST['codestacionamiento'])) { /// añadir/modificar ESTACIONAMIENTO
                $this->edit_estacionamiento();
             }else if (isset($_GET['eliminarestacionamiento'])) { /// eliminar estacionamiento
                 $this->elimina_estacionamiento($_GET['eliminarestacionamiento']);
             }else if (isset($_POST['codgenerador'])) { /// añadir/modificar ESTACIONAMIENTO
                $this->edit_generador();
             }else if (isset($_GET['eliminargenerador'])) { /// eliminar estacionamiento
                 $this->elimina_generador($_GET['eliminargenerador']);
             }else if (isset($_POST['codcontingencia'])) { /// añadir/modificar ESTACIONAMIENTO
                $this->edit_contingencia();
             }else if (isset($_GET['eliminarcontingencia'])) { /// eliminar estacionamiento
                 $this->elimina_contingencia($_GET['eliminarcontingencia']);
             }else if (isset($_POST['codamenaza'])) { /// añadir/modificar ESTACIONAMIENTO
                $this->edit_amenaza();
             }
             else if (isset($_GET['eliminaramenza'])) { /// eliminar estacionamiento
                 $this->elimina_amenaza($_GET['eliminaramenza']);
             }
             
                 
             
             
           
        }else {
            $this->new_error_msg("Plan de Emergencia no encontrado.", 'error', FALSE, FALSE);
        }
        
    }
    private function modificar()
    {
         if (isset($_POST['vruc'])) {
                $this->plan->id_plan = $_POST['vidplan'];
                $this->plan->ruc = $_POST['vruc'];
                $this->plan->razon_social = $_POST['vrazon'];
                $this->plan->direccion = $_POST['vdireccion'];
                $this->plan->telefono = $_POST['vtelefono'];
                $this->plan->correo_electronico = $_POST['vcorreo'];
                $this->plan->actividad = $_POST['vactividad'];
                $this->plan->representante_legal = $_POST['vrepresentante'];
                $this->plan->responsable_plan = $_POST['vresponsable'];
                
                //GRABAR LOS OTROS DATOS
                $this->plan->introduccion = $_POST['vintroduccion'];
                $this->plan->objetivos = $_POST['vobjetivo'];
                $this->plan->alcance = $_POST['valcance'];
                $this->plan->politica = $_POST['vpolitica'];
                $this->plan->marco_legal = $_POST['vmarcolegal'];
                $this->plan->historia = $_POST['vhistoria'];

                //SI GUARDA LOS DATOS MUESTRA MENSAJE SATISFACTORIO
                if ($this->plan->save()) {
                    $this->new_message("Datos de Plan de Emergencia guardados correctamente.");
                } else
                    $this->new_error_msg("¡Imposible guardar los datos!");
        }else if (isset($_POST['imagen'])) {
            $this->edit_imagen();
        } else if (isset($_GET['delete_img'])) {
            $this->eliminar_imagen();
        }
    }
    
    private function modificar1()
    {
         if (isset($_POST['vdepartamento'])) {
               
                $this->plan->id_plan = $_POST['vidplan'];
                $this->plan->id_departamento = $_POST['vdepartamento'];
                $this->plan->id_ciudad = $_POST['vciudad'];
                $this->plan->id_barrio = $_POST['vbarrio'];
                $this->plan->lindero_norte = $_POST['vnorte'];
                $this->plan->lindero_sur = $_POST['vsur'];
                $this->plan->lindero_este = $_POST['veste'];
                $this->plan->lindero_oeste = $_POST['voeste'];
                $this->plan->fecha_construccion = $_POST['vfechaconstruccion'];
                $this->plan->nro_estructuras = $_POST['vnroestructura'];
                $this->plan->nro_pisos = $_POST['vnropiso'];
                $this->plan->area_total = $_POST['vareatotal'];
                $this->plan->descripcion_techos = $_POST['vdescripciontecho'];
                $this->plan->acabado_pisos = $_POST['vacabadopiso'];
                $this->plan->acabado_paredes = $_POST['vacabadoparedes'];
                $this->plan->acabado_cielorrasos = $_POST['vacabadocieloraso'];
                $this->plan->acabado_divisiones = $_POST['vacabadocdivisiones'];
                $this->plan->servicio_medico = $_POST['vserviciomedico'];
                $this->plan->servicio_medicopersonal = $_POST['vpersonalasignado'];
                
                $this->plan->alcantarillado = $_POST['valcantarillado'];
                $this->plan->acueducto = $_POST['vacueducto'];
                $this->plan->energia_electrica = $_POST['venergiaelectrica'];
                $this->plan->telefono_servicio = $_POST['vtelefonoservicio'];
                $this->plan->gas_natural = $_POST['vgasnatural'];
                $this->plan->gas_propano = $_POST['vgaspropano'];
                $this->plan->ups = $_POST['vups'];
                $this->plan->tanque_reserva = $_POST['vtanquereserva'];
                $this->plan->hidrantes_externo = $_POST['vhidranteexterno'];
                $this->plan->redhidraulica_contraincendio = $_POST['vredhidraulicaincendio'];
                $this->plan->aire_acondicionado = $_POST['vaireacondicionado'];
                
                //SI GUARDA LOS DATOS MUESTRA MENSAJE SATISFACTORIO
                if ($this->plan->save()) {
                    $this->new_message("Datos de Plan de Emergencia guardados correctamente.");
                } else
                    $this->new_error_msg("¡Imposible guardar los datos!");
        }
        
//        else if (isset($_POST['imagen'])) {
//            $this->edit_imagen();
//        } else if (isset($_GET['delete_img'])) {
//            $this->eliminar_imagen();
//        }
    }
    
      private function modificar2()
    {
         if (isset($_POST['vdefinicioanalisis'])) {
               
                $this->plan->id_plan = $_POST['vidplan'];
                $this->plan->definicion = $_POST['vdefinicioanalisis'];
                $this->plan->objetivo_especifico = $_POST['vobjetivoespecifico'];
                               
                //SI GUARDA LOS DATOS MUESTRA MENSAJE SATISFACTORIO
                if ($this->plan->save()) {
                    $this->new_message("Datos de Plan de Emergencia - Analisis de Riesgo guardados correctamente.");
                } else
                    $this->new_error_msg("¡Imposible guardar los datos!");
        }
        
    }
    //METODO PARA EDITAR ESTACIONAMIENTO O AGREGAR
    private function edit_estacionamiento()
    {        
        $estudio = new estacionamiento_m();
        $this->estacionamiento = NULL;
        if ($_POST['codestacionamiento'] != '') {
           // $this->conyuge = $estudio->get($_POST['codestudio']); //$dir->get($_POST['codconyuge']);
        }
        if( isset($_POST['varea'])){                              
            $estudio->id_plan = $this->plan->id_plan;
            $estudio->area = $_POST['varea'];
            $estudio->capacidad = $_POST['vcapacidad'];
           
            if ($estudio->save()) {
                $this->new_message("Estacionamiento guardado correctamente.");
            } else {
                $this->new_message("¡Imposible guardar Estacionamiento!");
            }
       }  else {
           $this->new_message("NO SE ENCONTRO LA VARIABLE Estacionamiento");
       }
    }
    
    private function edit_generador()
    {        
        $estudio = new generadores_m();
        $this->generadores = NULL;
        if ($_POST['codgenerador'] != '') {
           // $this->conyuge = $estudio->get($_POST['codestudio']); //$dir->get($_POST['codconyuge']);
        }
        if( isset($_POST['vdescripciongenerador'])){                              
            $estudio->id_plan = $this->plan->id_plan;
            $estudio->descripcion = $_POST['vdescripciongenerador'];
            $estudio->capacidad = $_POST['vcapacidad'];
           
            if ($estudio->save()) {
                $this->new_message("Generador guardado correctamente.");
            } else {
                $this->new_message("¡Imposible guardar Generador!");
            }
       }  else {
           $this->new_message("NO SE ENCONTRO LA VARIABLE Generador");
       }
    }
    
    private function edit_contingencia()
    {        
        $estudio = new contingencia_m();
        $this->contingencia = NULL;
        if ($_POST['codcontingencia'] != '') {
           // $this->conyuge = $estudio->get($_POST['codestudio']); //$dir->get($_POST['codconyuge']);
        }
        if( isset($_POST['vbloque'])){                              
            $estudio->id_plan = $this->plan->id_plan;
            $estudio->id_bloque = $_POST['vbloque'];
            $estudio->id_dependencia = $_POST['vdependencia'];
            $estudio->id_tipo = $_POST['vtipo'];
            $estudio->id_dia = $_POST['vdia'];
            $estudio->hora_desde = $_POST['vhoradesde'];
            $estudio->hora_hasta = $_POST['vhorahasta'];
           
            if ($estudio->save()) {
                $this->new_message("Contingencia guardado correctamente.");
            } else {
                $this->new_message("¡Imposible guardar Contingencia!");
            }
       }  else {
           $this->new_message("NO SE ENCONTRO LA VARIABLE Contingencia");
       }
    }
    private function edit_amenaza()
    {        
        $estudio = new amenaza_m();
        $this->amenaza = NULL;
        if ($_POST['codamenaza'] != '') {
           // $this->conyuge = $estudio->get($_POST['codestudio']); //$dir->get($_POST['codconyuge']);
        }
        if( isset($_POST['vamenaza'])){                              
            $estudio->id_plan = $this->plan->id_plan;
            $estudio->amenaza = $_POST['vamenaza'];
            $estudio->id_tipo = $_POST['vtipoamenaza'];
            $estudio->clase = $_POST['vclase'];
            $estudio->origen = $_POST['vorigen'];
            $estudio->probabilidad = $_POST['vprobabilidad'];
            $estudio->impacto = $_POST['vimpacto'];
            $estudio->controlexistente = $_POST['vcontrolexistente'];
            $estudio->probabilidad1 = $_POST['vprobabilidad1'];
            $estudio->impacto1 = $_POST['vimpacto1'];
           
            if ($estudio->save()) {
                $this->new_message("Amenaza guardado correctamente.");
            } else {
                $this->new_message("¡Imposible guardar Amenaza!");
            }
       }  else {
           $this->new_message("NO SE ENCONTRO LA VARIABLE Amenaza");
       }
    }
    
    private function edit_imagen()
    {
        if (is_uploaded_file($_FILES['fimagen']['tmp_name'])) {
            $png = ( substr(strtolower($_FILES['fimagen']['name']), -3) == 'png' );
            $this->plan->set_imagen(file_get_contents($_FILES['fimagen']['tmp_name']), $png);
            if ($this->plan->save()) {
                $this->new_message("Imagen del Plano del Sitio modificada correctamente");
            } else {
                $this->new_error_msg("¡Error al guardar la imagen del Plano del Sitio!");
            }
        }
    }

    private function eliminar_imagen()
    {
        $this->plan->set_imagen(NULL);
        if ($this->plan->save()) {
            $this->new_message("Imagen del Plano del Sitio eliminada correctamente");
        } else {
            $this->new_error_msg("¡Error al eliminar la imagen del Plano del Sitio!");
        }
    }
    
    
    private function cargaradjunto(){         
        // $numlineas = intval($_POST['numlineas']);
         // for ($i = 1; $i <= $numlineas; $i++) {              
              if (isset($_POST['adjuntar'])) {
                  // $this->new_message("Entrooooo".$_FILES['fimagen_'.$numlineas]);
                  //si no hay error de archivo
                  if($_FILES['vmapasector']["error"]>0){
                      //$this->new_error_msg("¡Error al Cargar Archivo !");
                  }  else {
                      //Extensiones permitidas
                      $permitidos = array("application/pdf");
                      $limite_kb = 10000;
                      
                      if(in_array($_FILES['vmapasector']["type"], $permitidos) && $_FILES['vmapasector']["size"] <= $limite_kb * 1024){
                          //una carpeta dentro del proyecto
                          //$this->new_advice($_POST['vestcodigo_'.$numlineas]);
                          $ruta = 'extras/'.$_POST['vidplan'].'/';
                          //$this->new_advice('Ruta: '.$ruta);
                          //nombre del achivo   //PUESE ASI POR SI SE LEVANTE VARIOS ARCHIVOS DEL MISMO
                          $archivo = $ruta.$_FILES['vmapasector']["name"];
                          //Verifica si existe la ruta si no la crea
                          if(!file_exists($ruta)){
                              mkdir($ruta);
                          }
                          //Verfica si el archivo ya existe
                          if(!file_exists($archivo)){
                              //AQUI MUEVE EL ARCHIVO DEL TEMPORAL A LA DIRECCION DEL SERVER
                              $resultado = @move_uploaded_file($_FILES['vmapasector']["tmp_name"], $archivo);
                              if ($resultado) {
                                  //AQUI ACTUALIZA EL CAMPO RESULTADO CON EL NOMBRE DEL ARVHIVO
                                  //$this->estudio->cargaresultado($_POST['vidplan'], $archivo,$_FILES['vmapasector']["name"]);
                                  $this->plan->mapa_sector = $archivo;
                                  $this->new_message("¡Arvhivo guardado  !");
                              }  else {
                                  $this->new_error_msg("¡Error al Guardar Archivo  !");
                              }
                          }  else {
                              $this->new_error_msg("¡Archivo ya existe !");
                          }
                      }  else {
                          $this->new_error_msg("¡Archivo no permitido o excede el tamaño  !");
                      }
                  }
              }              
         // }
     }
     
      private function cargaradjuntoorganigrama(){         
        // $numlineas = intval($_POST['numlineas']);
         // for ($i = 1; $i <= $numlineas; $i++) {              
              if (isset($_POST['adjuntar'])) {
                  // $this->new_message("Entrooooo".$_FILES['fimagen_'.$numlineas]);
                  //si no hay error de archivo
                  if($_FILES['vorganigrama']["error"]>0){
                      //$this->new_error_msg("¡Error al Cargar Archivo !");
                  }  else {
                      //Extensiones permitidas
                      $permitidos = array("application/pdf");
                      $limite_kb = 10000;
                      
                      if(in_array($_FILES['vorganigrama']["type"], $permitidos) && $_FILES['vorganigrama']["size"] <= $limite_kb * 1024){
                          //una carpeta dentro del proyecto
                          //$this->new_advice($_POST['vestcodigo_'.$numlineas]);
                          $ruta = 'extras/'.$_POST['vidplan'].'/';
                          //$this->new_advice('Ruta: '.$ruta);
                          //nombre del achivo   //PUESE ASI POR SI SE LEVANTE VARIOS ARCHIVOS DEL MISMO
                          $archivo = $ruta.$_FILES['vorganigrama']["name"];
                          //Verifica si existe la ruta si no la crea
                          if(!file_exists($ruta)){
                              mkdir($ruta);
                          }
                          //Verfica si el archivo ya existe
                          if(!file_exists($archivo)){
                              //AQUI MUEVE EL ARCHIVO DEL TEMPORAL A LA DIRECCION DEL SERVER
                              $resultado = @move_uploaded_file($_FILES['vorganigrama']["tmp_name"], $archivo);
                              if ($resultado) {
                                  //AQUI ACTUALIZA EL CAMPO RESULTADO CON EL NOMBRE DEL ARVHIVO
                                  //$this->estudio->cargaresultado($_POST['vidplan'], $archivo,$_FILES['vmapasector']["name"]);
                                  $this->plan->organigrama_institucion = $archivo;
                                  $this->new_message("¡Arvhivo guardado  !");
                              }  else {
                                  $this->new_error_msg("¡Error al Guardar Archivo  !");
                              }
                          }  else {
                              $this->new_error_msg("¡Archivo ya existe !");
                          }
                      }  else {
                          $this->new_error_msg("¡Archivo no permitido o excede el tamaño  !");
                      }
                  }
              }              
         // }
     }
    public function ver_adjunto($codestudio){
          $this->planxcodigo = $this->plan->get($codestudio);
          header('content-type: application/pdf');
          header('Content-Disposition: inline; filename="'.$this->planxcodigo->mapa_sector.'"');

          //$file = $this->estudioxcodigo->resultado;
          //chmod($file, 0777);
          readfile($this->planxcodigo->mapa_sector);
     }
     
     public function ver_adjuntoorganigrama($codestudio){
          $this->planxcodigo = $this->plan->get($codestudio);
          header('content-type: application/pdf');
          header('Content-Disposition: inline; filename="'.$this->planxcodigo->organigrama_institucion.'"');

          //$file = $this->estudioxcodigo->resultado;
          //chmod($file, 0777);
          readfile($this->planxcodigo->organigrama_institucion);
     }
     
     private function elimina_adjunto($codestudio){
         $this->planxcodigo = $this->plan->get($codestudio);
         
         $file = $this->planxcodigo->mapa_sector;
         //$this->new_error_msg("arc ".$file);
         if (is_file($file)) {
             
             chmod($file, 0777);
             if (!unlink($file)) {
                $this->new_error_msg("No se pudo borrar el archivo ".$file);
             }  else {
                 //ACTUALIZA A NULL LOS CAMPOS
                  //$this->new_error_msg("OTRO ");
                 $this->plan->actualizamapasector($codestudio);
             }
         }
     }
     
      private function elimina_adjuntoorganigrama($codestudio){
         $this->planxcodigo = $this->plan->get($codestudio);
         
         $file = $this->planxcodigo->organigrama_institucion;
         //$this->new_error_msg("arc ".$file);
         if (is_file($file)) {
             
             chmod($file, 0777);
             if (!unlink($file)) {
                $this->new_error_msg("No se pudo borrar el archivo ".$file);
             }  else {
                 //ACTUALIZA A NULL LOS CAMPOS
                  //$this->new_error_msg("OTRO ");
                 $this->plan->actualizaorganigrama_institucion($codestudio);
             }
         }
     }
     
     private function elimina_estacionamiento($cod){
        
         if ($this->plan->elimina_estacionamiento($cod)) {
                $this->new_message('Estacionamiento Nro. '. $cod .' ha sido de Eliminado correctamente.');
            } else {
                    $this->new_error_msg('Imposible Eliminaar el Estacionamiento.');
            }
     }
     
     private function elimina_generador($cod){
        
         if ($this->plan->elimina_generador($cod)) {
                $this->new_message('Genearador Nro. '. $cod .' ha sido de Eliminado correctamente.');
            } else {
                    $this->new_error_msg('Imposible Eliminaar el Genearador.');
            }
     }
     
      private function elimina_contingencia($cod){
        
         if ($this->plan->elimina_contingencia($cod)) {
                $this->new_message('Contingencia Nro. '. $cod .' ha sido de Eliminado correctamente.');
            } else {
                    $this->new_error_msg('Imposible Eliminaar el Contingencia.');
            }
     }
     
     private function elimina_amenaza($cod){
        
         if ($this->plan->elimina_amenaza($cod)) {
                $this->new_message('Amenaza Nro. '. $cod .' ha sido de Eliminado correctamente.');
            } else {
                    $this->new_error_msg('Imposible Eliminaar el Amenaza.');
            }
     }
     
     
     
     
            
     
    public function url() {
        if (!isset($this->plan)) {
            return parent::url();
        } else if ($this->plan) {
            return $this->plan->url();
        } else
            return $this->page->url();
    }

 
 
}
