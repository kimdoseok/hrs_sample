<?php
class CommonModel {
  function __construct() {
    $this->pdo = new PDO("sqlite:./hrsdata.db");
    $queries = array();
    array_push($queries,"create table if not exists patients (patient_id integer primary key, patient_name text)");
    array_push($queries,"create table if not exists patientmetrics (patientmetric_code varchar(32) primary key, patientmetric_patient_id integer, patientmetric_value integer default 0, FOREIGN KEY(patientmetric_patient_id) REFERENCES patients(patientmetric_patient_id))");
    for ($i=0;$i<count($queries);$i++) {
      $stmt = $this->pdo->prepare($queries[$i]);
      $stmt->execute();
    }
    $this->table_name = "";
  }
  
  function select($keydata_arr) {
    $data_arr = array();
    $query = "SELECT * FROM ".$this->table_name." WHERE ";
    $i=0;
    foreach ($keydata_arr as $key => $value) {
      if ($i>0) {
        $query .= " AND ";
      }
      $query .= $key."=?";
      array_push($data_arr,$value);
      $i++;
    }
    $stmt = $this->pdo->prepare($query);
    $stmt->execute($data_arr);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($row) {
      $row["errno"]=0;
      $row["errmsg"]="OK";
      return $row;
    } else {
      return array("errno"=>10,"errmsg"=>"Not found record");
    }
  }
  
  function insert($fielddata_arr) {
    $fieldstr = "";
    $valuestr = "";
    $i = 0;
    $data_arr = array();
    
    foreach ($fielddata_arr as $key => $value) {
      if ($i>0) {
        $fieldstr .= ",";
        $valuestr .= ",";
      }
      $fieldstr .= $key;
      $valuestr .= "?";
      array_push($data_arr,$value);
      $i++;
    }
    $query = "INSERT INTO ".$this->table_name." (".$fieldstr.") VALUES (".$valuestr.")";
    $this->pdo->beginTransaction();
    $stmt = $this->pdo->prepare($query);
    $stmt->execute($data_arr);
    $stmt = $this->pdo->prepare("SELECT last_insert_rowid()");
    $stmt->execute();
    $row = $stmt->fetch();
    $outarr = array("errno"=>0,"errmsg"=>"OK", "insert_id" => 0);
    if ($row) {
      $outarr["insert_id"]=$row[0];
    } else {
      $outarr["errno"]=11;
      $outarr["errmsg"]="Insertion has failed";
    }
    $this->pdo->commit();
    return $outarr;
  }
  
  function update($fielddata_arr,$keydata_arr) {
    $fieldstr = "";
    $i=0;
    $data_arr = array();
    foreach ($fielddata_arr as $key => $value) {
      if ($i>0) {
        $fieldstr .= ",";
      }
      $fieldstr .= $key."=?";
      array_push($data_arr,$value);
      $i++;
    }
    $keystr = "";
    $i=0;
    foreach ($keydata_arr as $key => $value) {
      if ($i>0) {
        $keystr .= " AND ";
      }
      $keystr .= $key."=?";
      array_push($data_arr,$value);
      $i++;
    }
    $query = "UPDATE ".$this->table_name." SET ".$fieldstr." WHERE ".$keystr;
    
    $this->pdo->beginTransaction();
    $stmt = $this->pdo->prepare($query);
    $outarr = array("errno"=>0,"errmsg"=>"OK");
    if (!$stmt->execute($data_arr)) {
      $outarr["errno"]=12;
      $outarr["errmsg"]="Updating has failed";
    }
    $this->pdo->commit();
    return $outarr;
  }
  
  function delete($keydata_arr) {
    $keystr = "";
    $i=0;
    $data_arr = array();
    foreach ($keydata_arr as $key => $value) {
      if ($i>0) {
        $keystr .= " AND ";
      }
      $keystr .= $key."=?";
      array_push($data_arr,$value);
      $i++;
    }
    $query = "DELETE FROM ".$this->table_name." WHERE ".$keystr;
    $this->pdo->beginTransaction();
    $stmt = $this->pdo->prepare($query);
    $stmt->execute($data_arr);
    $this->pdo->commit();
    $outarr = array("errno"=>0,"errmsg"=>"OK");
    return $outarr;
  }
}
