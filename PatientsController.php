<?php
class PatientsController {
//| Method | Segment      | Controller class name | Controller method name | Parameters                                                      |
//| GET    | /patients    | PatientsController    | index                  | none                                                            |
//| GET    | /patients/2  | PatientsController    | get                    | this should invoke `get($patientId)` where $patientId = 2       |
//| POST   | /patients    | PatientsController    | create                 | none (extra credit for handling the request body)               |
//| PATCH  | /patients/2  | PatientsController    | update                 | `update($patientId)`                                            |       
//| DELETE | /patients/2  | PatientsController    | delete                 | `delete($patientId)`                                            |

  function index($path_arr) {
    $this->patient_data = new PatientsModel;
    $numpath = count($path_arr);
    if ($numpath<3) {
      if ($_SERVER["REQUEST_METHOD"]=="GET") {
        if (count($path_arr)>1) {
          $this->get($path_arr[1]);
        } else {
          echo json_encode(array("errno"=>1,""=>"Nothing to do"));
        }
      } else if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $this->create();     
      } else if ($_SERVER["REQUEST_METHOD"]=="PATCH") {
        $this->update($path_arr[1]);
      } else if ($_SERVER["REQUEST_METHOD"]=="DELETE") {
        $this->delete($path_arr[1]);
      } else {
          echo json_encode(array("errno"=>3,""=>"Not support method"));      
      }
    } else {
      echo json_encode(array("errno"=>4,""=>"Parameter Error"));      
    }
  }
  
  function get($patient_id) {
    settype($patient_id,"int");
    $keyarr = array("patient_id"=>$patient_id);
    $outarr = $this->patient_data->select($keyarr);
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
    $outarr = $this->patient_data->insert($inarr);
    echo json_encode($outarr);    
  }
  
  function update($patient_id) {
    $tmp_arr = array();
    parse_str(file_get_contents('php://input'), $tmp_arr);
    if (count($tmp_arr)<1) {
      echo json_encode(array("errno"=>20,"errmsg"=>"Not supported data"));
      die;
    }
    $keys = array_keys($tmp_arr);
    $inarr = json_decode($keys[0], true);
    $field_arr = array("patient_name"=>$inarr['patient_name']);
    settype($patient_id,"int");
    $key_arr = array("patient_id"=>$patient_id);
    $outarr = $this->patient_data->update($field_arr,$key_arr);
    echo json_encode($outarr);
  }
  
  function delete($patient_id) {
    settype($patient_id,"int");
    $key_arr = array("patient_id"=>$patient_id);
    $outarr = $this->patient_data->delete($key_arr);
    echo json_encode($outarr);
  }
}
