<?php

require_once 'header.php';
require_once 'connection.php'; 
 
$link = new mysqli($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));

if($_COOKIE['type'] == 'vac')
{
    $query = "
    select 
        company.name,
        company.description,
        company.site,
        company.pass
    from
        company
    where
        company.id = ".$_COOKIE['id'];

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
        vacancy.employer = ".$_COOKIE['id'];

    if($result = $link->query($query))
    {
        $row = $result->fetch_row();
        if($_POST['save'])
        {
            if($_POST['site']) $site = $_POST['site'];
            else $site = null;
            if($_POST['name']) $nameacc = $_POST['name'];
            else $nameacc = null;
            if($_POST['description']) $description = $_POST['description'];
            else $description = null;
            if(md5(md5($_POST['old'])) == $row[3] && $_POST['new'])
            {
                $updqueryvac = "
                update
                    company
                set
                    name = '".$nameacc."',
                    description = '".$description."',
                    site = '".$site."',
                    pass = '".md5(md5($_POST['new']))."'
                where
                    id = ".$_COOKIE['id'];
                $link->query($updqueryvac);
                echo "<script>reload();</script>";
            }
            else if(!$_POST['new']){
                $updqueryvac = "
                update
                    company
                set
                    name = '".$nameacc."',
                    description = '".$description."',
                    site = '".$site."'
                where
                    id = ".$_COOKIE['id'];
                $link->query($updqueryvac);
                echo "<script>reload();</script>";
            }
            else if($_POST['old'] != null){
                $updqueryvac = "
                update
                    company
                set
                    name = '".$nameacc."',
                    description = '".$description."',
                    site = '".$site."'
                where
                    id = ".$_COOKIE['id'];
                $link->query($updqueryvac);
                echo "<script>reload();</script>";
            }
            else{
                $updqueryvac = "
                update
                    company
                set
                    name = '".$nameacc."',
                    description = '".$description."',
                    site = '".$site."'
                where
                    id = ".$_COOKIE['id'];
                $link->query($updqueryvac);
                echo "<script>reload();</script>";
            }
        }
        echo $_COOKIE['login'];
        echo "<body class = 'backaccount'>";
            echo "<form method = 'POST' class = 'accinfores'>";
                echo "<text class = 'accname'>".$_COOKIE['login']."</text>";
                echo "<text class = 'accacc'>аккаунт компании</text>";
                echo "<text class = 'accexit' onclick = 'deleteCookie()'>Выйти</text>";
                echo "<text class = 'accvacname'>Название</text>";
                echo "<input name = 'name' class = 'accvacinptname' type = 'text' value = '$row[0]' readonly></input> <text class = 'accvacchngname' onclick = 'updateinp(this)'>Изменить</text>";
                echo "<text class = 'accvacdesc'>Описание</text>";
                echo "<textarea name = 'description' class = 'accvacinptdesc' type = 'text' readonly>$row[1]</textarea> <text class = 'accvacchngdesc' onclick = 'updateinp(this)'>Изменить</text>";
                echo "<text class = 'accvacsite'>Сайт</text>";
                echo "<input name = 'site' class = 'accvacinptsite' type = 'text' value = '$row[2]' readonly></input> <text class = 'accvacchngsite' onclick = 'updateinp(this)'>Изменить</text>";
                echo "<text class = 'accvacchangepass' onclick = 'updatepas(this)'>Изменить пароль</text>";
                echo "<div class = 'passesvac' style = 'display: none;'>";
                    echo "<input name = 'old' class = 'accvacold' name = 'prev' type = 'password' placeholder = 'Старый пароль'></input>";
                    echo "<br>";
                    echo "<input name = 'new' class = 'accvacold' name = 'post' type = 'password' placeholder = 'Новый пароль' minlength = '3'></input>";
                echo "</div>";
                echo "<br>";
                echo "<input class = 'accvacsbmt' name = 'save' type = 'submit' style = 'display: none;' value = 'Сохранить изменения'>";
            echo "</form>";
            if($result1 = $link->query($query1))
            {
                echo "<div class = 'accvacpos'>Вакансии этого аккаунта</div>";
                echo "<div class = 'accaddvacpos' onclick = \"location.href = 'addvac.php'\">Открыть вакансию</div>";
                while ($row1 = $result1->fetch_row())
                {
                    echo "<div class = 'aboveline2' onclick=\"location.href = 'showvacancy.php?vacid=$row1[0]'\">";
                        echo "<text class = 'text1'>$row1[1]</text>";
                        if ($row1[4] != null)
                            echo "<text class = 'addsalary'>От $row1[4] $row1[6]</text>";
                        echo "<br>";
                        echo "<text class = 'text2'>$row1[5]</text>";
                        echo "<br>";
                        $str1 = mb_substr(nl2br($row1[2]), 0, 300, 'utf-8');
                        if(mb_strlen($row[2], 'utf-8') > 300){
                            $pos1 =  mb_strrpos($str1, ' ', 'utf-8');
                            $str2 = mb_substr(nl2br($row[2]), 0, $pos1, 'utf-8');
                        }
                        else $str2 = $str1;
                        echo "<text class = 'width90'>" . $str2;
                        if(mb_strlen($row1[2], 'utf-8') > 300) echo "...";
                        echo "</text>";
                        echo "<br>";
                        echo "<br>";
                        $month = substr($row1[3], 5, 2);
                        $month = (int) $month;
                        echo "<text class = 'adddate'>".substr($row1[3], 8, 2).' '.$arrmonth[$month].' '.substr($row1[3], 0, 4)."</text>";
                        echo "<br>";
                        echo "<div class = 'forupdate'><text class = 'hand linkupd' onclick=\"location.href = 'updatevacancy.php?vacid=$row1[0]'\">Редактировать</text></div>";
                        echo "<div class = 'fordelete'><text class = 'hand linkupd' onclick=\"location.href = 'deletevacancy.php?vacid=$row1[0]'\">Удалить</text></div>";
                    echo "</div>";
                }
            }
            $result1->close();
        echo "</body>";
    }
    $result->close();

}
else if($_COOKIE['type'] == 'res')
{
    $query = "
    select 
        user_resume.login,
        user_resume.pass
    from
        user_resume
    where
        user_resume.id = ".$_COOKIE['id'];

    $query1 = "
    select 
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
    where
        resume.user = ".$_COOKIE['id']."
    group by idres";

    if($result = $link->query($query))
    {
        $row = $result->fetch_row();
        if($_POST['save'])
        {
            if(md5(md5($_POST['old'])) == $row[1] && $_POST['new'])
            {
                $updqueryvac = "
                update
                    user_resume
                set
                    pass = '".md5(md5($_POST['new']))."'
                where
                    id = ".$_COOKIE['id'];
                $link->query($updqueryvac);
                echo "<script>reload();</script>";
            }
            else if(!$_POST['new']){
                echo '<script type="text/javascript">alert("Вы не ввели новый пароль пароль")</script>';
            }
            else if($_POST['old'] != null){
                echo '<script type="text/javascript">alert("Неправильный старый пароль")</script>';
            }
        }
        echo $_COOKIE['login'];
        echo "<body class = 'backaccount'>";
            echo "<form method = 'POST' class = 'accinfores'>";
                echo "<text class = 'accname'>".$_COOKIE['login']."</text>";
                echo "<text class = 'accaccvac'>аккаунт пользователя</text>";
                echo "<text class = 'accexit' onclick = 'deleteCookie()'>Выйти</text>";
                echo "<text class = 'accchangepass' onclick = 'updatepas(this)'>Изменить пароль</text>";
                echo "<div class = 'passes' style = 'display: none;'>";
                    echo "<input name = 'old' class = 'accold' name = 'prev' type = 'password' placeholder = 'Старый пароль'></input>";
                    echo "<br>";
                    echo "<input name = 'new' class = 'accnew' name = 'post' type = 'password' placeholder = 'Новый пароль' minlength = '3'></input>";
                echo "</div>";
                echo "<br>";
                echo "<input class = 'accsbmt' name = 'save' type = 'submit' style = 'display: none;' value = 'Сохранить изменения'>";
            echo "</form>";
            if($result1 = $link->query($query1))
            {
                echo "<div class = 'accrespos'>Резюме этого аккаунта</div>";
                echo "<div class = 'accaddrespos' onclick = \"location.href = 'addres.php'\">Создать резюме</div>";
                while ($row1 = $result1->fetch_row())
                {
                    if ($row1[8] < 5 && $row1[8] != 0) $add = 'год';
                    else $add = 'лет'; 
                    $tage = $row1[8] . " " . $add;

                    $months = $row1[7] % 365;
                    $ly = ($row1[7] - $months) / 365;
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

                    echo "<div class = 'aboveline2' onclick = \"location.href='showresume.php?resid=$row1[0]&tage=$tage&exp=$exp'\">";

                    echo "<text class = 'text1'>$row1[1]</text>";/////////////////////////////////////// должность

                    echo "<text class = 'addsalary'>$tage</text>";/////////////////////////////////////// возраст

                    $zp = $row1[2].' '.$row1[3];
                    echo "<text class = 'addsalary1'>$zp</text>";/////////////////////////////////////// зп

                    echo "<br>";
                    echo "<text>Опыт работы <br>";
                    echo $exp;/////////////////////////////////////// опыт работы
                    echo "</text>";
                    echo "<br>";

                    if($row1[5] != null){
                        echo "<text>Ключевые навыки</text>";
                        echo "<br>";
                        $key_skill = explode('-/-', $row1[5]);
                        for ($i = 0; $i < count($key_skill) - 1; $i++){
                            echo '<text>'.$key_skill[$i].', </text>'; ///////////////////////////////////////// ключевые навыки
                        }
                        echo '<text>'.$key_skill[count($key_skill) - 1].'</text>';
                        echo "<br>";
                    }
                    $month = substr($row1[6], 5, 2);/////////////////////////////////////////////////////////////////////////////////////////////// дата подачи
                    $month = (int) $month;
                    echo "<text class = 'adddate'>".substr($row1[6], 8, 2).' '.$arrmonth[$month].' '.substr($row1[6], 0, 4)."</text>";
                    echo "<br>";
                    echo "<div class = 'forupdate'><text class = 'hand linkupd' onclick=\"location.href = 'updateresume.php?resid=$row1[0]&tage=$tage&exp=$exp'\">Редактировать</text></div>";
                    echo "<div class = 'fordelete'><text class = 'hand linkupd' onclick=\"location.href = 'deleteresume.php?resid=$row1[0]'\">Удалить</text></div>";
                    
                echo '</div>';
                }
            }
            $result1->close();
        echo "</body>";
    }
    $result->close();
}
 
$link->close();

?>
