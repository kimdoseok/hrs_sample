<?php
spl_autoload_register(function ($classname) {
    include $classname . '.php';
});

$route = new Route;

$route->get("/patients",function($argarr){
  $patient_controller = new PatientsController;
  $patient_controller->index($argarr);
});

$route->get("/patients.metrics",function($argarr){
  $patients_metrics_controller = new PatientsMetricsController;
  $patients_metrics_controller->index($argarr);
});

$route->get("/doctors",function($argarr){
  echo json_encode(array("errno"=>2,""=>"Not yet implemented"));
});

