<?php
Class MusicBank { 

	private $dbHost = 'localhost';
	private $dbUser = 'root';
	private $dbPword = '';
	private $dbName = 'musicbank'; 

	protected $conn; 

	private $searchType; 
	private $searchData; 

	function __construct($type,$data) { 
		
		$this->conn = new mysqli($this->dbHost, $this->dbUser, $this->dbPword, $this->dbName);
		if ($this->conn->connect_error) {
    		die("Connection failed: " . $this->conn->connect_error);
		}

		$this->searchType = trim(mysqli_real_escape_string($this->conn,$type));
		$this->searchData = trim(mysqli_real_escape_string($this->conn,$data)); 

	}

	function validate() { 
		$msg = ''; 

		if($this->searchType == '')
			$msg = "Please select Search Type.";
		elseif($this->searchData == '' || strlen($this->searchData) < 2)
			$msg = "Please type atleast 2 character in the search field.";

		return $msg; 
	}

	function search() { 
		$condition = ($this->searchType == 1) ? 'title' : 'singer'; 

		$sql = "SELECT title,singer FROM musics WHERE ".$cond." LIKE '%$this->searchData%' ";
		$result = $this->conn->query($sql); 

		if ($result->num_rows > 0) {
    		
    		while($row = $result->fetch_assoc()) {
        		$rows[] = $row; 
    		}

    		$return = json_encode($rows); 
		} 
		else {
    		$return = '0';
		}

		return $return;
	}
}


$music = new MusicBank(); 
$msg = $music->validate(); 

if($msg = '') { 
	$music->search(); 
}
else { 
	return $msg; 
}

?>