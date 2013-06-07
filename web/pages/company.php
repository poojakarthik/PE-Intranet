<?php
include("../auth/restrict_inner.php");
?>
<script>
function Display(page)
{
	window.location = "/main/company.php?page=" + page;
}
</script>
<!-- Main -->
<div id="main">
    <div style="width:98%; margin-left:auto; margin-right:auto; text-align:left;">
    <?php
    $check = $mysqli->query("SELECT * FROM `pen`.`news` WHERE `broadcast` = 'Y'") or die($mysqli->error);
    $rows = $check->num_rows;
    $check->free();
    
    if ($rows == 0)
    {
        echo '<h3>No News <span style="font-family: Wingdings">&#9785</span></h3>';
    }
    else
    {
        $st = $_GET["page"]*4;
        $q = $mysqli->query("SELECT * FROM `pen`.`news` WHERE `broadcast` = 'Y' ORDER BY `timestamp` DESC LIMIT $st , 4") or die($mysqli->error);
        
        while($r = $q->fetch_assoc())
        {
            echo "<h3>" . $r["subject"] . "</h3>";
            echo "<p>" . nl2br($r["post"]) . "</p>";
            echo "<hr style='width:200px; height:1px; margin:0;'>";
            echo "<p style='font-size:9px;'>Posted by " . $r["poster"] . " | " . date("d/m/Y H:i:s", strtotime($r["timestamp"])) . "</p><br>";
        }
        
        $q->free();
    }
    
    $mysqli->close();
    ?>
    
    <table width="100%">
    <tr>
    <td align="left" width="50%">
    <?php
    if (($st - 4) < $rows && $_GET["page"] > 0)
    {
        $page = $_GET["page"]-1;
        echo "<input type='button' onClick='Display(\"$page\")' class='newer'>";
    }
    ?>
    </td>
    <td align="right" width="50%">
    <?php
    if (($st + 4) < $rows)
    {
        $page = $_GET["page"]+1;
        echo "<input type='button' onClick='Display(\"$page\")' class='older'>";
    }
    ?>
    </td>
    </tr>
    </table>
    </div>
</div>
<!-- END Main -->