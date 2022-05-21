<!DOCTYPE html>
<?php 
include 'config.php';

// Check file upload
if(isset($_GET["new"])&&($_GET["new"]==1)) {
    
    $db->query("Delete from transections");
    
}



?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Expires" content="0">
        <title>COMP7300 Financial Technology - Group Project</title>
        <link rel="shortcut icon" href="images/fav_icon.png" type="image/x-icon">
        <!-- Bulma Version 0.9.0-->
        <link rel='stylesheet prefetch' href='https://unpkg.com/bulma@0.9.0/css/bulma.min.css'>
        <link rel="stylesheet" href="css/tabs.css">
        <link rel="stylesheet" href="DataTables/dataTables.css">
        <script src="https://kit.fontawesome.com/7dc3015a44.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="DataTables/dataTables.js"></script>
        <style>
            .red {
              background-color: red !important;
            }
            
            .tooltip {
              position: relative;
              display: inline-block;
              border-bottom: 1px dotted black;
            }
            
            .tooltip .tooltiptext {
              visibility: hidden;
              width: 180px;
              background-color: grey;
              color: #fff;
              text-align: center;
              border-radius: 6px;
              padding: 5px 0;
            
              /* Position the tooltip */
              position: absolute;
              z-index: 1;
            }
            
            .tooltip:hover .tooltiptext {
              visibility: visible;
            }
        </style>
        
    </head>
    <body>

        <section class="hero is-info">
            <div class="hero-body">
                <div class="container">
                    <h1 class="title">
                        AML - Detection of Fraudulent Transactions using Machine Learning
                    </h1>
                    <h2 class="subtitle">
                        COMP7300 Financial Technology - Group Project
                    </h2>
                </div>
            </div>
            <div class="tabs is-boxed is-centered main-menu" id="nav">
                <ul>
                    <li data-target="pane-1" id="1">
                        <a>
                            <span class="icon is-small"><i class="fab fa-empire"></i></span>
                            <span>About</span>
                        </a>
                    </li>
                    <li data-target="pane-2" id="2" class="is-active">
                        <a>
                            <span class="icon is-small"><i class="fab fa-superpowers"></i></span>
                            <span>Tool</span>
                        </a>
                    </li>
                    <li data-target="pane-3" id="3">
                        <a>
                            <span class="icon is-small"><i class="fa fa-film"></i></span>
                            <span>Video</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane" id="pane-1">
                    <div class="columns">
                        <div class="container">
                            <div class="columns">
                                        <div class="media-content">
                                            <div class="content">
                                                <p>
                                                    <strong>Overview</strong>
                                                    <br> Money laundering is the process of disguising crimes by redirecting those proceeds into goods and services so as to make the money looks legalized.  AML affects the economy and stability of a country and society.  If government cannot well control the AML activities, economic activities would be transferred to criminals.   Due to the large sums of money, money laundering are more conveniently conducted financially via bank transactions.  Under banking regulations, banks must hinder such illegal activities.  How to detect such illegal financial transactions impose great challenges to banks and financial institutions.  On the other hand, the costs in regulatory fines and damaged reputation for financial institutions are all too real.<br>
                                                    <br> This program aims to resort to use of machine learning algorithms and methods applied to detect suspicious transactions.  In particular, we resort to two methods of anti-money laundering typologies: SVC (Support Vector Classifier) and neural network.   The former method is a supervised learning method normally used for classification, regression and outliers detection.  It applies a linear kerner function to perform classification under large number of samples.  The latter method was inspired by the human brain, mimicking the way that biological neurons signals to one another. Outputs are clarified as 0 and 1 with 0 signifies non-fraud transaction and 1 being fraud transaction.   The results under the 2 methods are summarised, and compared. Finally, what techniques were lacking or under-addressed in the existing research has been elaborated with the purpose of pinpointing future research directions.
                                                </p>
                                            </div>
                                        </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="pane-3">
                    <div class="columns is-centered">
                        <div class="column is-three-quarters">
                            <div class="embed-container image">
                                <div class="content">
                                    <p>
                                        <strong>Machine Learning Based Fraud Detection in Banking</strong>
                                    </p>
                                </div>    
                                <iframe src="https://www.youtube.com/embed/sq5BYW4COwA" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen style="margin-top: 30px;">
                                    
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane is-active" id="pane-2">
                    <div class="content" style="margin-left: -40%;">
                        <h1>Suspicious Financial Transactions:</h1>
                        <form name="uploadFile" method="POST" action="upload.php" enctype="multipart/form-data">
                            <input type="hidden" name="fromSubmit" value="1">
                            Select a transection data file (< 20MB *.csv or *.txt) to upload:
                            <input id="fileToUpload" type="file" name="fileToUpload" />
                            <button id="upload" onClick="uploadFile.submit(); ">Submit</button>
                            <br>Download transection data sample:&nbsp;
                            <font color="blue"><a href="transection_data1.csv"><u>Data 1</u></a></font>&nbsp;
                            <font color="blue"><a href="transection_data2.csv"><u>Data 2</u></a></font>&nbsp;
                            <font color="blue"><a href="transection_data3.csv"><u>Data 3</u></a></font>&nbsp;
                        </form>
                        <br>
                          
                        <table id="userTable" class="display">
                            <thead>
                                <tr>
                                    <th>IDX</th>
                                    <th>
                                        <div class="tooltip">
                                        <span class="tooltiptext" style="margin-top: 20px; margin-left: 30px;">Maps a unit of time in the real world. In this case 1 step is 1 hour of time.</span>
                                        Step
                                        </div>
                                    </th>
                                    <th>
                                        <div class="tooltip">
                                        <span class="tooltiptext" style="margin-top: 20px; margin-left: 30px;">CASH-IN, CASH-OUT, DEBIT, PAYMENT and TRANSFER</span>
                                        Type</div>
                                    </th>
                                    <th>
                                        <div class="tooltip">
                                        <span class="tooltiptext" style="margin-top: 20px; margin-left: 30px;">amount of the transaction in local currency</span>
                                        Amount</div>
                                    </th>
                                    <th>
                                        <div class="tooltip">
                                        <span class="tooltiptext" style="margin-top: 20px; margin-left: 30px;">customer who started the transaction</span>
                                        nameOrig</div>
                                    </th>
                                    <th>
                                        <div class="tooltip">
                                        <span class="tooltiptext" style="margin-top: 20px; margin-left: 30px;">initial balance before the transaction</span>
                                        oldbalanceOrg</div>
                                    </th>
                                    <th>
                                        <div class="tooltip">
                                        <span class="tooltiptext" style="margin-top: 20px; margin-left: 30px;">customer's balance after the transaction.</span>
                                        newbalanceOrig</div>
                                    </th>
                                    <th>
                                        <div class="tooltip">
                                        <span class="tooltiptext" style="margin-top: 20px; margin-left: 30px;">recipient ID of the transaction.</span>
                                        nameDest</div>
                                    </th>
                                    <th>
                                        <div class="tooltip">
                                        <span class="tooltiptext" style="margin-top: 20px; margin-left: 30px;">initial recipient balance before the transaction.</span>
                                        oldbalanceDest</div>
                                    </th>
                                    <th>
                                        <div class="tooltip">
                                        <span class="tooltiptext" style="margin-top: 20px; margin-left: 30px;">recipient's balance after the transaction.</span>
                                        newbalanceDest</div>
                                    </th>
                                    <th>
                                        <div class="tooltip">
                                        <span class="tooltiptext" style="margin-top: 20px; margin-left: -10px;">identifies a fraudulent transaction (1) and non fraudulent (0)</span>
                                        isFlaggedFraud</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
