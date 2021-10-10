<style>
    div {
        padding : 50px 50px;
        border : 1px solid black;
    }
</style>

<!DOCTYPE html>
<html>
  <head>
    <title>How to use</title>
    <meta charset="utf-8">
  </head>
  <body>
    <header>
        <h1>How to use</h1>
        <p><a href="index.php">도움말 그만보기</a><p>
    </header>
    <nav>
        <ol>
            <li><a href="help.php?tip=1">시작</a></li>
            <li><a href="help.php?tip=2">테이블</a></li>
            <li><a href="help.php?tip=3">저장/불러오기</a></li>
        </ol>
    </nav>
    <section>
        <?php
            if($_GET["tip"]==1)include("tip1.php");
            elseif($_GET["tip"]==2)include("tip2.php");
            elseif($_GET["tip"]==3)include("tip3.php");
            else include_once("tip1.php");
        ?>
    </section>
  </body>
</html>