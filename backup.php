<?php
  $host="localhost";
  $uname="root";
  $pass="";
  $database = "phattrienngonngu_com_website"; 
$connection=mysql_connect($host,$uname,$pass) or die("Database Connection Failed");
$selectdb=mysql_select_db($database) or die("Database could not be selected"); 
$result=mysql_select_db($database)
or die("database cannot be selected <br>");
mysql_set_charset('utf8', $connection);

function backup_db(){
/* Store All Table name in an Array */
$allTables = array();
$result = mysql_query('SHOW TABLES');
while($row = mysql_fetch_row($result)){
     $allTables[] = $row[0];
}
$return = '';
foreach($allTables as $table){
$result = mysql_query('SELECT * FROM '.$table);
$num_fields = mysql_num_fields($result);

$return.= 'DROP TABLE IF EXISTS '.$table.';';
$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
$return.= "\n\n".$row2[1].";\n\n";

for ($i = 0; $i < $num_fields; $i++) {
while($row = mysql_fetch_row($result)){
   $return.= 'INSERT INTO '.$table.' VALUES(';
     for($j=0; $j<$num_fields; $j++){
       $row[$j] = addslashes($row[$j]);
       $row[$j] = str_replace("\n","\\n",$row[$j]);
       if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } 
       else { $return.= '""'; }
       if ($j<($num_fields-1)) { $return.= ','; }
     }
   $return.= ");\n";
}
}
$return.="\n\n";
}

// Create Backup Folder
$folder = 'backup/';
if (!is_dir($folder))
mkdir($folder, 0777, true);
chmod($folder, 0777);

$date = date('m-d-Y-H-i-s', $_SERVER['REQUEST_TIME']); 
$filename = $folder."db-backup-".$date; 

$handle = fopen($filename.'.sql','w+');
fwrite($handle,$return);
fclose($handle);
$z = new ZipArchive(); 
    $z->open($filename . '.zip', ZIPARCHIVE::CREATE); 
    $z->addFile($filename . '.sql');
    $z->close(); 
	unlink($filename . '.sql');
}

// Call the function
backup_db();
