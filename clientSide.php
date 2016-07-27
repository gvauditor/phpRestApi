<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <style>
  		#wrapper { width:50%; margin-top:50px; margin-left: auto; margin-right: auto;}
  		.selection { text-align: center; margin-top: 20px; }
  		#result_holder { width: 100%; margin-top:15px; margin-left: auto; margin-right: auto;}
  		.divresult { height:400px; border: 1px solid #4477AA; overflow-y: 400px; }
  </style>

  <script>
  	$(document).ready(function(){
  		$("#search").click(function(){
        	var searchtext = $("#searchdata").val();
        	searchtext = $.trim(searchtext);
        	
        	if(searchtext.length < 2) { 
        		$("#result_holder").html('<strong>Error!</strong> Enter atleast 2 character to search.')
        						   .addClass('alert alert-danger');

        		return false;
        	} 
        	else if($('input[name="searchtype"]:checked').val() == undefined) { 
        		$("#result_holder").html('<strong>Error!</strong>Select title or singer.');

        		return false;
        	}
        	else { 
        		return true; 
        	}
    	});
	});
  </script>
<title>Simple API Client | Music Search</title>
</head>

<body>
	<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Music Search</a>
    </div>
  </div>
</nav>
  
<div class="container">
	
	<div id="wrapper">
  	<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
  	<div class="input-group">
        <input type="text" class="form-control" placeholder="Search song Title or Singer..." name="searchdata" id="searchdata" value="<?php if(isset($_POST['searchdata'])) echo $_POST['searchdata']; ?>">
        	<div class="input-group-btn">
                <button class="btn btn-default" type="submit" id="search" name="search"><i class="glyphicon glyphicon-search"></i></button>
            </div>
    </div>
    	<div class="selection">
    	<label class="radio-inline">
      		<?php
				$chk = (!isset($_POST['searchtype']) || (isset($_POST['searchtype']) && $_POST['searchtype']) == 1) ? "checked='checked'" : ""; 
				$chk2 = (isset($_POST['searchtype']) && $_POST['searchtype'] == 2) ? "checked='checked'" : "";
			?>
			<input type="radio" name="searchtype" value="1" <?php echo $chk; ?>>Song Title
    	</label>
    	<label class="radio-inline">
      		<input type="radio" name="searchtype" value="2" <?php echo $chk2; ?>>Singer
    	</label>
    	</div>
      </form>
    	<div id="result_holder"></div>

      <?php 
          if(isset($_POST['search'])) { 
              $type = $_POST['searchtype'];
              $data = $_POST['searchdata']; 
				
              $api_data = file_get_contents("http://localhost/phpRestApi/myMusicApi.php?type=$type&data=$data");
              $data = json_decode($api_data, true);
			  
			  //echo var_dump($api_data);
      ?>
    	<div class="table-responsive divresult">
  			<table class="table">
    			<thead>
      			<tr>
        			<th>#</th>
        			<th>Song Title</th>
        			<th>Singer</th>
      			</tr>
   				</thead>
    			<tbody>
      			<?php 
            if($data == NULL) { 
              echo "<tr><td colspan='3'><div class='alert alert-info'><strong>Search result!</strong> No data found!</div></td></tr>"; 
            }
            else { 
            foreach ($data AS $row) { ?>
            <tr>
        			<td><?php echo $row['id']; ?></td>
        			<td><?php echo $row['title']; ?></td>
        			<td><?php echo $row['singer']; ?></td>
      			</tr>
            <?php } } ?>
    			</tbody>
  			</table>
  		</div>
	</div>
	<?php } ?>

</div>
</body>

</html>