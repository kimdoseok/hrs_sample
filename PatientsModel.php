<?php
class PatientsModel extends CommonModel {
  function __construct() {
    parent::__construct();
    $this->table_name = "patients";
    $this->field_names = array("patient_name");
    $this->key_names = array("patient_id");
  }

}
