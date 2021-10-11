<?php
    require_once("dbconfig.php");
    function get_memberName($memid)
    {
        $sql = "select * from member where memid=".$memid;
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        return $row['name'];
    }
?>