<?php
require_once 'header.php';
require_once 'connection.php'; 
 
$link = new mysqli($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
 
$nowid = $_GET['comid'];

$query = "
select 
	company.id, 
	company.name, 
	company.description, 
	company.site 
from 
	company
where
	company.id = $nowid
";

$query1 = "
select 
    vacancy.id, 
    vacancy.header, 
    vacancy.description, 
    vacancy.date_of_publication, 
    vacancy.salary, 
    address.city, 
    vacancy.currency
from 
    vacancy 
    join address on vacancy.address = address.id 
where
	vacancy.employer = $nowid
";

if($result = $link->query($query))
{
    echo "<body class = 'showback'>";
        echo "<div class = 'showpage'>";
        while ($row = $result->fetch_row())
        {
            echo "<text class = 'text4'>$row[1]</text>";
            echo "<br><br>";
            echo "<text>$row[2]</text>";
            echo "<br><br>";
            echo "<text>$row[3]</text>";
            echo "<br><br>";
            echo "<hr><br>";
            if($result1 = $link->query($query1))
            {
                echo "<center>Вакансии</center><br><br>";
                while ($row1 = $result1->fetch_row())
                {
                    echo "<div class = 'aboveline3' onclick=\"location.href = 'showvacancy.php?vacid=$row1[0]'\">";
                        echo "<text class = 'text1'>$row1[1]</text>";
                        if ($row1[4] != null)
                            echo "<text class = 'right10'>От $row1[4] $row1[7]</text>";
                        echo "<br>";
                        echo "<text class = 'text2'>$row1[5]</text>";
                        echo "<br>";
                        $str1 = mb_substr(nl2br($row1[2]), 0, 300, 'utf-8');
                        if(mb_strlen($row1[2], 'utf-8') > 300){
                            $pos1 =  mb_strrpos($str1, ' ', 'utf-8');
                            $str2 = mb_substr(nl2br($row1[2]), 0, $pos1, 'utf-8');
                        }
                        else $str2 = $str1;
                        echo "<text class = 'width90'>" . $str2;
                        if(mb_strlen($row1[2], 'utf-8') > 300) echo "...";
                        echo "</text>";
                        echo "<br>";
                        echo "<br>";
                        $month = substr($row1[3], 5, 2);
                        $month = (int) $month;
                        echo "<text class = 'right10 bottom10'>".substr($row1[3], 8, 2).' '.$arrmonth[$month].' '.substr($row1[3], 0, 4)."</text>";
                    echo "</div>";
                }
                $result1->close();
            }
        }
        echo "</div>"; 
    echo "</body>";
    $result->close();
}

$link->close();

?>


<!--
<div id="sample">
  <script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script> <script type="text/javascript">
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
  </script>
  <h4>
    First Textarea
  </h4>
  <textarea name="area1" cols="40">
</textarea><br />
  <h4>
    Second Textarea
  </h4>
  <textarea name="area2" style="width: 100%; height: 200px;" placeholder = "Введите текст...">
</textarea><br />
  <h4>
    Third Textarea
  </h4>
  <textarea name="area3" style="width: 300px; height: 100px;">
       HTML content default in textarea
</textarea>
</div>-->