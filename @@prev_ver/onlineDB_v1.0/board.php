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
    <title>Study with<?php echo ' '.$name?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/board_style.css">
  </head>
  <body>
    <header>
        <h1>Study with HoloLive</h1>
        <nav class="navBox">
            <a href="index.php?lang=0">JP</a>
            <a href="index.php?lang=1">EN</a>
        </nav>
    </header>
    <section>
        <h2>Study with<?php echo ' '.$name?></h2>
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
        <article>
            <a href="<?php echo "view.php?videoID=", $view_videoID;?>">
                <img
                    src="https://img.youtube.com/vi/<?php echo $view_link?>/0.jpg"
                    alt="Thumbnail">
                <h3><?php echo $view_tittle;?></h3>
            </a>
            <h3><?php echo $view_date;?></h3>
        </article>
        <?php } ?>
    </section>
  </body>
</html>