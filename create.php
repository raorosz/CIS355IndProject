<?php
# ------------------------------------------------------------------------------------------------ #
# program: create.php
# author:  Robert Orosz
# course:  cis355 Winter 2015
# purpose:  this file updates the tables  from the user 
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

 
    if ( !empty($_POST)) {
	
        // keep track validation errors
        $yearError = null;
        $makeError = null;
        $modelError = null;
		$locationError = null;
		$dealershipError = null;
         
        // keep track post values
        $year = $_POST['year'];
        $make = $_POST['make'];
        $model = $_POST['model'];
		$location = $_POST['location'];
		$dealership = $_POST['dealership'];
		$userlocation = $_SESSION['Loggedin'];
         
        // validate input
        $valid = true;
        if (empty($year)) {
            $yearError = 'Please enter year';
            $valid = false;
        }
         
        if (empty($make)) {
            $makeError = 'Please enter make';
            $valid = false;
         }
         
        if (empty($model)) {
            $modelError = 'Please enter a model';
            $valid = false;
		}	
			
			if (empty($location)) {
            $locationError = 'Please enter a location';
            $valid = false;
        }
         
		 if (empty($dealership)) {
            $locationError = 'Please enter a dealership';
            $valid = false;
        }
		
		
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO vehicles (year,make,model, dealership_id, location_id) values(?, ?, ?,?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($year,$make,$model,$dealership, $location));
            Database::disconnect();
            header("Location: outdex.php");
        }
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
                        <h3>Enter a Vehicle</h3>
                    </div>
                    <form class="form-horizontal" action="create.php" method="post">
                      <div class="control-group <?php echo !empty($yearError)?'error':'';?>">
                        <label class="control-label">Year</label>
                        <div class="controls">
                            <input name="year" type="text"  placeholder="Year" value="<?php echo !empty($year)?$year:'';?>">
                            <?php if (!empty($yearError)): ?>
                                <span class="help-inline"><?php echo $yearError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($makeError)?'error':'';?>">
                        <label class="control-label">Make</label>
                        <div class="controls">
                            <input name="make" type="text" placeholder="Make" value="<?php echo !empty($make)?$make:'';?>">
                            <?php if (!empty($makeError)): ?>
                                <span class="help-inline"><?php echo $makeError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                     <div class="control-group <?php echo !empty($modelError)?'error':'';?>">
                        <label class="control-label">Model</label>
                        <div class="controls">
                            <input name="model" type="text"  placeholder="Model" value="<?php echo !empty($model)?$model:'';?>">
                            <?php if (!empty($modelError)): ?>
                                <span class="help-inline"><?php echo $modelError;?></span>
                            <?php endif;?>
                        </div>	
                      </div>
					   <div class="control-group <?php echo !empty($dealershipError)?'error':'';?>">
                        <label class="control-label">Dealership</label>
                        <div class="controls">
						<select name=dealership>
						<?php
						$pdo = Database::connect ();
						$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$sql = "SELECT * FROM dealerships";
						foreach($pdo->query($sql) as $row)
						{
							echo "<option value='$row[0]'>$row[1]</option>";
						}
						?>
						</select>
                            <?php if (!empty($dealershipError)): ?>
                                <span class="help-inline"><?php echo $dealershipError;?></span>
                            <?php endif;?>
		
					     </div>	
                      </div>  
					   <div class="control-group <?php echo !empty($LocationError)?'error':'';?>">
                        <label class="control-label">Location</label>
                        <div class="controls">
						
						<select name=location>
						<?php
						$pdo = Database::connect ();
						$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$sql = "SELECT * FROM locations";
						foreach($pdo->query($sql) as $row)
						{
							echo "<option value='$row[0]'>$row[1]</option>";
						}
						?>
						</select>
                            <?php if (!empty($locationError)): ?>
                                <span class="help-inline"><?php echo $locationError;?></span>
                            <?php endif;?>
					     </div>	
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="outdex.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>