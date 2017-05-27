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
      		ech	
     ?>
              
  </article>
</div>
</body>
</html>
