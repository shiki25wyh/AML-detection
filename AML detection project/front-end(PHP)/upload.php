<?php
include 'config.php';

$target_dir = "../../private_fintech/uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if ($_FILES["fileToUpload"]["size"] > 20100000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

if($FileType != "csv" && $FileType != "txt") {
  echo "Sorry, only txt & csv files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "../../private_fintech/uploads/test.csv")) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    
    $db->query("Delete from transections");
    
    ftp_upload("../../private_fintech/uploads/test.csv");
    
    
                    // Open uploaded CSV file with read-only mode
                    $csvFile = fopen('../../private_fintech/uploads/test.csv', 'r');
                    
                    // Skip the first line
                    fgetcsv($csvFile);
    
                    // Parse data from CSV file line by line
                    while(($line = fgetcsv($csvFile)) !== FALSE){
                        
                        
                        // Get row data
                        $idx = $line[0];
                        $step = $line[1];
                        $type = $line[2];
                        $amount = $line[3];
                        $nameOrig = $line[4];
                        $oldbalanceOrg = $line[5];
                        $newbalanceOrig = $line[6];
                        $nameDest = $line[7];
                        $oldbalanceDest = $line[8];
                        $newbalanceDest = $line[9];
                        //$isFraud = $line[10];
                        $isFlaggedFraud = $line[10];
                        
                        //echo "<br>" . $idx . " -- " .$amount;
                        //echo "<br>INSERT INTO transections (idx, step, type, amount, nameOrig, oldbalanceOrg, newbalanceOrig, nameDest, oldbalanceDest, newbalanceDest, isFraud, isFlaggedFraud ) VALUES ('".$idx."', '".$step."', '".$type."', '".$amount."', '".$nameOrig."', '".$oldbalanceOrg."', '".$newbalanceOrig."', '".$nameDest."', '".$oldbalanceDest."', '".$newbalanceDest."', '".$isFraud."', '".$isFlaggedFraud."')";
                        
                        $db->query("INSERT INTO transections (idx, step, type, amount, nameOrig, oldbalanceOrg, newbalanceOrig, nameDest, oldbalanceDest, newbalanceDest, isFraud, isFlaggedFraud ) VALUES ('".$idx."', '".$step."', '".$type."', '".$amount."', '".$nameOrig."', '".$oldbalanceOrg."', '".$newbalanceOrig."', '".$nameDest."', '".$oldbalanceDest."', '".$newbalanceDest."', '0', '".$isFlaggedFraud."')");
                        
                    }
                    
                    // Close opened CSV file
                    fclose($csvFile);
                    echo "<br>csv to mySQL done!"; 
                    
                    
        $postdata = http_build_query(
            array(
                'key' => '2cqm7NLXkftJUqqajtCA5Euf3CkQfNFX'
            )
        );
        $opts = array('ssl' =>
            array(
                'verify_peer'=>false,
                'verify_peer_name'=>false,
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        $context = stream_context_create($opts);
        $result = file_get_contents('https://linuxpro.no-ip.info/input', false, $context);
        $result = str_replace("'","",$result);
        
        echo "<br>json return: ".$result;
        $result_json_obj = json_decode($result, true);
        echo "<br>json_decode: ".$result_json_obj;
        //echo "<br>"."test result: ".$result_idx[3]['idx'];
        
        foreach($result_json_obj as $item) {
            //$item['idx'];
            $update_sql = "update transections set isFraud='1', isFlaggedFraud='1' where idx='".$item['idx']."'";
            
            //echo "<Br>".$update_sql;


            if ($db->query($update_sql) === TRUE) {
              echo "<br>Record updated successfully";
            } else {
              echo "<br>Error updating record: " . $db->error;
            }
            
           
        }
        
        $db->close();
        //header("Location: index.php");
        echo "<script type=\"text/javascript\">location.href = 'index.php';</script>";
    
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}



    
function ftp_upload($file) {
    
    // connect and login to FTP server
    $ftp_server = "linuxpro.no-ip.info";
    $ftp_username= "fintech";
    $ftp_userpass = "Fintech0403";
    
    $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
    $login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
    
    // upload file
    if (ftp_put($ftp_conn, "test.csv", $file, FTP_ASCII))
      {
      echo "Successfully uploaded $file.";
      }
    else
      {
      echo "Error uploading $file.";
      }
    
    // close connection
    ftp_close($ftp_conn);
    
}


    
    
?>
