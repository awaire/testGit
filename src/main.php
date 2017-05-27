<?php
//  include "common.php";
	$bucket_name = "heartsound";
	//$db_server = 'localhost:8889';
	//$db_user = "root";
	//$db_pass = "";
	//$hostname = null;
	$db_name = "hsd";
	$port = null;	// defaults to mysqli.defaultport
	$socket = 'mysql:unix_socket=/cloudsql/lyfe-player:us-central1;dbname=hsd';
		
    use google\appengine\api\cloud_storage\CloudStorageTools;

    $options = ['gs_bucket_name' => $bucket_name];
    $upload_url = CloudStorageTools::createUploadUrl('/process.php', $options);     
	$file_name = "gs://".$bucket_name."/".$_FILES['upload']['name'];
	$file_only = $_FILES['upload']['name'];
	$temp_name = $_FILES['upload']['tmp_name'];
	move_uploaded_file($temp_name, $file_name);	
	$soundurl = CloudStorageTools::getPublicUrl($file_name, true);
    
	// Localdb -- $conn =  new mysqli($db_server, $db_user, $db_pass, $db_name);	
	$conn = new mysqli(
		null, 	// hostname
		"root", // login
		'', 	// password
		"hsd", 	// database
		null, 	// port
		"/cloudsql/lyfe-player:us-central1:hsd"	//socket
		);
			
	// Check connetion now
    if ($conn->connect_error) {
        trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
    }	    
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Awaire Inc.</title>
<link href="/styles/main.css" rel="stylesheet" type="text/css">

<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    text-align: left;
 	background-color: #f1f1c1;
}
</style>

</head>

<body>
<div id="outerWrapper">
  <header>
  <img src="/images/imageedit_16_8935310628.gif" width="144" height="63" alt="Awaire Inc">
    <p id="raTitle">AWAIRE INC.<br>
      Heart &bull; Sound &bull; Classification</p>
  </header>
  
  <article id="main">
    <?php echo "<h1>Web App</h1>"; ?>
    
    <hr>
    <form action="<?php echo $upload_url; ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="upload"><br />
        <input type="submit" value="Upload" />
        <?php echo "Moved $file_only to bucket gs://$bucket_name"; ?>
    </form>
    <hr>    			
    <caption> <center> Heart Sound in database </center> </caption>
    <?php $sql='SELECT * FROM sf';
		  $rs=$conn->query($sql);
	
		if($rs === false) {
      		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
    		} else {
      			$rows_returned = $rs->num_rows;
    			}
    
    	$rs->data_seek(0);
      		echo '<table>';
      		echo '<tr>';
      		echo '<th>File Name</th><th>State</th><th>URL (Link to File)</th><th> Notes </th><th> Age Group </th><th> Gender </th><th> Geographical Region </th>';
      		echo '</tr>';
    	while($row = $rs->fetch_assoc()){
      		echo '<tr>';
      		echo '<td>'.$row['title'] .'</td><td>'. $row['state'].'</td> <td>' .$row['url'] .'</td><td>' .$row['notes'] .'</td><td>' .$row['age'] .'</td><td>' .$row['sex'] .'</td><td>' .$row['region'] .'</td>' ;
      		echo '</tr>';
    	}
      		echo '</table>';      		
     ?>
              
  </article>
</div>
</body>
</html>
