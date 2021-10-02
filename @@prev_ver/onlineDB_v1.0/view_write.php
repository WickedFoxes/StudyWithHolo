<?php
    //dababase 연결확인
	require_once("dbconfig.php");

	$tittle=addslashes($_POST["tittle"]);
  $link=addslashes($_POST["link"]);
  $date=$_POST["date"];
  $memid=$_POST["memid"];
  $videoID=$_POST["videoID"];

  //업데이트 or 추가
  if(!empty($videoID)){
      $sql = "UPDATE studylist SET tittle='".$tittle.
      "',"."memid='".$memid.
      "',"."date='".$date.
      "',"."link='".$link.
      "' WHERE videoID=".$videoID;
    }
    else{
      $sql = "INSERT INTO studylist (tittle,memid,date,link) ".
      "VALUES ('".$tittle."',".$memid.","."'".$date."',"."'".$link."')";
    }

    if ($db->query($sql) === TRUE){
      //자막을 추가할 때
      if(!empty($_POST["subtittle"])){
        $subtittle=addslashes($_POST["subtittle"]);
        $str_array=explode("\r\n", $subtittle);

        // 반복문으로 자막 추가
        $i=0;
        while($i<count($str_array)){
          $upload = "INSERT INTO studydata (videoID,str_timeline,subtittle) "."VALUES (".$videoID.",'".$str_array[$i++]."',"."'".$str_array[$i++]."')";
          $db -> query($upload);;
        }
      }
      
      header('Location: board_write.php?memid='.$memid);
    }
    else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }
?>