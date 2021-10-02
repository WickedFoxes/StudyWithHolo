<?php
	require_once("dbconfig.php");
  
  $name = NULL;
  $videoID = NULL;
  $tittle = NULL;
  $link = NULL;
  $date = NULL;

  $sql = 'select * from member where memid='.$_GET['memid'];
  $result = $db->query($sql);
  $row = $result->fetch_assoc();
  $name=$row['name'];

  $memid = $_GET['memid'];
  if(isset($_GET['videoID'])){
    $videoID = $_GET['videoID'];

    $sql = "select * from studylist where videoID='".$videoID."'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
  
    $tittle = $row['tittle'];
    $link = $row['link'];
    $date = $row['date'];
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $name." "?>게시글 작성</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="ccs/style.css">
  </head>
  <body>
    <h1><?php echo $name." "?>게시글 작성</h1>
    <div id="content">
      <form name="frm" action="view_write.php" method="post">
          videoID:</br>
          <input type="text" name="videoID" value="<?php echo $videoID?>"></br>    
          제목:</br>
          <input type="text" name="tittle" value="<?php echo $tittle?>"></br>
          유튜브 URL:</br>
          <input type="text" name="link" value="<?php echo $link?>"></br>
          등록일:</br>
          <input type="text" name="date" value="<?php echo $date?>"></br>
          자막:</br>
          <textarea name="subtittle"></textarea></br>
          <input type="hidden" name="memid" value="<?php echo $memid?>">
          <input type="submit" name="submit"/>
      </form>
      <button onclick="location.href='board_write.php?memid=<?php echo $memid ?>'">reset</button>
    </div>
    <div id="list">
    <?php
      $sql = 'select * from studylist where memid='.$memid.' order by date DESC;';
      $result = $db->query($sql);
      while($row = $result->fetch_assoc())
      {
        $view_memid=$row['memid'];
        $view_videoID=$row['videoID'];
        $view_tittle=$row['tittle'];
        $view_link=$row['link'];
        $view_date=$row['date'];
    ?>
    <div class="list">
    <a href="<?php echo "board_write.php?memid=", $view_memid,
    "&videoID=", $view_videoID;?>">
    <img src="https://img.youtube.com/vi/<?php echo $view_link?>/0.jpg" alt="Thumbnail">
    <?php echo $view_tittle;?>  
  </a>
    <p><?php echo $view_date;?></p>
    </div>
    <?php } ?>
    </div>
  </body>
</html>