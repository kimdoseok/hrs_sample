<?php
class PatientsMetricsController {
//| Method | Segment                    | Controller class name         | Controller method name | Parameters                                  |
//| GET    | /patients/2/metrics        | PatientsMetricsController     | index                  | `index($patientId)`                         |
//| GET    | /patients/2/metrics/abc    | PatientsMetricsController     | get                    | `get($patientId, $metricId)`                |
//| POST   | /patients/2/metrics        | PatientsMetricsController     | create                 | `create($patientId)`                        |
//| PATCH  | /patients/2/metrics/abc    | PatientsMetricsController     | update                 | `update($patientId, $metricId)`             |       
//| DELETE | /patients/2/metrics/abc    | PatientsMetricsController     | delete                 | `delete($patientId, $metricId)`             |

  function index($path_arr) {
    $this->patientmetric_data = new PatientsMetricsModel;
    $numpath = count($path_arr);
    if ($numpath<5) {
      if ($_SERVER["REQUEST_METHOD"]=="GET") {
        if ($numpath>3) {
          $this->get($path_arr[1],$path_arr[3]);
        } else {
          echo json_encode(array("errno"=>1,""=>"Nothing to do"));
        }
      } else if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $this->create();     
      } else if ($_SERVER["REQUEST_METHOD"]=="PATCH") {
        $this->update($path_arr[1],$path_arr[3]);
      } else if ($_SERVER["REQUEST_METHOD"]=="DELETE") {
        $this->delete($path_arr[1],$path_arr[3]);
      } else {
          echo json_encode(array("errno"=>3,""=>"Not support method"));      
      }
    } else {
      echo json_encode(array("errno"=>4,""=>"Parameter Error"));      
    }
  }
  
  function get($patient_id,$patientmetric_code) {
    settype($patient_id,"int");
    $keyarr = array("patientmetric_patient_id"=>$patient_id,"patientmetric_code"=>$patientmetric_code );
    $outarr = $this->patientmetric_data->select($keyarr);
    echo json_encode($outarr);
  }
  
  function create() {
    $tmp_arr = array();
    parse_str(file_get_contents('php://input'), $tmp_arr);
    if (count($tmp_arr)<1) {
      echo json_encode(array("errno"=>20,"errmsg"=>"Not supported data"));
      die;
    }
    $keys = array_keys($tmp_arr);
    $inarr = json_decode($keys[0], true);
    $outarr = $this->patientmetric_data->insert($inarr);
    echo json_encode($outarr);    
  }
  
  function update($patient_id,$patientmetric_code) {
    $tmp_arr = array();
    parse_str(file_get_contents('php://input'), $tmp_arr);
    if (count($tmp_arr)<1) {
      echo json_encode(array("errno"=>20,"errmsg"=>"Not supported data"));
      die;
    }
    $keys = array_keys($tmp_arr);
    $inarr = json_decode($keys[0], true);
    $field_arr = array("patientmetric_value"=>$inarr['patientmetric_value']);
    settype($patient_id,"int");
    $key_arr = array("patientmetric_patient_id"=>$patient_id, "patientmetric_code"=>$patientmetric_code);
    $outarr = $this->patientmetric_data->update($field_arr,$key_arr);
    echo json_encode($outarr);
  }
  
  function delete($patient_id,$patientmetric_code) {
    settype($patient_id,"int");
    $key_arr = array("patientmetric_patient_id"=>$patient_id, "patientmetric_code"=>$patientmetric_code);
    $outarr = $this->patientmetric_data->delete($key_arr);
    echo json_encode($outarr);
  }
  
}