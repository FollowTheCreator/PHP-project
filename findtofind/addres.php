<?php

require_once 'header.php';
require_once 'connection.php'; 
 
$link = new mysqli($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));

if($_COOKIE['type'] == 'res')
{
    $forfield = "
    select
        activity_of_advertisement.id,
        activity_of_advertisement.name
    from
        activity_of_advertisement
    ";
    if($_GET['addresum'])
    {
        $querycontact = "
        insert into 
            contact_info_resume (name, phone, email)
        values 
            ('".$_GET['name']."', '".$_GET['phone']."', '".$_GET['email']."')
        ";
        $link->query($querycontact);
        $lastcontact = $link->insert_id;

        if($_GET['educprof'])
        {
            $masedu = array();
            $eduprof = $_GET['educprof'];
            $eduinst = $_GET['educinst'];
            $eduend = $_GET['educend'];
            for($i = 0; $i < count($eduprof); $i++)
            {
                $queryprof = "
                insert into 
                    profession (name)
                values 
                    ('".$eduprof[$i]."')
                ";
                $link->query($queryprof);
                $lastprof = $link->insert_id;
                $queryinst = "
                insert into 
                    institution (name)
                values 
                    ('".$eduinst[$i]."')
                ";
                $link->query($queryinst);
                $lastinst = $link->insert_id;
                $queryedu = "
                insert into 
                    education (profession, institution, end)
                values 
                    ('".$lastprof."', '".$lastinst."', '".$eduend[$i]."')
                ";
                $link->query($queryedu);
                $masedu[$i] = $link->insert_id;
            }
        }

        if($_GET['cursprof'])
        {
            $mascurs = array();
            $cursprof = $_GET['cursprof'];
            $cursinst = $_GET['cursinst'];
            $cursend = $_GET['cursend'];
            for($i = 0; $i < count($cursprof); $i++)
            {
                $querycurs = "
                insert into 
                    course (name, institution, end)
                values 
                    ('".$cursprof[$i]."', '".$cursinst[$i]."', '".$cursend[$i]."')
                ";
                $link->query($querycurs);
                $mascurs[$i] = $link->insert_id;
            }
        }

        if($_GET['jobcom'])
        {
            $masjob = array();
            $jobcom = $_GET['jobcom'];
            $jobpost = $_GET['jobpost'];
            if($_GET['jobabo']) $jobabo = $_GET['jobabo'];
            else $jobabo = null;
            $jobtime = $_GET['jobtime'];
            $jobend = $_GET['jobend'];
            for($i = 0; $i < count($jobcom); $i++)
            {
                $queryjob = "
                insert into 
                    experience (company, time, post, end, about)
                values 
                    ('".$jobcom[$i]."', '".$jobtime[$i]."', '".$jobpost[$i]."', '".$jobend[$i]."', '".$jobabo[$i]."')
                ";
                $link->query($queryjob);
                $masjob[$i] = $link->insert_id;
            }
        }

        if($_GET['gender']) $gender = $_GET['gender'];
        else $gender = null;
        if($_GET['salary']) {$salary = $_GET['salary']; $currency = $_GET['currency'];}
        else {$salary = null; $currency = null;}
        if($_GET['keyskill']) $keyskill = implode('-/-', $_GET['keyskill']);
        else $keyskill = null;
        if($_GET['born']) $born = $_GET['born'];
        else $born = null;
        $queryresume = "
        insert into 
            resume (about, salary, post, currency, contact, key_skill, gender, born, date_of_publication, user)
        values 
            ('".$_GET['about']."', '".$salary."', '".$_GET['post']."', '".$currency."', '".$lastcontact."', '".$keyskill."', '".$gender."', '".$born."', '".date('Y-m-d')."', '".$_COOKIE['id']."')
        ";
        $link->query($queryresume);
        $lastresume = $link->insert_id;

        if($_GET['chToE'])
        {
            foreach($_GET['chToE'] as $value)
            {
                $queryToE = "
                insert into 
                    union_type_of_employment_resume (type, resume)
                select f.id, ".$lastresume."
                from
                    (select id from type_of_employment_resume where type = '".$value."') f
                ";
                $link->query($queryToE);
            }
        }

        if($_GET['chTT'])
        {
            foreach($_GET['chTT'] as $value)
            {
                $queryTT = "
                insert into 
                    union_timetable_resume (type, resume)
                select f.id, ".$lastresume."
                from
                    (select id from timetable_resume where type = '".$value."') f
                ";
                $link->query($queryTT);
            }
        }

        if($_GET['educprof'])
        {
            foreach($masedu as $value)
            {
                $queryeducat = "
                insert into 
                    educations (education, student)
                values
                    ($value, $lastresume)
                ";
                $link->query($queryeducat);
            }
        }

        if($_GET['cursprof'])
        {
            foreach($mascurs as $value)
            {
                $querycourse = "
                insert into 
                    courses (course, student)
                values
                    ($value, $lastresume)
                ";
                $link->query($querycourse);
            }
        }

        if($_GET['jobcom'])
        {
            foreach($masjob as $value)
            {
                $queryjobs = "
                insert into 
                    job_experience (experience, employee)
                values
                    ($value, $lastresume)
                ";
                $link->query($queryjobs);
            }
        }

        if($_GET['prof_obl2'])
        {
            foreach($_GET['prof_obl2'] as $value)
            {
                $queryprof = "
                insert into 
                    activity_of_advertisement_resume (resume, activity_of_advertisement)
                select $lastresume , f.id
                from
                    (select 
                        sub_activity_of_advertisement.id as id
                    from 
                        sub_activity_of_advertisement 
                        join  activity_of_advertisement on sub_activity_of_advertisement.parent_activity_of_advertisement = activity_of_advertisement.id
                    where 
                        sub_activity_of_advertisement.sub_name = '".$value."' and activity_of_advertisement.name = '".$_GET['prof_obl3']."') f
                ";
                $link->query($queryprof);
            }
        }
    }
    echo "<body class = 'showback1 addreswidth'>";
        echo "<div class = 'showpage'>";
            echo "<text class = 'addheader'>Создание резюме</text>";
            echo "<br><br><br>";
            echo "<form method = 'GET'>";

            echo "<br><br><input class = 'addrespost' name = 'post' type = 'text' placeholder = 'Должность' autocomplete = 'off' required maxlength='200'/>";
            echo "<br>";

            echo "<br><br><input class = 'addresslr' name = 'salary' type = 'text' placeholder = 'Желаемая зарплата' autocomplete = 'off'/>";
            echo "
                <select class = 'addrescrrncy' name = 'currency'>
                    <option selected><text>BYN</text></option>
                    <option><text>USD</text></option>
                    <option><text>EUR</text></option>
                </select>";
            echo "<br>";

            echo "<div class = 'addresgender'>";
                echo "
                    <label><input type = 'radio' name = 'gender' value = '1'></input><text>Мужчина</text></label><br>
                    <label><input type = 'radio' name = 'gender' value = '2'></input><text>Женщина</text></label><br>";
            echo "</div>";
            
            echo "<div class = 'addresdate'>";
                echo "<text>Дата рождения</text>";
                echo "<br>";
                echo "<input class = 'addrescalendar' name = 'born' type = 'date' autocomplete = 'off'/>";
            echo "</div>";

            echo "<textarea class = 'addresabout' name = 'about' type = 'textarea' placeholder = 'О себе...' required maxlength='3000'></textarea>";
            echo "<br><br>";

            echo "<div class = 'addreskeyskill'>";
                echo "<text>Ключевые навыки</text>";
                echo "<br>";
                echo "<text class = 'plus' onclick = 'addkey()'>добавить</text>";
                echo "<br>";
                echo "<div class = 'contkey'></div>";
            echo "</div>";
            echo "<br><br>";

            echo "<div class = 'addresfield'>";
                echo "<text>Сфера деятельности</text>";
                echo "<br>";
                if($resultfield = $link->query($forfield)){
                    while($rowfield = $resultfield->fetch_row()){
                        $parentfield = $rowfield[0];
                        $forsubfield = "
                        select
                            sub_activity_of_advertisement.sub_name
                        from
                            sub_activity_of_advertisement
                        where
                            sub_activity_of_advertisement.parent_activity_of_advertisement = $parentfield
                        ";
                        if($resultsubfield = $link->query($forsubfield)){
                            echo "
                            <div class = 'sfer'>
                                <label name = 'prof_obl1'><input name = 'prof_obl3' value = '$rowfield[1]' class = 'prof3' type = 'radio'/><text class = 'prof'>$rowfield[1]</text></label>
                                <ul class = 'prof1'>
                            ";
                                while($rowsubfield = $resultsubfield->fetch_row()){
                                    echo "<li><label><input name = 'prof_obl2[]' value = '$rowsubfield[0]' class = 'prof2' type = 'checkbox' required/>$rowsubfield[0]</label></li>";
                                }
                            echo "
                                </ul>
                            </div>
                            ";
                        }
                    }
                }
            echo "</div><br>";

            echo "<div class = 'addresToETT'>";
                echo "<div class = 'addresToE'>";
                    echo "<text>Тип занятости</text>";
                    echo "<br>";
                    echo "
                    <div>
                        <label><input type = 'checkbox' name = 'chToE[]' value = 'Полная занятость'></input><text>Полная занятость</text></label><br>
                        <label><input type = 'checkbox' name = 'chToE[]' value = 'Частичная занятость'></input><text>Частичная занятость</text></label><br>
                        <label><input type = 'checkbox' name = 'chToE[]' value = 'Проектная/временная работа'></input><text>Проектная/временная работа</text></label><br>
                        <label><input type = 'checkbox' name = 'chToE[]' value = 'Волонтёрство'></input><text>Волонтёрство</text></label><br>
                        <label><input type = 'checkbox' name = 'chToE[]' value = 'Стажировка'></input><text>Стажировка</text></label>
                    </div>
                    ";
                echo "</div>";

                echo "<div class = 'addresTT'>";
                    echo "<text>График работы</text>";
                    echo "<br>";
                    echo "
                    <div>
                        <label><input type = 'checkbox' name = 'chTT[]' value = 'Полный день'></input><text>Полный день</text></label><br>
                        <label><input type = 'checkbox' name = 'chTT[]' value = 'Сменный график'></input><text>Сменный график</text></label><br>
                        <label><input type = 'checkbox' name = 'chTT[]' value = 'Гибкий график'></input><text>Гибкий график</text></label><br>
                        <label><input type = 'checkbox' name = 'chTT[]' value = 'Удалённая работа'></input><text>Удалённая работа</text></label><br>
                    </div>
                    ";
                echo "</div>";
            echo "</div>";

            echo "<br><br><br><br><br><br><br><br>";
            echo "<center>";
                echo "<text class = 'text3'>Образование</text>";
                echo "<br>";
                echo "<text class = 'plusedu' onclick = 'addedu()'>добавить</text>";
                echo "<br>";
                echo "<div class = 'edu'></div>";
            echo "</center>";
            
            echo "<br><br><br>";
            echo "<center>";
                echo "<text class = 'text3'>Курсы</text>";
                echo "<br>";
                echo "<text class = 'pluscurs' onclick = 'addcurs()'>добавить</text>";
                echo "<br>";
                echo "<div class = 'curs'></div>";
                echo "<br>";
            echo "</center>";

            echo "<br><br><br>";
            echo "<center>";
                echo "<text class = 'text3'>Опыт работы</text>";
                echo "<br>";
                echo "<text class = 'plusjob' onclick = 'addjob()'>добавить</text>";
                echo "<br>";
                echo "<div class = 'job'></div>";
                echo "<br>";
            echo "</center>";

            echo "<br>";
            echo "<div class = 'addrescontact'>";
                echo "<text>Контактная информация</text>";
                echo "<br>";
                echo "<input class = 'addrescontactinpt' name = 'name' type = 'text' placeholder = 'Ваше имя' autocomplete = 'off' required maxlength='200'/>";
                echo "<br>";
                echo "<input class = 'addrescontactinpt' name = 'phone' type = 'text' placeholder = 'Контактный номер' autocomplete = 'off' required maxlength='50'/>";
                echo "<br>";
                echo "<input class = 'addrescontactinpt' name = 'email' type = 'mail' placeholder = 'Почта' autocomplete = 'off' required maxlength='200'/>";
            echo "</div>";

            echo "<br><br><br><input class = 'addressbmt' type = 'submit' value = 'Создать резюме' name = 'addresum'/>";

            echo "</form>";
        echo "</div>";
    echo "</body>";
}
else if($_COOKIE['type'] == 'vac')
{
    echo "<div class = 'indentation'>";
    echo "<text class = 'hand' onclick = \"location.href = 'account.php'\">Необходимо войти на аккаунт пользователя</text>";
    echo "</div>";
}
else
{
    echo "<div class = 'indentation'>";
    echo "<text class = 'hand' onclick = \"location.href = 'login.php'\">Необходимо зарегистрировать или войти на аккаунт пользователя</text>";
    echo "</div>";
}
 
$link->close();

?>

