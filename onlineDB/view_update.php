<?php
    //dababase 연결확인
	require_once("dbconfig.php");

  $timeArray = $_POST['str_timeline'];
  $subArray = $_POST['subtittle'];
  $textArray = $_POST['text'];
  $idArray = $_POST['id'];
  $videoID = $_POST['videoID'];

  for($i=0; $i<count($timeArray); $i++){
    if(empty(addslashes($timeArray[$i])) && empty(addslashes($subArray[$i])) && empty(addslashes($textArray[$i]))){
      $update_sql = "DELETE FROM studydata WHERE id=".$idArray[$i];  
    }
    else{
      $update_sql = "UPDATE studydata SET str_timeline='".addslashes($timeArray[$i]).
      "',"."subtittle='".addslashes($subArray[$i]).
      "',"."text='".addslashes($textArray[$i]).
      "' WHERE id=".$idArray[$i].";";
    }
    $db -> query($update_sql);
  }

  header('Location: view.php?videoID='.$videoID[0]);
?>
