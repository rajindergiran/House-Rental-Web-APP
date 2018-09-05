<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['user']) ) {
		header("Location: index.php");
		exit;
	}
	// select loggedin users detail
	$res=mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
	$userRow=mysql_fetch_array($res);

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['userEmail']; ?></title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
<style type="text/css">
/* In a production setting, this should be in css file */
img.photo {
  width: 268px;
  height: 178px;
}

p.location {
  margin-top: 20px;
  color:  #A61D8D;
  text-transform: uppercase;
  font-size: 12px;
  font-weight: 600;
}

p.desc {
  margin-top: -10px;
  color: #484848;
  font-size: 16px;
  font-weight: 800;

}
p.price {
  margin-top: -5px;
  font-size: 14px;
  font-weight: 400;
}

p.star-ratings {
  color:  #A61D8D;
  font-size: 9px;
}
button.btn-rent {
  color: #008489;
  border-color: #008489;
}
</style>
</head>
<body>

	<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Project</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="">Home</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $userRow['userEmail']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav> 

	<div id="wrapper">

	<div class="container">
    
    	<div class="page-header">
    	<h3>Amazing Rentals in the City</h3>
    	</div>
        
        

          <?php 
    
            // get rental information from database
            $sql=mysql_query("SELECT * FROM rentals");

            // track number of rows
            $count = 0;    
            while ($row = mysql_fetch_array($sql, MYSQL_ASSOC))
            {

              if ($count == 0 || $count == 4) {
                // make new row
                echo '<div class="row">';
              }
              echo '<div class="col-lg-3">';
                echo '<img class="photo" src="assets/' . $row["image"] . '">';
                echo '<p class="location">';
                  echo $row["type"] . "-" .  $row["location"];
                echo '</p>';

                echo '<p class="desc">';
                  echo $row["description"];
                echo '</p>';
                echo '<p class="price">';
                  echo "$" . $row["price"] .  " CAD per night";
                echo '</p>';
                echo '<p class="star-ratings">';
                  // star rating
                  for ($x = 0; $x < $row["ratings"]; $x++) {
                    echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
                  } 
                echo '</p>';
                echo '<button class="btn btn-default btn-rent"> Rent </button>';
              echo '</div>';

              $count = $count + 1;

              if ($count == 4) {
                // make closing row
                echo "</div>";
              }

            }
          ?>
    </div>
    
    </div>
    
    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    
</body>
</html>
<?php ob_end_flush(); ?>