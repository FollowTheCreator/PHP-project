<?php
require_once 'header.php';
require_once 'connection.php'; 
 
$link = new mysqli($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
 
/*                      запрос для вывода только тех компаний, в которых есть вакансии
$query = "
select 
	company.id, 
    company.name, 
    count(vacancy.employer) 
from 
    company 
    join vacancy on vacancy.employer = company.id 
group by 
    vacancy.employer
order by 
	company.name
";*/

$outer = preg_replace("/(\s){2,}/",' ',$_GET['search']);
if($_GET["without"])
{
    if($outer != " " && $outer != null){
        $arrouter = explode(" ", $outer);
        $query = "
        select 
            company.id, 
            company.name, 
            count(vacancy.employer) 
        from 
            company 
            join vacancy on vacancy.employer = company.id 
        where
            company.name like ('%$arrouter[0]%')
        ";
        if (count($arrouter) > 1)
        {
            for($i = 1; $i < count($arrouter); $i++)
                $query .= " and company.name like ('%$arrouter[$i]%')";
        }
        $query .= "
        group by 
            vacancy.employer
        order by 
            company.name
        ";
    }
    else{
        $query = "
        select 
            company.id, 
            company.name, 
            count(vacancy.employer) 
        from 
            company 
            join vacancy on vacancy.employer = company.id 
        group by 
            vacancy.employer
        order by 
            company.name
    ";
    }
}
else
{
    if ($outer != " " && $outer != null){
        $arrouter = explode(" ", $outer);
        $query = "
        select 
            company.id, 
            company.name,
            count(vacancy.employer)
        from 
            company 
            left join vacancy on vacancy.employer = company.id
        where
            company.name like ('%$arrouter[0]%')
        ";
        if (count($arrouter) > 1)
        {
            for($i = 1; $i < count($arrouter); $i++)
                $query .= " and company.name like ('%$arrouter[$i]%')";
        }
        $query .= "
        group by 
            company.name
        order by 
            company.name
        ";
    }
    else
    {
        $query = "
        select 
            company.id, 
            company.name,
            count(vacancy.employer),
            company.description
        from 
            company 
            left join vacancy on vacancy.employer = company.id
        group by 
            company.name
        order by 
            company.name
        ";
    }
}

if($result = $link->query($query))
{
    if(mysqli_num_rows($result) > 0)
    {
        echo "<body class = 'backadd'>";
            echo "<div class = 'indentation'>";
            $countvac = strval(mysqli_num_rows($result));
            if($countvac[strlen($countvac)-1] == 0 || $countvac[strlen($countvac)-1] > 4)
                echo "<div class = 'addfind'>Найдено $countvac компаний</div>";
            else if($countvac[strlen($countvac)-1] == 1)
                echo "<div class = 'addfind'>Найдено $countvac компания</div>";
            else echo "<div class = 'addfind'>Найдено $countvac компании</div>";
            if($_GET["without"])
                echo "<div class = 'withoutnullcom' onclick = \"location.href = 'company.php'\">Показать все компании</div>";
            else
                echo "<div class = 'withoutnullcom' onclick = \"location.href = 'company.php?without=null'\">Скрыть компании без вакансий</div>";
            while ($row = $result->fetch_row())
            {
                echo "<div class = 'aboveline1' onclick=\"location.href = 'showcompany.php?comid=$row[0]'\">";
                    echo "<text class = 'companyname'>$row[1]</text>";
                    echo "<br>";
                    echo "<br>";
                    echo "<text class = 'forcompanydesc'>".str_replace("\n", "<br>", $row[3])."</text>";
                    echo "<div class = 'companyline'></div>";
                    echo "<text class = 'companycount'>$row[2]</text>";
                echo "</div>";
                
            }
            echo "<div class = 'addbottom'></div>";
            echo "</div>"; 
        $result->close();
        echo "</doby>";
    }
    else{
        echo "<body class = 'backadd'>";
            echo "<text class = 'noadds'>Компаний не найдено</text>";
        echo "</body>"; 
    }
}

 
$link->close();

?>