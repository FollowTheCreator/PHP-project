<?php
require_once 'header.php';
require_once 'connection.php'; 
 
$link = new mysqli($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));

if($_GET['search'])
    $outer = preg_replace("/(\s){2,}/",' ',$_GET['search']);                            //слово поиска
else $outer = preg_replace("/(\s){2,}/",' ',$_POST['search']); 
$arrouter = explode(" ", $outer);

if($_GET['prof_obl2'])
    $subAoA = $_GET['prof_obl2'];                                                       //проф область
else $subAoA = $_POST['prof_obl2'];       
if($_POST['prof_obl2s'])
    $subAoA = $_POST['prof_obl2s'];                                                  //проф область
if($_GET['key_skills'])
    $skills = explode(" ", preg_replace("/(\s){2,}/",' ',$_GET['key_skills']));         //ключевые навыки
else $skills = explode(" ", preg_replace("/(\s){2,}/",' ',$_POST['key_skills'])); 

if($_GET['zarpl'])
    $zarpl = preg_replace("/(\s){2,}/",' ', $_GET['zarpl']);                            //зп
else $zarpl = preg_replace("/(\s){2,}/",' ', $_POST['zarpl']);  

if($_GET['zarplcurr'])
    $zarplcurr = $_GET['zarplcurr'];                                                    //валюта зп
else $zarplcurr = $_POST['zarplcurr'];    

if($_GET['exper'])
    $exper = $_GET['exper'];                                                            //опыт
else $exper = $_POST['exper'];  

if($_GET['chToE'])
    $ToEsearch = $_GET['chToE'];                                                        //тип занятости
else $ToEsearch = $_POST['chToE']; 

if($_GET['chTT'])
    $TTsearch = $_GET['chTT'];                                                          //график работы
else $TTsearch = $_POST['chTT']; 

if($_GET['sort'])
    $sort = $_GET['sort'];                                                              //сортировка
else $sort = $_POST['sort']; 

if($_GET['gender'])
    $gender = $_GET['gender'];                                                          //пол
else $gender = $_POST['gender']; 

if($_GET['from'])
    $from = $_GET['from'];                                                              //возраст от
else $from = $_POST['from']; 

if($_GET['until'])
    $until = $_GET['until'];                                                            //возраст до
else $until = $_POST['until']; 

$query = "
select distinct
    resume.id as idres, 
    resume.post, 
    resume.salary, 
    resume.currency, 
    resume.born, 
    resume.key_skill,
    resume.date_of_publication,
    round(sum(datediff(experience.end, experience.time)) / ((count(resume.id)) / (SELECT count(resume.id) from resume join job_experience on job_experience.employee = resume.id join experience on experience.id = job_experience.experience where resume.id = idres)),0) as experience,
    floor(datediff(curdate(), resume.born) / 365) as age
from 
    resume 
    left join job_experience on job_experience.employee = resume.id
    left join experience on experience.id = job_experience.experience
	join activity_of_advertisement_resume on activity_of_advertisement_resume.resume = resume.id
	join sub_activity_of_advertisement on sub_activity_of_advertisement.id = activity_of_advertisement_resume.activity_of_advertisement
	join activity_of_advertisement on activity_of_advertisement.id = sub_activity_of_advertisement.parent_activity_of_advertisement
	join union_timetable_resume on union_timetable_resume.resume = resume.id
	join timetable_resume on timetable_resume.id = union_timetable_resume.type
	join union_type_of_employment_resume on union_type_of_employment_resume.resume = resume.id
	join type_of_employment_resume on type_of_employment_resume.id = union_type_of_employment_resume.type
    join gender on gender.id = resume.gender
where
    resume.post like ('%$arrouter[0]%')
";
if (count($arrouter) > 1)
{
    for($i = 1; $i < count($arrouter); $i++)
        $query .= " and resume.header like ('%$arrouter[$i]%')";                       //слово поиска
}

if (count($subAoA) != 0){
    $query .= " and (sub_activity_of_advertisement.sub_name = '$subAoA[0]'";
    for($i = 1; $i < count($subAoA); $i++)
        $query .= " or sub_activity_of_advertisement.sub_name = '$subAoA[$i]'";         //проф субобласть
    $query .= ")";
}

if (count($skills) > 0)
{
    foreach($skills as $value)
        $query .= " and resume.key_skill like ('%$value%')";                              //ключевые навыки
}

if ($zarpl != null && $zarpl != " ")
{
    $query .= " and resume.salary <= $zarpl";                                          //зп
    $query .= " and resume.currency = '$zarplcurr'";                                   //валюта зп
}

if ($gender != null)
{
    $query .= " and gender.name = '$gender'"; 
}

if (count($ToEsearch) != 0){
    $query .= " and (type_of_employment_resume.type = '$ToEsearch[0]'";
    for($i = 1; $i < count($ToEsearch); $i++)
        $query .= " or type_of_employment_resume.type = '$ToEsearch[$i]'";                     //тип занятости
    $query .= ")";
}

