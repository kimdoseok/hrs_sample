<?php
use PHPUnit\Framework\TestCase;

class testHRSSample extends TestCase
{
//| Method | Segment      | Controller class name | Controller method name | Parameters                                                      |
//| GET    | /patients    | PatientsController    | index                  | none                                                            |
//| GET    | /patients/2  | PatientsController    | get                    | this should invoke `get($patientId)` where $patientId = 2       |
//| POST   | /patients    | PatientsController    | create                 | none (extra credit for handling the request body)               |
//| PATCH  | /patients/2  | PatientsController    | update                 | `update($patientId)`                                            |       
//| DELETE | /patients/2  | PatientsController    | delete                 | `delete($patientId)`                                            |

//| Method | Segment                    | Controller class name         | Controller method name | Parameters                                  |
//| GET    | /patients/2/metrics        | PatientsMetricsController     | index                  | `index($patientId)`                         |
//| GET    | /patients/2/metrics/abc    | PatientsMetricsController     | get                    | `get($patientId, $metricId)`                |
//| POST   | /patients/2/metrics        | PatientsMetricsController     | create                 | `create($patientId)`                        |
//| PATCH  | /patients/2/metrics/abc    | PatientsMetricsController     | update                 | `update($patientId, $metricId)`             |       
//| DELETE | /patients/2/metrics/abc    | PatientsMetricsController     | delete                 | `delete($patientId, $metricId)`             |
  
  public function testPatientsCreate() {
    
    $data = array("patient_name" => "Kim");                                                                    
    $data_string = json_encode($data);                                                                                   

    $urlstr = "http://localhost:8888/patients";
    $ch = curl_init($urlstr);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($data_string))                                                                       
    );                                                                                                                   
    $result = curl_exec($ch);
    $result_arr = json_decode($result,true);                                                                                   
    
    fwrite(STDERR, print_r($result_arr, TRUE));
    $this->assertSame(0, $result_arr["errno"]);
    
  }

  public function testPatientsGet() {
    
    $urlstr = "http://localhost:8888/patients/1";
    $ch = curl_init($urlstr);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json'                                                                                
    ));
    $result = curl_exec($ch);
    $result_arr = json_decode($result,true);
    
    fwrite(STDERR, print_r($result_arr, TRUE));
    $this->assertSame(0, $result_arr["errno"]);
    
  }

  public function testPatientsUpdate() {
    
    $data = array("patient_name" => "Doseok");                                                                    
    $data_string = json_encode($data);                                                                                   

    $urlstr = "http://localhost:8888/patients/1";
    $ch = curl_init($urlstr);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($data_string))                                                                       
    );                                                                                                                   
    $result = curl_exec($ch);
    $result_arr = json_decode($result,true);                                                                                   
    
    fwrite(STDERR, print_r($result_arr, TRUE));
    $this->assertSame(0, $result_arr["errno"]);
    
  }


  public function testPatientsMetricsCreate() {
    
    $data = array("patientmetric_code" => "abc","patientmetric_patient_id"=>1,"patientmetric_value" => 123);                                                                    
    $urlstr = "http://localhost:8888/patients/1/metrics";
    $data_string = json_encode($data);                                                                                   

    $ch = curl_init($urlstr);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($data_string))                                                                       
    );                                                                                                                   
    $result = curl_exec($ch);
    $result_arr = json_decode($result,true);                                                                                   
    
    fwrite(STDERR, print_r($result_arr, TRUE));
    $this->assertSame(0, $result_arr["errno"]);
    
  }

  public function testPatientsMetricsGet() {
    
    $urlstr = "http://localhost:8888/patients/1/metrics/abc";
    $ch = curl_init($urlstr);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json'                                                                                
    ));
    $result = curl_exec($ch);
    $result_arr = json_decode($result,true);
    
    fwrite(STDERR, print_r($result_arr, TRUE));
    $this->assertSame(0, $result_arr["errno"]);
    
  }

  public function testPatientsMetricsUpdate() {
    
    $data = array("patientmetric_value" => 456);                                                                    
    $urlstr = "http://localhost:8888/patients/1/metrics/abc";
    $data_string = json_encode($data);                                                                                   

    $ch = curl_init($urlstr);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($data_string))                                                                       
    );                                                                                                                   
    $result = curl_exec($ch);
    $result_arr = json_decode($result,true);                                                                                   
    
    fwrite(STDERR, print_r($result_arr, TRUE));
    $this->assertSame(0, $result_arr["errno"]);
    
  }

  public function testPatientsMetricsDelete() {

    $urlstr = "http://localhost:8888/patients/1";
    $ch = curl_init($urlstr);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json'                                                                                
    ));
    $result = curl_exec($ch);
    $result_arr = json_decode($result,true);
    
    fwrite(STDERR, print_r($result_arr, TRUE));
    $this->assertSame(0, $result_arr["errno"]);
    
  }

  public function testPatientsDelete() {

    $urlstr = "http://localhost:8888/patients/1";
    $ch = curl_init($urlstr);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json'                                                                                
    ));
    $result = curl_exec($ch);
    $result_arr = json_decode($result,true);
    
    fwrite(STDERR, print_r($result_arr, TRUE));
    $this->assertSame(0, $result_arr["errno"]);
  }


}