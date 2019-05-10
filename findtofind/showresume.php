<?php
require_once 'header.php';
require_once 'connection.php'; 
 
$link = new mysqli($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
 
$nowid = $_GET['resid'];
$tage = $_GET['tage'];
$exp1 = $_GET['exp'];

$nowres = "
select 
    resume.id,
    resume.post,
    resume.salary,
    resume.currency,
    resume.born,
    resume.about,
    resume.key_skill,
    gender.name,
    resume.date_of_publication, 
	contact_info_resume.name, 
	contact_info_resume.phone, 
    contact_info_resume.email
from
    resume
    join gender on gender.id = resume.gender
    join contact_info_resume on resume.contact = contact_info_resume.id
where 
    resume.id = $nowid
";

$nowresToE = "
select 
    type_of_employment_resume.type 
from 
    resume 
    join union_type_of_employment_resume on resume.id = union_type_of_employment_resume.resume 
    join type_of_employment_resume on type_of_employment_resume.id = union_type_of_employment_resume.type 
where 
    resume.id = $nowid
";

$nowresTT = "
select 
    timetable_resume.type 
from 
    resume 
    join union_timetable_resume on resume.id = union_timetable_resume.resume 
    join timetable_resume on timetable_resume.id = union_timetable_resume.type 
where 
    resume.id = $nowid
";

$nowresEDUC = "
select 
    profession.name,
    institution.name,
    education.end
from 
    resume 
	join educations on resume.id = educations.student
    join education on educations.education =  education.id
    join institution on institution.id = education.institution
    join profession on profession.id = education.profession
where 
    resume.id = $nowid
";

$nowresCOURSE = "
select 
    course.name,
    course.institution,
    course.end
from 
    resume 
	join courses on courses.student = resume.id
    join course on courses.course = course.id
where 
    resume.id = $nowid
";

$nowresEXP = "
select
	experience.company,
    experience.post,
    experience.about,
    experience.time,
    experience.end
from
	resume
    join job_experience on job_experience.employee = resume.id
    join experience on experience.id = job_experience.experience
where
	resume.id = $nowid
";

$nowresAoA = "
select
	activity_of_advertisement.name,
    sub_activity_of_advertisement.sub_name
from
	resume
    join activity_of_advertisement_resume on resume.id = activity_of_advertisement_resume.resume
    join sub_activity_of_advertisement on sub_activity_of_advertisement.id = activity_of_advertisement_resume.activity_of_advertisement
    join activity_of_advertisement on sub_activity_of_advertisement.parent_activity_of_advertisement = activity_of_advertisement.id 
where 
	resume.id = $nowid
";


if($result1 = $link->query($nowres))
{
    while ($row = $result1->fetch_row())
    {
        if($result1_1 = $link->query($nowresToE)){
            $ToE = "";
            while ($row1 = $result1_1->fetch_row()){
                $ToE .= "$row1[0], ";
            }
            $totalToE = mb_substr($ToE, 0, (mb_strlen($ToE,'utf-8')-2), 'utf-8'); // Тип занятости
        }
        $result1_1->close();

        if($result1_2 = $link->query($nowresTT)){
            $TT = "";
            while ($row2 = $result1_2->fetch_row()){
                $TT .= "$row2[0], ";
            }
            $totalTT = mb_substr($TT, 0, (mb_strlen($TT,'utf-8')-2), 'utf-8'); // график работы
        }
        $result1_2->close();

        if($result1_3 = $link->query($nowresEDUC)){
            $inc = -1;
            while ($row3 = $result1_3->fetch_row()){
                $inc++;
                $EDUC[$inc][0] = $row3[0]; // profession
                $EDUC[$inc][1] = $row3[1]; // institution                  // образование
                $EDUC[$inc][2] = $row3[2]; // end
            } 
        }
        $result1_3->close();

        if($result1_4 = $link->query($nowresCOURSE)){
            $inc = -1;
            while ($row4 = $result1_4->fetch_row()){
                $inc++;
                $COURSE[$inc][0] = $row4[0]; // profession
                $COURSE[$inc][1] = $row4[1]; // institution                  // курсы
                $COURSE[$inc][2] = $row4[2]; // end
            } 
        }
        $result1_4->close();

        if($result1_5 = $link->query($nowresEXP)){
            $inc = -1;
            while ($row5 = $result1_5->fetch_row()){
                $sum = 0;
                $time1 = new DateTime($row5[3]);
                $time2 = new DateTime($row5[4]);
                $time = $time1->diff($time2);
                $sum += $time->format('%a');
                $months = $sum % 365;
                $ly = ($sum - $months) / 365;
                $lm = intval ($months / 30);
                if ($ly == 0){
                    if ($lm == 0) $exp = "без опыта работы";
                    else if ($lm == 1) $exp = "1 месяц";
                    else if ($lm < 5) $exp = "$lm месяца";
                    else $exp = "$lm месяцев";
                }
                else if ($ly == 1 || $ly == 21 || $ly == 31){
                    if ($lm == 0) $exp = "1 год";
                    else if ($lm == 1) $exp = "1 год и 1 месяц";
                    else if ($lm < 5) $exp = "1 год и $lm месяца";
                    else $exp = "1 год и $lm месяцев";
                }
                else if ($ly < 5 || ($ly > 21 && $ly < 25) || ($ly > 31 && $ly < 35)){
                    if ($lm == 0) $exp = "$ly года";
                    else if ($lm == 1) $exp = "$ly года и 1 месяц";
                    else if ($lm < 5) $exp = "$ly года и $lm месяца";
                    else $exp = "$ly года и $lm месяцев";
                }
                else {
                    if ($lm == 0) $exp = "$ly лет";
                    else if ($lm == 1) $exp = "$ly лет и 1 месяц";
                    else if ($lm < 5) $exp = "$ly лет и $lm месяца";
                    else $exp = "$ly лет и $lm месяцев";
                }
                $inc++;
                $arrm = array(01 => 'январь', 02 => 'февраль', 03 => 'март', 04 => 'апрель', 05 => 'май', 06 => 'июнь', 07 => 'июль', 08 => 'август', 09 => 'сентябрь', 10 => 'октябрь', 11 => 'ноябрь', 12 => 'декабрь');
                $EXP[$inc][0] = $row5[0]; // company
                $EXP[$inc][1] = $row5[1]; // post                  
                $EXP[$inc][2] = $row5[2]; // about    
                $currmt = substr($row5[3], 5, 2);   
                $currmt = (int) $currmt;                                     // опыт
                $currme = substr($row5[4], 5, 2);   
                $currme = (int) $currme;                                       
                $EXP[$inc][3] = $row5[3]; // time
                $EXP[$inc][4] = $row5[4]; // end 
                $EXP[$inc][5] = $exp;     // total
                $EXP[$inc][6] = $arrm[$currmt].' '.substr($row5[3], 0, 4); // норм формат time
                $EXP[$inc][7] = $arrm[$currme].' '.substr($row5[4], 0, 4); // норм формат end
            } 
        }
        $result1_5->close();
        
        if($result1_6 = $link->query($nowresAoA)){
            $inc = -1;
            while ($row6 = $result1_6->fetch_row()){
                $inc++;
                $AoA_parent = $row6[0]; 
                $AoA_child[$inc] = $row6[1];                 // сфера деятельности
            } 
        }
        $result1_6->close();
        //
        //
        //
        //
        //
        echo "<body class = 'showback'>";
            echo "<div class = 'showpage'>";
                echo "<text>$row[7], $tage, ";
                $month = substr($row[4], 5, 2);
                $month = (int) $month;
                $born1 = (int) substr($row[4], 8, 2).' '.$arrmonth[$month].' '.substr($row[4], 0, 4).'</text>'; // пол и возраст
                if ($row[7] == 'мужчина') echo "родился $born1";
                else echo "родилась $born1";
                echo "<br>";
                echo "<text class = 'text1'>$row[1]</text><text class = 'right75'>$row[2] $row[3]</text>"; // должность и зп
                echo "<br><br><br>";
                echo "<text>$AoA_parent</text>";                            // сфера деятельности
                echo "<br>";
                echo "<ul>";
                foreach ($AoA_child as $value){
                    echo "<li>$value</li>";
                } 
                echo "</ul><br><hr><br>";
                echo "<text>Обо мне</text>"; 
                echo "<br>";       
                echo "<text>$row[5]</text>";                                // обо мне
                if($row[6] != null){
                    echo "<br><br>";
                    echo "<text>Ключевые навыки</text>";
                    echo "<br>";
                    $key_skill = explode('-/-', $row[6]);
                    foreach ($key_skill as $value){
                        echo '<text class = "keyskill">'.$value.'</text>'; // ключевые навыки
                    }
                    echo "<br>";
                }
                echo "<br><br><hr><br>";
                if ($exp1 == "без опыта работы")
                    echo "Без опыта работы";
                else {
                    echo "Опыт работы $exp1";
                    echo "<br>";
                    echo "<table>";  
                    foreach ($EXP as $value){
                        echo "<tr>"; 
                            echo "<td class = 'div20'>"; 
                            echo "<text>$value[6] - $value[7]</text>";
                            echo "<br>";
                            echo "<text class = 'text2'>$value[5]</text>";
                            echo "</td>";
                            echo "<td class = 'div80'>";
                            echo "<text>$value[0]</text>";
                            echo "<br>";
                            echo "<text class = 'bold'>$value[1]</text>";  // опыт работы
                            echo "<br>";
                            echo "<text>$value[2]</text>";
                            echo "</td>";
                        echo "</tr>";
                    }  
                    echo "</table>"; 
                }
                echo "<br>";
                if ($EDUC != null){
                    echo "Образование";
                    echo "<br>";
                    echo "<table>";  
                    foreach ($EDUC as $value){
                        echo "<tr>"; 
                            echo "<td class = 'div20'>"; 
                            echo "<text>$value[2]</text>";
                            echo "</td>";
                            echo "<td class = 'div80'>";                    // образование
                            echo "<text>$value[1]</text>";
                            echo "<br>";
                            echo "<text class = 'bold'>$value[0]</text>";  
                            echo "</td>";
                        echo "</tr>";
                    }  
                    echo "</table>"; 
                }
                if ($COURSE != null){
                    echo "<br>";
                    echo "Курсы";
                    echo "<br>";
                    echo "<table>";  
                    foreach ($COURSE as $value){
                        echo "<tr>"; 
                            echo "<td class = 'div20'>"; 
                            echo "<text>$value[2]</text>";
                            echo "</td>";
                            echo "<td class = 'div80'>";                    // курсы
                            echo "<text>$value[1]</text>";
                            echo "<br>";
                            echo "<text class = 'bold'>$value[0]</text>";  
                            echo "</td>";
                        echo "</tr>";
                    }  
                    echo "</table>"; 
                }
                echo "<br><hr><br>";
                if($totalToE != null){
                    echo "<div class = 'down1'>";
                    echo "<text>Тип занятости</text>";
                    echo "<br>";
                    echo "<text>$totalToE</text>";
                    echo "</div>";
                    echo "<br>";
                }
                if($totalTT != null){
                    echo "<div>";
                    echo "<text>График работы</text>";
                    echo "<br>";
                    echo "<text>$totalTT</text>";
                    echo "</div>";
                    echo "<br>";
                }
                echo '<hr><br><text class = "down1">Контактная информация</text>';
                echo '<br>';
                if ($row[9] != null) echo '<text class = "down1">'.$row[9].'</text><br>';
                if ($row[10] != null) echo '<text class = "down1">'.$row[10].'</text><br>'; // контактная инфо
                if ($row[11] != null) echo '<text class = "down1">'.$row[11].'</text><br>';
                echo '<br>';
                $month = substr($row[8], 5, 2);
                $month = (int) $month;
                echo '<br><text>Резюме опубликовано '.substr($row[8], 8, 2).' '.$arrmonth[$month].' '.substr($row[8], 0, 4).'</text>';
            echo "</div>";
        echo "</body>";
    }
    $result1->close();
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
</div>

-->


