<?php
class PatientsMetricsModel extends CommonModel {
  function __construct() {
    parent::__construct();
    $this->table_name = "patientmetrics";
    $this->field_names = array("patientmetric_value");
    $this->key_names = array("patientmetric_code","patientmetric_patient_id");
  }

}
