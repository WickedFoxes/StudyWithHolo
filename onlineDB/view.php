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
    <link rel="stylesheet" type="text/css" href="css/view_style.css">
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
        <!--tittle-->
        <h2><?php echo $view_tittle ?></h2>
        <!--youtube-->
        <div id="player"></div>
        <!--table-->
        <form action="view_update.php" method="post">
            <div class="studydata" style="overflow:scroll;">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <?php
                        $tb_sql = 'select * from studydata where videoID='.$view_videoID.' order by str_timeline;';
                        $tb_result = $db->query($tb_sql);
                        while($row = $tb_result->fetch_assoc())
                        {
                            $id=$row['id'];
                            $str_timeline=$row['str_timeline'];
                            $subtittle=$row['subtittle'];
                            $text=$row['text'];
                        ?>
                    <tr>
                        <td class="timeline">
                            <button
                                type="button"
                                name="timeline_button"
                                onclick="player.loadVideoById('<?php echo $view_link?>', <?php echo getSeconds($str_timeline)?>);player.playVideo();">timeline</button>
                            <input type="text" name="str_timeline[]" value="<?php echo $str_timeline;?>">
                        </td>
                        <td class="subtittle">
                            <button
                                type="button"
                                name="subtittle_button"
                                value="<?php echo $id?>"
                                onclick="copy_to_clipboard(<?php echo $id?>);" >subtittle</button>
                            <textarea name="subtittle[]" value="<?php echo $id?>"><?php echo $subtittle?></textarea>
                        </td>
                        <td class="text">
                            문장
                            <textarea name="text[]" styel="white-space:pre-line;"><?php echo $text ?></textarea>
                        </td>
                        <input type="hidden" name="videoID" value=<?php echo $view_videoID?>>
                        <input type="hidden" name="id[]" value=<?php echo $id?>>
                    </tr>
                    <?php } ?>
                </table>
            </div>
            <input type="submit" name="submit">
        </form>
    </section>

    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
    <script>
        // 2. This code loads the IFrame Player API code asynchronously.
        var tag = document.createElement('script');

        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag
            .parentNode
            .insertBefore(tag, firstScriptTag);

        // 3. This function creates an <iframe> (and YouTube player)    after the API
        // code downloads.
        var player;
        function onYouTubeIframeAPIReady() {
            player = new YT.Player('player', {
                videoId: '<?php echo $view_link?>',
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });
        }

        // 4. The API will call this function when the video player is ready.
        function onPlayerReady(event) {
            event
                .target
                .playVideo();
        }

        // 5. The API calls this function when the player's state changes.    The
        // function indicates that when playing a video (state=1),    the player should
        // play for six seconds and then stop.
        var done = false;
        function onPlayerStateChange(event) {
            if (event.data == YT.PlayerState.PLAYING && !done) {
                setTimeout(0, 0);
                done = true;
            }
        }
        function stopVideo() {
            player.stopVideo();
        }
    </script>
    <script>
        function copy_to_clipboard(vid) {
            var copyText = $("textarea[value="+vid+"]");
            copyText.select();
            document.execCommand("Copy");
        }
    </script>
  </body>
</html>

