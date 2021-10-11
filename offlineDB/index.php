<?php
    $view_link = $_POST['link'];

    $subtittle = $_POST['subtittle'];
    $table_list = array(); 
    $table_list[0] = array("id", "timeline", "subtittle", "text");


    // 자막을 입력했을 때
    if(!empty($_POST["subtittle"])){
        $str_array=explode("\r\n", $subtittle);

        // 반복문으로 자막 추가
        $i=0; $id = 1;
        while($i<count($str_array)){
        $table_list[$id] = array($id++, $str_array[$i++],$str_array[$i++],"");
        }
    }
    if(!empty($_POST["file"])){ // 파일을 첨부했을 때
        $str_array=explode("\r\n", $_POST["file"]);
        $view_link=explode(",",$str_array[0])[4];
        // 반복문으로 자막 추가
        $i=1;
        while($i<count($str_array)){
            $arr = explode(",",$str_array[$i]);
            $table_list[$i] = array($i++, $arr[1], str_replace("\\n","\n",$arr[2]), str_replace("\\n","\n",$arr[3]));
        }
    }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Study with Youtube</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/view_style.css">
  </head>
  <body>
    <header>
        <h1>Study with Youtube</h1>
        <p><a href="help.php">도움말 보기</a><p>
    </header>
    <!--search-->
    <div id="content">
        <form name="searchfrm" action="index.php" method="post">
            <table>
                <tr>
                    <td>
                        <span>videoId:</span>
                        <input type="text" name="link" value="<?php echo $view_link?>">
                    </td>
                    <td>
                        <span>자막:</span>
                        <textarea name="subtittle"></textarea>
                    </td>
                    <td>
                        <input type="submit" name="submit"/>
                        <button onclick="location.href='index.php'">reset</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <section>
        <!--youtube-->
        <div id="player"></div>
        <!--table-->
        <form name="tablefrm" action="view_update.php" method="post">
            <div class="studydata" style="overflow:scroll;">
                <table id="table" width="100%" cellspacing="0" cellpadding="0">
                    <?php
                        foreach ($table_list as $td_list)
                        {
                            if($td_list[0]=="id") continue;
                    ?>
                    <tr id="<?php echo $td_list[0];?>">
                        <td class="timeline">
                            <button
                                type="button"
                                name="timeline_button"
                                onclick="setsec('<?php echo $view_link?>', <?php echo $td_list[0]?>);">timeline</button>
                            <textarea type="text" name="str_timeline[]" value="time<?php echo $td_list[0]?>"><?php echo $td_list[1];?></textarea>
                        </td>
                        <td class="subtittle">
                            <button
                                type="button"
                                name="subtittle_button"
                                value="<?php echo $td_list[0]?>"
                                onclick="copy_to_clipboard(<?php echo $td_list[0]?>, 'subtittle');" >subtittle</button>
                            <textarea name="subtittle[]" value="sub<?php echo $td_list[0]?>"><?php echo $td_list[2]?></textarea>
                        </td>
                        <td class="note">
                            <button
                                type="button"
                                name="note_button"
                                value="<?php echo $td_list[0]?>"
                                onclick="copy_to_clipboard(<?php echo $td_list[0]?>, 'note');">note</button>
                            <textarea name="note[]" value="note<?php echo $td_list[0]?>" styel="white-space:pre-line;"><?php echo $td_list[3] ?></textarea>
                        </td>
                        <input type="hidden" name="id[]" value=<?php echo $td_list[0]?>>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </form>
    </section>
    <div id="filebutton">
        <form name="filefrm" action="index.php" method="post">
            <button type="button" id="filesave">save</button>
            <button type="button" id="fileload" onclick="openCSVFile();">load</button>
        </form>
    </div>
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
        function setsec(view_link, id){
            player.loadVideoById(view_link, get_timeline(id));player.playVideo();
        }
    </script>

    <script>
        // 타임라인 얻기
        function get_timeline(vid) {
            var timeline = $("textarea[value='time" + vid + "']").val();
            var secArray = timeline.split(':');
            if (secArray.length == 2) {
                return 60 * parseInt(secArray[0]) + parseInt(secArray[1]);
            }
            if(secArray.length == 3) {
                return 60 * 60 * parseInt(secArray[0]) + 60 * parseInt(secArray[1]) + parseInt(secArray[2]);
            }
        }

        // 문자열 \n 변형
        function addslashes(string) {
            return string
                .replace(/\n/g, '\\n')
        }
        function removeslashes(string) {
            return string
                .replace(/\\n/g, '\n')
        }

        // 클립보드 복사
        function copy_to_clipboard(vid, type) {
            if(type=="subtittle"){
                var copyText = $("textarea[value='sub"+vid+"']");
            }
            if(type=="note"){
                var copyText = $("textarea[value='note"+vid+"']");
            }
            copyText.select();
            document.execCommand("Copy");
        }

        // 파일 저장, 불러오기
        $("#filesave").click(function () {
            let filename = "testFile.csv";
            getCSV(filename);
        });
        function getCSV(filename) {
            var csv = [];
            var row = [];

            //1열에는 컬럼명
            row.push("no", "timeline", "subtittle", "text", "<?php echo $view_link?>");

            csv.push(row.join(","));

            var id_list = document.getElementsByName("id[]");
            var timeline_list = document.getElementsByName("str_timeline[]");
            var subtittle_list = document.getElementsByName("subtittle[]");
            var note_list = document.getElementsByName("note[]");

            for(var i=0; i<id_list.length; i++){
                if(!timeline_list[i].value && !subtittle_list[i].value && !note_list[i].value) continue;
                else{
                    row = [id_list[i].value, timeline_list[i].value, addslashes(subtittle_list[i].value),addslashes(note_list[i].value)];
                    csv.push(row.join(","));
                }
            }
            downloadCSV(csv.join("\n"), filename);
        }
        function downloadCSV(csv, filename) {
            var csvFile;
            var downloadLink;

            //한글 처리를 해주기 위해 BOM 추가하기
            const BOM = "\uFEFF";
            csv = BOM + csv;

            csvFile = new Blob([csv], {type: "text/csv"});
            downloadLink = document.createElement("a");
            downloadLink.download = filename;
            downloadLink.href = window
                .URL
                .createObjectURL(csvFile);
            downloadLink.style.display = "none";
            document
                .body
                .appendChild(downloadLink);
            downloadLink.click();
        }
        function openCSVFile() {
            var input = document.createElement("input");
            input.type = "file";
            input.accept = "text/csv"; // 확장자가 xxx, yyy 일때, ".xxx, .yyy"
            input.onchange = function (event) {
                processFile(event.target.files[0]);
            };
            input.click();
        }

        function processFile(file) {
            var reader = new FileReader();
            reader.onload = function () {
                var form = document.createElement('form');
                form.setAttribute('method', 'post');
                form.setAttribute('action', 'index.php');
                document.charset='utf-8';
                
                var hiddenField = document.createElement('input');
                hiddenField.setAttribute('type', 'hidden');
                hiddenField.setAttribute('name', 'file');
                hiddenField.setAttribute('value', reader.result);
                form.appendChild(hiddenField);

                document.body.appendChild(form);
                form.submit();
            };
            reader.readAsText(file,"euc-kr");
        }
    </script>
  </body>
</html>

