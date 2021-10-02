<?php
    //dababase 연결확인
	require_once("dbconfig.php");
  
  $videoID=$_POST["videoID"];
  $id=$_POST["id"];

  $del_sql = 'delete from studydata where id='.$id;
  $result = $db->query($del_sql);

  header('Location: view.php?videoID='.$videoID);
?>