<?php                               $sql = "select idx, step, type, amount, nameOrig, oldbalanceOrg, newbalanceOrig, nameDest, oldbalanceDest, newbalanceDest, isFraud, isFlaggedFraud from transections order by isFraud desc";
                                    $result = $db->query($sql);
                                    
                                    if ($result->num_rows > 0) {
                                      // output data of each row
                                      while($row = $result->fetch_assoc()) {
                                          
                                        $idx = $row["idx"];
                                        $step = $row["step"];
                                        $type = $row["type"];
                                        $amount = $row["amount"];
                                        $nameOrig = $row["nameOrig"];
                                        $oldbalanceOrg = $row["oldbalanceOrg"];
                                        $newbalanceOrig = $row["newbalanceOrig"];
                                        $nameDest = $row["nameDest"];
                                        $oldbalanceDest = $row["oldbalanceDest"];
                                        $newbalanceDest = $row["newbalanceDest"];
                                        $isFraud = $row["isFraud"];
                                        $isFlaggedFraud = $row["isFlaggedFraud"];
                                        
                                        if($isFraud) {
                                            
                                            $bgcolor = " bgcolor='red'";
                                        } else {
                                            $bgcolor = "";
                                            
                                        }
                                          
                                        echo 
                                            "<tr$bgcolor>" .
                                            "<td align='center'>" . $idx . "</td>" .
                                            "<td align='center'>" . $step . "</td>" .
                                            "<td align='center'>" . $type . "</td>" .
                                            "<td align='center'>" . $amount . "</td>" .
                                            "<td align='center'>" . $nameOrig . "</td>" .
                                            "<td align='center'>" . $oldbalanceOrg . "</td>" .
                                            "<td align='center'>" . $newbalanceOrig . "</td>" .
                                            "<td align='center'>" . $nameDest . "</td>" .
                                            "<td align='center'>" . $oldbalanceDest . "</td>" .
                                            "<td align='center'>" . $newbalanceDest . "</td>" .
                                            "<!-- <td align='center'>" . $isFraud . "</td> -->" .
                                            "<td align='center'>" . $isFlaggedFraud . "</td>" .
                                            "</tr>";
                                            
                                     
                                      }
                                    } else {
                                      echo "0 results";
                                    }


