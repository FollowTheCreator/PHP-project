<?php
require_once 'header.php';
require_once 'connection.php'; 
echo '<script src="js/yandex.js" type="text/javascript"></script>';

$link = new mysqli($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
 
$nowid = $_GET['vacid'];

$nowvac = "
select 
    vacancy.id,
    vacancy.experience,
	vacancy.header,
    vacancy.description,
    vacancy.date_of_publication,
    vacancy.salary,
    vacancy.key_skill,
    vacancy.currency,
	company.name, 
	address.city, 
	address.street, 
	address.house, 
	address.point, 
	contact_info_vacancy.name, 
	contact_info_vacancy.phone, 
    contact_info_vacancy.email
from 
	vacancy 
	left join company on vacancy.employer = company.id 
	join address on vacancy.address = address.id 
	join contact_info_vacancy on vacancy.contact = contact_info_vacancy.id 
where 
	vacancy.id = $nowid
";
$nowvacToE = "select type_of_employment_vacancy.type from vacancy join union_type_of_employment_vacancy on vacancy.id = union_type_of_employment_vacancy.vacancy join type_of_employment_vacancy on type_of_employment_vacancy.id = union_type_of_employment_vacancy.type where vacancy.id = $nowid";
$nowvacTT = "select timetable_vacancy.type from vacancy join union_timetable_vacancy on vacancy.id = union_timetable_vacancy.vacancy join timetable_vacancy on timetable_vacancy.id = union_timetable_vacancy.type where vacancy.id = $nowid";

if($result1 = $link->query($nowvac))
{
    echo "<body class = 'showback'>";
        echo "<div class = 'showpage'>";
            while ($row = $result1->fetch_row())
            {
                echo "<text class = 'text1'>$row[2]</text>"; // название
                echo "<br>";


                if ($row[5] == null) echo "з/п не указана"; // з/п
                else echo "От $row[5] $row[7]";
                echo "<br><br><hr><br>";


                if($row[8] != "")
                {
                    echo "<text class = 'text1'>$row[8]</text>"; // работодатель
                    echo "<br><br>";
                }


                if ($row[1] == null) echo "Опыт работы не требуется";
                else if ($row[1] == 1) echo "Требуемый опыт работы: более $row[1] года"; // опыт работы
                else echo "Требуемый опыт работы: более $row[1] лет";
                echo "<br><br>";


                if($result1_1 = $link->query($nowvacToE)){
                    $ToE = "Тип занятости: ";
                    while ($row1 = $result1_1->fetch_row()){
                        $ToE .= "$row1[0], ";
                    }
                    echo mb_substr($ToE, 0, (mb_strlen($ToE,'utf-8')-2), 'utf-8'); // Тип занятости
                }
                $result1_1->close();
                echo "<br><br>";


                if($result1_2 = $link->query($nowvacTT)){
                    $TT = "График работы: ";
                    while ($row2 = $result1_2->fetch_row()){
                        $TT .= "$row2[0], ";
                    }
                    echo mb_substr($TT, 0, (mb_strlen($TT,'utf-8')-2), 'utf-8'); // график работы
                }
                $result1_2->close();
                echo "<br><br><hr><br>";


                echo "<text>".nl2br($row[3])."</text>"; // описание
                echo "<br><br>";


                if($row[6] != null){
                    echo "<text>Ключевые навыки</text>";
                    echo "<br>";
                    $key_skill = explode('-/-', $row[6]);
                    foreach ($key_skill as $value){
                        echo '<text class = "keyskill">'.$value.'</text>'; // ключевые навыки
                    }
                    echo "<br><br><hr>";
                }


                echo '<text class = "down1">Контактная информация</text>';
                echo '<br>';
                if ($row[13] != null) echo '<text class = "down1">'.$row[13].'</text><br>';
                if ($row[14] != null) echo '<text class = "down1">'.$row[14].'</text><br>'; // контактная инфо
                if ($row[15] != null) echo '<text class = "down1">'.$row[15].'</text><br>';
                echo '<br>';
                

                echo '<text class = "down1">Адрес</text>';
                echo "<br>";
                echo '<text class = "down1">'.$row[9].', '.$row[10].', '.$row[11].'</text>'; // адрес текстом
                echo "<br>";
                $rowXY = explode(",", $row[12]);
                $rowX = $rowXY[0];
                $rowY = $rowXY[1];
                echo '<div id = "map" class = "down1"></div>';
                echo '<script type="text/javascript">checkloc();setCenter('.$rowX.','.$rowY.');</script>'; // адрес на карте
                echo "<br><br><br>";


                $month = substr($row[4], 5, 2);
                $month = (int) $month;
                echo '<text>Вакансия опубликована '.substr($row[4], 8, 2).' '.$arrmonth[$month].' '.substr($row[4], 0, 4).'</text>'; // дата подачи

            }
            $result1->close();
        echo "</div>";
    echo "</body>";
}

$link->close();

?>