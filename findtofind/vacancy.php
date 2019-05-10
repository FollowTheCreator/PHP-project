<?php

require_once 'header.php';
require_once 'connection.php'; 
 
$link = new mysqli($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
 
if($_GET['search'])
    $outer = preg_replace("/(\s){2,}/",' ',$_GET['search']);                            //слово поиска
else $outer = preg_replace("/(\s){2,}/",' ',$_POST['search']); 
$arrouter = explode(" ", $outer);
$AoA = $_GET['prof_obl1'];
if($_GET['prof_obl2'])
    $subAoA = $_GET['prof_obl2'];                                                      
else $subAoA = $_POST['prof_obl2'];                                                 //проф область
if($_POST['prof_obl2s'])
    $subAoA = $_POST['prof_obl2s'];                                                  //проф область
if($_GET['key_skills'])
    $skills = explode(" ", preg_replace("/(\s){2,}/",' ',$_GET['key_skills']));         //ключевые навыки
else $skills = explode(" ", preg_replace("/(\s){2,}/",' ',$_POST['key_skills'])); 
if($_GET['reg2'])
    $region = $_GET['reg2'];                                                            //регион
else $region = $_POST['reg2']; 
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

if($_GET['company'])
    $company = $_GET['company'];
else $company = $_POST['company'];

$query = "
select distinct
	vacancy.id, 
	vacancy.header, 
	vacancy.description, 
	vacancy.date_of_publication, 
	vacancy.salary, 
	address.city, 
	company.name,
	vacancy.currency
from 
	vacancy 
	join address on vacancy.address = address.id 
	left join company on vacancy.employer = company.id
	join activity_of_advertisement_vacancy on activity_of_advertisement_vacancy.vacancy = vacancy.id
	join sub_activity_of_advertisement on sub_activity_of_advertisement.id = activity_of_advertisement_vacancy.activity_of_advertisement
	join activity_of_advertisement on activity_of_advertisement.id = sub_activity_of_advertisement.parent_activity_of_advertisement
	join union_timetable_vacancy on union_timetable_vacancy.vacancy = vacancy.id
	join timetable_vacancy on timetable_vacancy.id = union_timetable_vacancy.type
	join union_type_of_employment_vacancy on union_type_of_employment_vacancy.vacancy = vacancy.id
	join type_of_employment_vacancy on type_of_employment_vacancy.id = union_type_of_employment_vacancy.type
where
    vacancy.header like ('%$arrouter[0]%')
";
if (count($arrouter) > 1)
{
    for($i = 1; $i < count($arrouter); $i++)
        $query .= " and vacancy.header like ('%$arrouter[$i]%')";                       //слово поиска
}

if (count($subAoA) != 0){
    $query .= " and (sub_activity_of_advertisement.sub_name = '$subAoA[0]'";
    for($i = 1; $i < count($subAoA); $i++)
        $query .= " or sub_activity_of_advertisement.sub_name = '$subAoA[$i]'";         //проф субобласть
    $query .= ")";
}

if (($AoA) != ""){
    $query .= " and activity_of_advertisement.name = '$AoA'";         //проф область
}

if ($company != ""){
    $query .= " and company.name like ('%$company%')";         //проф область
}

if (count($skills) > 0)
{
    foreach($skills as $value)
        $query .= " and vacancy.key_skill like ('%$value%')";                              //ключевые навыки
}

if (count($region) != 0){
    $query .= " and (address.city = '$region[0]'";
    for($i = 1; $i < count($region); $i++)
        $query .= " or address.city = '$region[$i]'";                                   //регион
    $query .= ")";
}

if ($zarpl != null && $zarpl != " ")
{
    $query .= " and vacancy.salary >= $zarpl";                                          //зп
    $query .= " and vacancy.currency = '$zarplcurr'";                                   //валюта зп
}

if($exper == 'no')
    $query .= " and vacancy.experience is null";
else if($exper == 'three')
    $query .= " and (vacancy.experience <= 3 or vacancy.experience is null)";
else if($exper == 'bfive')
    $query .= " and (vacancy.experience <= 5 or vacancy.experience is null)";                                           // опыт
else if($exper == 'afive')
    $query .= " and (vacancy.experience >= 5 or vacancy.experience is null)";

if (count($ToEsearch) != 0){
    $query .= " and (type_of_employment_vacancy.type = '$ToEsearch[0]'";
    for($i = 1; $i < count($ToEsearch); $i++)
        $query .= " or type_of_employment_vacancy.type = '$ToEsearch[$i]'";                     //тип занятости
    $query .= ")";
}

if (count($TTsearch) != 0){
    $query .= " and (timetable_vacancy.type = '$TTsearch[0]'";
    for($i = 1; $i < count($TTsearch); $i++)
        $query .= " or timetable_vacancy.type = '$TTsearch[$i]'";                           //график работы
    $query .= ")";
}

if($sort == 'old')
    $query .= " order by vacancy.date_of_publication";
else if($sort == 'high')
    $query .= " order by vacancy.salary desc";
else if($sort == 'low')
    $query .= " order by isnull(vacancy.salary), vacancy.salary";                                           // сортировка
else
    $query .= " order by vacancy.date_of_publication desc";

    


if($result = $link->query($query))
{
    if(mysqli_num_rows($result) > 0)
    {
        echo "<body class = 'backadd'>";
            echo "<div class = 'indentation'>";
            $countvac = strval(mysqli_num_rows($result));
            if($countvac[strlen($countvac)-1] == 0 || $countvac[strlen($countvac)-1] > 4)
                echo "<div class = 'addfind'>Найдено $countvac вакансий</div>";
            else if($countvac[strlen($countvac)-1] == 1)
                echo "<div class = 'addfind'>Найдено $countvac вакансия</div>";
            else echo "<div class = 'addfind'>Найдено $countvac вакансии</div>";
            echo "<div class = 'addsearch' onclick = \"document.location.href = 'search.php?now=vac'\">Уточнить критерии поиска</div>";
            while ($row = $result->fetch_row())
            {
                echo "<div class = 'aboveline1' onclick=\"location.href = 'showvacancy.php?vacid=$row[0]'\">";
                    echo "<text class = 'text1'>$row[1]</text>";
                    if ($row[4] != null)
                        echo "<text class = 'addsalary'>От $row[4] $row[7]</text>";
                    echo "<br>";
                    echo "<text class = 'text2'>$row[6]</text>";
                    echo "<br>";
                    echo "<text class = 'text2'>$row[5]</text>";
                    echo "<br>";
                    $str1 = mb_substr(nl2br($row[2]), 0, 300, 'utf-8');
                    if(mb_strlen($row[2], 'utf-8') > 300){
                        $pos1 =  mb_strrpos($str1, ' ', 'utf-8');
                        $str2 = mb_substr(nl2br($row[2]), 0, $pos1, 'utf-8');
                    }
                    else $str2 = $str1;
                    echo "<text class = 'width90'>" . $str2;
                    if(mb_strlen($row[2], 'utf-8') > 300) echo "...";
                    echo "</text>";
                    echo "<br>";
                    echo "<br>";
                    $month = substr($row[3], 5, 2);
                    $month = (int) $month;
                    echo "<text class = 'adddate'>".substr($row[3], 8, 2).' '.$arrmonth[$month].' '.substr($row[3], 0, 4)."</text>";
                echo "</div>";
            }
            echo "<div class = 'addbottom'></div>";
            echo "</div>"; 
        echo "</body>";
        $result->close();
    }
    else
    {
        echo "<body class = 'backadd'>";
            echo "<text class = 'noadds'>Вакансий не найдено</text>";
        echo "</body>"; 
    }
}

 
$link->close();

?>