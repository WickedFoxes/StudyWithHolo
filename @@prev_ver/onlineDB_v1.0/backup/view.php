<?php
    //dababase 연결확인
	require_once("dbconfig.php");

  $sql = 'select * from studylist where videoID='.$_GET['videoID'];
  $result = $db->query($sql);
  $row = $result->fetch_assoc();
  $view_memid=$row['memid'];
  $view_videoID=$row['videoID'];
  $view_tittle=$row['tittle'];
  $view_link=$row['link'];
  $view_date=$row['date'];

  $str_T=NULL;
  if(!empty($_GET['str_T']))$str_T = getSeconds($_GET['str_T']);
?>

<?php
  // 'HH:mm:ss' 형태의 시간을 초로 환산
  function getSeconds($HMS) {
      $tmp = explode(':', $HMS);
      $min = intval($tmp[0])*60;
      $sec = intval($tmp[1]);
      return $sec + $min;
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $view_tittle ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="ccs/style.css">
  </head>
  <body>
    <h1><?php echo $view_tittle ?></h1>
    <!--youtube-->
    <iframe width="900" height="600" src="https://www.youtube.com/embed/<?php echo $view_link?>?autoplay=1&start=<?php echo $str_T?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    <!--table-->
    <div class="studydata" style="overflow:scroll; width:894px; height:250px;">
        <table width="100%" cellspacing="0" cellpadding="0">
        <?php
          $sql = 'select * from studydata where videoID='.$view_videoID.' order by str_timeline;';
          $result = $db->query($sql);
          while($row = $result->fetch_assoc())
          {
            $id=$row['id'];
            $str_timeline=$row['str_timeline'];
            $subtittle=$row['subtittle'];
            $text=$row['text'];
        ?>
          <tr>
              <td>
                  <form action="view_delete.php" method="post">
                      <input type="hidden" name="videoID" value=<?php echo $view_videoID?>>
                      <input type="hidden" name="id" value=<?php echo $id?>>
                      <input type="submit" name="delete">
                  </form>
              </td>
              <td>
                  <form action="view_update.php" method="post">
                      <input type="submit" name="edit">
                      <button
                          type="button"
                          name="timeline_button"
                          onclick="location.href='view.php?videoID=<?php echo $view_videoID?>&str_T=<?php echo $str_timeline?>';">timeline</button>
                      <input type="text" name="str_timeline" value="<?php echo $str_timeline;?>">
                      <button type="button" name="subtittle_button">subtittle</button>
                      <textarea name="subtittle"><?php echo $subtittle?></textarea>
                      문장
                      <textarea name="text" styel="white-space:pre-line;"><?php echo $text ?></textarea>
                      <input type="hidden" name="videoID" value=<?php echo $view_videoID?>>
                      <input type="hidden" name="id" value=<?php echo $id?>>
                  </form>
              </td>
          </tr>
        <?php } ?>
      </table>
    </div>

    <script>
        function fnMove(val_time) {
            var target = $('text[value="val_time"]').offset().top;
            alert($('text[value="val_time"]').val());
            $('div').animate({
                scrollTop: target
            }, 400);
        }
        alert("1");
        fnMove("<?php echo $_GET["str_T"] ?>");
    </script>

    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
  </body>
</html>