if (count($TTsearch) != 0){
    $query .= " and (timetable_resume.type = '$TTsearch[0]'";
    for($i = 1; $i < count($TTsearch); $i++)
        $query .= " or timetable_resume.type = '$TTsearch[$i]'";                           //график работы
    $query .= ")";
}

$query .= " group by resume.id";                                                                //группировка для подсчета дней

if ($exper != 'nodiff' || $from != null || $until != null)
{
    $query .= " having";
    if($exper == 'no')
        $query .= " experience is null";
    else if($exper == 'one')
        $query .= " (experience >= 365)";
    else if($exper == 'three')
        $query .= " (experience >= 1095)";                                                         // опыт
    else if($exper == 'five')
        $query .= " (experience >= 1825)";
    else
        $query .= " (experience is null or experience is not null)";

    if($from != null)
    {
        $query .= " and age >= $from";                                                                //возраст от
    }

    if($until != null)
    {
        $query .= " and age <= $until";                                                                //возраст до
    }
}

if($sort == 'old')
    $query .= " order by resume.date_of_publication";
else if($sort == 'high')
    $query .= " order by resume.salary desc";
else if($sort == 'low')
    $query .= " order by isnull(resume.salary), resume.salary";                                           // сортировка
else
    $query .= " order by resume.date_of_publication desc";



if($result = $link->query($query))
{
    if(mysqli_num_rows($result) > 0)
    {
        echo "<body class = 'backadd'>";
            echo "<div class = 'indentation'>";
                $countvac = strval(mysqli_num_rows($result));
                echo "<div class = 'addfind'>Найдено $countvac резюме</div>";
                echo "<div class = 'addsearch' onclick = \"document.location.href = 'search.php?now=res'\">Уточнить критерии поиска</div>";
                while ($row = $result->fetch_row())
                {
                    $dd = date('d',time());
                    $dm = date('m',time());
                    $dy = date('Y',time());
                    $age1 = $dy.'-'.$dm.'-'.$dd;
                    $age11 = new DateTime($age1);
                    $age22 = new DateTime($row[4]);
                    $age = $age11->diff($age22);
                    $totalage = $age->format('%y');
                    if ($totalage[1] < 5 && $totalage[1] != 0) $add = 'год';
                    else $add = 'лет'; 
                    $tage = $totalage . " " . $add; /////////////////////////////////////// возраст

                    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    $query1 = "
                            select 
                                experience.time, 
                                experience.end 
                            from 
                                resume 
                                join job_experience on resume.id = job_experience.employee 
                                join experience on experience.id = job_experience.experience 
                            where 
                                resume.id = $row[0]
                    ";
                    if ($result1 = $link->query($query1)){
                        $sum = 0;
                        while ($row1 = $result1->fetch_row()){
                            $time1 = new DateTime($row1[0]);
                            $time2 = new DateTime($row1[1]);
                            $time = $time1->diff($time2);
                            $sum += $time->format('%a');
                        }
                        $months = $sum % 365;
                        $ly = ($sum - $months) / 365;
                        $lm = intval ($months / 30);
                        if ($ly == 0){
                            if ($lm == 0) $exp = "без опыта работы";////////////////////////////////////////////////////////////////////////////// опыт работы
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
                    }////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    //
                    //
                    //
                    //
                    //
                    echo "<div class = 'aboveline1' onclick = \"location.href='showresume.php?resid=$row[0]&tage=$tage&exp=$exp'\">";

                        echo "<text class = 'text1'>$row[1]</text>";/////////////////////////////////////// должность

                        echo "<text class = 'addsalary'>$totalage $add</text>";/////////////////////////////////////// возраст

                        $zp = $row[2].' '.$row[3];
                        echo "<text class = 'addsalary1'>$zp</text>";/////////////////////////////////////// зп

                        echo "<br>";
                        echo "<text>Опыт работы <br>";
                        echo $exp;/////////////////////////////////////// опыт работы
                        echo "</text>";
                        echo "<br>";

                        if($row[5] != null){
                            echo "<text>Ключевые навыки</text>";
                            echo "<br>";
                            $key_skill = explode('-/-', $row[5]);
                            for ($i = 0; $i < count($key_skill) - 1; $i++){
                                echo '<text>'.$key_skill[$i].', </text>'; ///////////////////////////////////////// ключевые навыки
                            }
                            echo '<text>'.$key_skill[count($key_skill) - 1].'</text>';
                            echo "<br>";
                        }
                        $month = substr($row[6], 5, 2);/////////////////////////////////////////////////////////////////////////////////////////////// дата подачи
                        $month = (int) $month;
                        echo "<text class = 'adddate'>".substr($row[6], 8, 2).' '.$arrmonth[$month].' '.substr($row[6], 0, 4)."</text>";
                        
                        $result1->close();
                    echo '</div>';
                    echo "<div class = 'addbottom'></div>";
                }
            echo "</div>"; 
        echo "</body>";
        $result->close();
    }
    else{
        echo "<body class = 'backadd'>";
            echo "<text class = 'noadds'>Резюме не найдено</text>";
        echo "</body>"; 
    }
}


 
$link->close();

?>