?>
                                
                            </tbody>
                        </table>
                    
                </div>
            </div>
        </div>
    </section>
    <script>
/* 
    
function readToTb() {    
    $(document).ready(function(){
        $.ajax({
            url: 'ajaxfile.php',
            type: 'get',
            dataType: 'JSON',
            success: function(response){
                var len = response.length;
                for(var i=0; i<len; i++){
                    
                    
                    var idx = response[i].idx;
                    var step = response[i].step;
                    var type = response[i].type;
                    var amount = response[i].amount;
                    var nameOrig = response[i].nameOrig;
                    var oldbalanceOrg = response[i].oldbalanceOrg;
                    var newbalanceOrig = response[i].newbalanceOrig;
                    var nameDest = response[i].nameDest;
                    var oldbalanceDest = response[i].oldbalanceDest;
                    var newbalanceDest = response[i].newbalanceDest;
                    var isFraud = response[i].isFraud;
                    var isFlaggedFraud = response[i].isFlaggedFraud;
                    

    
                    var tr_str = "<tr>" +
                        "<td align='center'>" + idx + "</td>" +
                        "<td align='center'>" + step + "</td>" +
                        "<td align='center'>" + type + "</td>" +
                        "<td align='center'>" + amount + "</td>" +
                        "<td align='center'>" + nameOrig + "</td>" +
                        "<td align='center'>" + oldbalanceOrg + "</td>" +
                        "<td align='center'>" + newbalanceOrig + "</td>" +
                        "<td align='center'>" + nameDest + "</td>" +
                        "<td align='center'>" + oldbalanceDest + "</td>" +
                        "<td align='center'>" + newbalanceDest + "</td>" +
                        "<td align='center'>" + isFraud + "</td>" +
                        "<td align='center'>" + isFlaggedFraud + "</td>" +
                        "</tr>";
    
                    $("#userTable tbody").append(tr_str);
                }
    
            }
        });
    });
}        
        
        $('#upload').on('click', function() {
            var file_data = $('#myfile').prop('files')[0];   
            var form_data = new FormData();                  
            form_data.append('file', file_data);
            alert(form_data);                             
            $.ajax({
                url: 'upload.php', // <-- point to server-side PHP script 
                dataType: 'text',  // <-- what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(php_script_response){
                    //readToTb();
                    alert(php_script_response); // <-- display response from the PHP script, if any
                }
             });
        });
        
        $('#process').on('click', function() {
             readToTb();
        });
*/        

$(document).ready( function () {

    $('#userTable').DataTable( {
        "order": [[ 10, "desc" ]],
        "pageLength": 50,
        "createdRow": function( row, data, dataIndex){
            if( data[10] == '1'){
                $(row).addClass('red');
            }
        }
    } );
} );
        
    </script>
    <script src="js/bulma.js"></script>
    <script src="js/tabs.js"></script>
</body>
</html>

<?php


?>

