<?php
# ------------------------------------------------------------------------------------------------ #
# program: read.php
# author:  Robert Orosz
# course:  cis355 Winter 2015
# purpose: 
# ------------------------------------------------------------------------------------------------ #
# input:   $_POST, or nothing
#
#				  displayHTMLHead
#               
#
# output:  HTML, CSS, JavaScript code 
# --------------------------------------------------------------------------- #
session_start();

	 if (!$_SESSION['id'] == 1){
	 header("Location: ./login.php"); 
	 }
	
    require 'database.php';
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: login.php");
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT vehicles.`id`,`year`,`make`,`model`,locations.city, dealerships.dealership FROM vehicles LEFT JOIN dealerships ON vehicles.dealership_id=dealerships.id LEFT JOIN locations ON vehicles.location_id=locations.id WHERE vehicles.`id`= " . $id;
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
	
        Database::disconnect();
    }
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Read Vehicle Information</h3>
                    </div>
                     
                    <div class="form-horizontal" >
                      <div class="control-group">
                        <label class="control-label">Year</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['year'];?>
                            </label>
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">Make</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['make'];?>
                            </label>
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">Model</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['model'];?>
                            </label>
                        </div>
                      </div>
					  <div class="control-group">
                        <label class="control-label">dealership</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['dealership'];?>
                            </label>
                        </div>
                      </div>
					  <div class="control-group">
                        <label class="control-label">Location</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['city'];?>
                            </label>
                        </div>
                      </div>
					 
                        <div class="form-actions">
                          <a class="btn" href="outdex.php">Back</a>
                       </div>
                     
                      
                    </div>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>