<?php
	require_once("dbconfig.php");
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Study with HoloLive - WRITE</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="ccs/style.css">
  </head>
  <body>
    <h1>Study with HoloLive - WRITE</h1>

    <h2>EN</h2>
    <?php
      $sql = 'select * from member where lang=1 order by name';
      $result = $db->query($sql);
      while($row = $result->fetch_assoc())
      {
        $view_memid=$row['memid'];
        $view_lang=$row['lang'];
        $view_name=$row['name'];
    ?>
    <div class="member">
    <a href="<?php echo "board_write.php?memid=", $view_memid;?>">
    <img src="images/<?php echo $view_memid;?>.png">
    <?php echo $view_name;?>
    </a>
    </div>
    <?php } ?>
    
  </body>
</html>