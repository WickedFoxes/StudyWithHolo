<?php
	require_once("dbconfig.php");
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Study with HoloLive</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/index_style.css">
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
    <?php
              //lang 기본값 1 (en)
              if(empty($_GET['lang'])){
                $view_lang=0;
                echo "<h2>JP</h2>";
              }
              else {
                $view_lang=$_GET['lang'];
                if($view_lang==0)echo "<h2>JP</h2>";
                if($view_lang==1)echo "<h2>EN</h2>";
              }

              //sql 불러오기
              $sql = "select * from member where lang=".$view_lang." order by name";
              $result = $db->query($sql);
              while($row = $result->fetch_assoc())
              {
                $view_memid=$row['memid'];
                $view_name=$row['name'];
            ?>
        <article>
            <a href="<?php echo "board.php?memid=", $view_memid;?>">
                <img
                    src="images/<?php echo $view_memid;?>.png"
                    alt="<?php echo $view_name;?> img">
                <h3><?php echo $view_name;?></h3>
            </a>
        </article>
        <?php } ?>
    </section>
  </body>
</html>