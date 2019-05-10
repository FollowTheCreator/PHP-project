<?php
require_once 'header.php';
require_once 'connection.php'; 
echo '<script src="js/yandex.js" type="text/javascript"></script>';

$link = new mysqli($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));

$currid = $_COOKIE['currid'];
if($_GET['vacid'])
    $nowid = $_GET['vacid'];
else $nowid = $currid;

if($_COOKIE['type'] == 'vac')
{
    $forfield = "
    select
        activity_of_advertisement.id,
        activity_of_advertisement.name
    from
        activity_of_advertisement
    ";
    $queryupd = "
    select distinct
        vacancy.header,
        vacancy.description,
        vacancy.experience,
        vacancy.salary,
        vacancy.currency,
        vacancy.key_skill,
        contact_info_vacancy.name,
        contact_info_vacancy.phone,
        contact_info_vacancy.email,
        activity_of_advertisement.name,
        address.country,
        address.city,
        address.street,
        address.house,
        address.point
    from
        vacancy
        join contact_info_vacancy on contact_info_vacancy.id = vacancy.contact
        join activity_of_advertisement_vacancy on activity_of_advertisement_vacancy.vacancy = vacancy.id
        join sub_activity_of_advertisement on sub_activity_of_advertisement.id = activity_of_advertisement_vacancy.activity_of_advertisement
        join activity_of_advertisement on activity_of_advertisement.id = sub_activity_of_advertisement.parent_activity_of_advertisement
        join address on address.id = vacancy.address
    where 
        vacancy.id = $nowid
    ";
    $queryupd1 = "
    select 
        type_of_employment_vacancy.type
    from
        type_of_employment_vacancy
        join union_type_of_employment_vacancy on union_type_of_employment_vacancy.type = type_of_employment_vacancy.id
        join vacancy on vacancy.id = union_type_of_employment_vacancy.vacancy
    where
        vacancy.id = $nowid
    ";
    if($result1 = $link->query($queryupd1)){
        $arrToE = array();
        while($row1 = $result1->fetch_row()){
            array_push($arrToE, $row1[0]);
        }
    }
    $queryupd2 = "
    select 
        timetable_vacancy.type
    from
        timetable_vacancy
        join union_timetable_vacancy on union_timetable_vacancy.type = timetable_vacancy.id
        join vacancy on vacancy.id = union_timetable_vacancy.vacancy
    where
        vacancy.id = $nowid
    ";
    if($result2 = $link->query($queryupd2)){
        $arrTT = array();
        while($row2 = $result2->fetch_row()){
            array_push($arrTT, $row2[0]);
        }
    }
    $queryupd3 = "
    select
        sub_activity_of_advertisement.sub_name
    from
        vacancy
        join activity_of_advertisement_vacancy on activity_of_advertisement_vacancy.vacancy = vacancy.id
        join sub_activity_of_advertisement on sub_activity_of_advertisement.id = activity_of_advertisement_vacancy.activity_of_advertisement
    where 
        vacancy.id = $nowid
    ";
    if($result3 = $link->query($queryupd3)){
        $arrAoA = array();
        while($row3 = $result3->fetch_row()){
            array_push($arrAoA, $row3[0]);
        }
    }
    $forupd = "
    select
        address.id,
        contact_info_vacancy.id
    from
        vacancy
        join contact_info_vacancy on contact_info_vacancy.id = vacancy.contact
        join address on address.id = vacancy.address
    where
        vacancy.id = ".$currid;
    if($_GET['updvacan'])
    {
        $result4 = $link->query($forupd);
        $row4 = $result4->fetch_row();
        $queryaddress = "
        update 
            address 
        set
            country = '".$_GET['country']."', 
            city = '".$_GET['city']."', 
            street = '".$_GET['street']."', 
            house = '".$_GET['house']."', 
            point = '".$_GET['coord']."'
        where
            id = $row4[0]
        ";
        $link->query($queryaddress);
    

        $querycontact = "
        update
            contact_info_vacancy 
        set
            name = '".$_GET['name']."', 
            phone = '".$_GET['phone']."', 
            email = '".$_GET['email']."'
        where
            id = $row4[1]
        ";
        $link->query($querycontact);

        if($_GET['experience']) $exp = $_GET['experience'];
        else $exp = null;
        if($_GET['salary']) {$salary = $_GET['salary']; $currency = $_GET['currency'];}
        else {$salary = null; $currency = null;}
        if($_GET['keyskill']) $keyskill = implode('-/-', $_GET['keyskill']);
        else $keyskill = null;
        $queryvacancy = "
        update 
            vacancy 
        set
            experience = '".$exp."', 
            header = '".$_GET['header']."', 
            description = '".$_GET['description']."', 
            date_of_publication = '".date('Y-m-d')."', 
            salary = '".$salary."', 
            key_skill = '".$keyskill."', 
            currency = '".$currency."'
        where
            id = ".$currid;

        $link->query($queryvacancy);

        $link->query("
        delete 
        from
            union_type_of_employment_vacancy 
        where
            vacancy = ".$currid);
        if($_GET['chToE'])
        {
            foreach($_GET['chToE'] as $value)
            {
                $queryToE = "
                insert into 
                    union_type_of_employment_vacancy (type, vacancy)
                select f.id, ".$currid."
                from
                    (select id from type_of_employment_vacancy where type = '".$value."') f
                ";
                $link->query($queryToE);
            }
        }

        $link->query("
        delete 
        from
            union_timetable_vacancy 
        where
            vacancy = ".$currid);
        if($_GET['chTT'])
        {
            foreach($_GET['chTT'] as $value)
            {
                $queryTT = "
                insert into 
                    union_timetable_vacancy (type, vacancy)
                select f.id, ".$currid."
                from
                    (select id from timetable_vacancy where type = '".$value."') f
                ";
                $link->query($queryTT);
            }
        }

        $link->query("
        delete 
        from
            activity_of_advertisement_vacancy 
        where
            vacancy = ".$currid);
        if($_GET['prof_obl2'])
        {
            foreach($_GET['prof_obl2'] as $value)
            {
                $queryprof = "
                insert into 
                    activity_of_advertisement_vacancy (vacancy, activity_of_advertisement)
                select $currid , f.id
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
        echo "<script>document.location.href = 'http://findtofind/account.php'</script>";
    }
    if($result = $link->query($queryupd))
    {
        $row = $result->fetch_row();
        echo "<body class = 'showback2'>";
        echo "<div class = 'showpage'>";
        echo "<text class = 'addheader'>Редактирование вакансии</text>";
        echo "<br><br><br>";
        echo "<form method = 'GET'>";

        echo "<br><br><input class = 'addrespost' name = 'header' type = 'text' placeholder = 'Должность' autocomplete = 'off' required maxlength='100' value = '$row[0]'/>";
        echo "<br>";

        echo "<br><br><input class = 'addresslr' name = 'salary' type = 'text' placeholder = 'Зарплата' autocomplete = 'off' value = '$row[3]'/>";
        echo "
            <select class = 'addrescrrncy' name = 'currency'>
                <option";
                if($row[4] == "BYN") echo " selected";
                echo "><text>BYN</text></option>
                <option";
                if($row[4] == "USD") echo " selected";
                echo "><text>USD</text></option>
                <option";
                if($row[4] == "EUR") echo " selected";
                echo "><text>EUR</text></option>";
        echo "</select>";
        echo "<br><br><br><br><br>";

        echo "<textarea class = 'addresabout' name = 'description' type = 'textarea' placeholder = 'Описание...' required maxlength='10000'>$row[1]</textarea>";
        echo "<br><br>";

        echo "<div class = 'addreskeyskill'>";
            echo "<text>Ключевые навыки</text>";
            echo "<br>";
            echo "<text class = 'plus' onclick = 'addkey()'>добавить</text>";
            echo "<br>";
            echo "<div class = 'contkey'>";
            if($row[5] != "")
            {    
                foreach(explode("-/-", $row[5]) as $value){
                    echo "<div class = 'inp'><input class = 'forkey' type = 'text' name = 'keyskill[]' onblur = 'addkey1(this)' maxlength='32' value = '$value'></input><text onclick = 'del(this)' class = 'hand'>X</text></div>";
                }
            }
            echo "</div>";
        echo "</div><br><br>";

        echo "<div class = 'addvacexp'>";
            echo "<text>Опыт</text>";
            echo "<br>";
            echo "<text>От </text><input class = 'inptexp' name = 'experience' type = 'text' placeholder = 'От...' autocomplete = 'off' value = '$row[2]'/><text> лет</text>";
        echo "</div><br><br>";

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
                        <label name = 'prof_obl1'><input name = 'prof_obl3' value = '$rowfield[1]' class = 'prof3' type = 'radio'";
                        if($rowfield[1] == $row[9])
                        { 
                            echo " checked";
                            echo "/><text class = 'prof'>$rowfield[1]</text></label>
                            <ul class = 'prof1'>
                        ";
                            while($rowsubfield = $resultsubfield->fetch_row()){
                                echo "<li><label><input name = 'prof_obl2[]' value = '$rowsubfield[0]' class = 'prof2' type = 'checkbox' required";
                                if(in_array($rowsubfield[0], $arrAoA)) echo " checked";
                                echo "/>$rowsubfield[0]</label></li>";
                            }
                        }
                        else
                        {
                            echo "/><text class = 'prof'>$rowfield[1]</text></label>
                            <ul class = 'prof1'>
                        ";
                            while($rowsubfield = $resultsubfield->fetch_row()){
                                echo "<li><label><input name = 'prof_obl2[]' value = '$rowsubfield[0]' class = 'prof2' type = 'checkbox' required/>$rowsubfield[0]</label></li>";
                            }
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
                    <label><input type = 'checkbox' name = 'chToE[]' value = 'Полная занятость'";
                    if(in_array("полная занятость", $arrToE)) echo " checked";
                    echo "></input><text>Полная занятость</text></label><br>
                    <label><input type = 'checkbox' name = 'chToE[]' value = 'Частичная занятость'";
                    if(in_array("частичная занятость", $arrToE)) echo " checked";
                    echo "></input><text>Частичная занятость</text></label><br>
                    <label><input type = 'checkbox' name = 'chToE[]' value = 'Проектная/временная работа'";
                    if(in_array("проектная/временная работа", $arrToE)) echo " checked";
                    echo" ></input><text>Проектная/временная работа</text></label><br>
                    <label><input type = 'checkbox' name = 'chToE[]' value = 'Волонтёрство'";
                    if(in_array("волонтёрство", $arrToE)) echo " checked";
                    echo "></input><text>Волонтёрство</text></label><br>
                    <label><input type = 'checkbox' name = 'chToE[]' value = 'Стажировка'";
                    if(in_array("стажировка", $arrToE)) echo " checked";
                    echo "></input><text>Стажировка</text></label>
                </div>
                ";
            echo "</div>";

            echo "<div class = 'addresTT'>";
                echo "<text>График работы</text>";
                echo "<br>";
                echo "
                <div>
                    <label><input type = 'checkbox' name = 'chTT[]' value = 'Полный день'";
                    if(in_array("полный день", $arrTT)) echo " checked";
                    echo "></input><text>Полный день</text></label><br>
                    <label><input type = 'checkbox' name = 'chTT[]' value = 'Сменный график'";
                    if(in_array("сменный график", $arrTT)) echo " checked";
                    echo "></input><text>Сменный график</text></label><br>
                    <label><input type = 'checkbox' name = 'chTT[]' value = 'Гибкий график'";
                    if(in_array("гибкий график", $arrTT)) echo " checked";
                    echo "></input><text>Гибкий график</text></label><br>
                    <label><input type = 'checkbox' name = 'chTT[]' value = 'Удалённая работа'";
                    if(in_array("удалённая работа", $arrTT)) echo " checked";
                    echo "></input><text>Удалённая работа</text></label><br>
                </div>
                ";
            echo "</div>";
        echo "</div>";

        echo "<br><br><br><br><br><br><br><br>";

        echo "<div class = 'addvacaddress'>";
            echo "<text>Адрес вакансии</text>";
            echo "<br>";
            $rowXY = explode(",", $row[14]);
            $rowX = $rowXY[0];
            $rowY = $rowXY[1];
            echo "<div id = 'map'></div>";
            echo '<script type="text/javascript">checkloc1();setCenter('.$rowX.','.$rowY.');</script>';
            echo "<input class = 'addvaccountry' name = 'country' type = 'text' placeholder = 'Страна' autocomplete = 'off' required maxlength='100' value = '$row[10]'/>";
            echo "<br>";
            echo "<input class = 'addvaccity' name = 'city' type = 'text' placeholder = 'Город' autocomplete = 'off' required maxlength='100' value = '$row[11]'/>";
            echo "<br>";
            echo "<input class = 'addvacstreet' name = 'street' type = 'text' placeholder = 'Улица' autocomplete = 'off' required maxlength='100' value = '$row[12]'/>";
            echo "<br>";
            echo "<input class = 'addvachouse' name = 'house' type = 'text' placeholder = 'Дом' autocomplete = 'off' required maxlength='10' value = '$row[13]'/>";
            echo "<input name = 'coord' type = 'text' autocomplete = 'off' style = 'display:none;' required value = '$row[14]'/>";
        echo "</div>";

        echo "<div class = 'addrescontact'>";
            echo "<text>Контактная информация</text>";
            echo "<br>";
            echo "<input class = 'addrescontactinpt' name = 'name' type = 'text' placeholder = 'Ваше имя' autocomplete = 'off' required maxlength='200' value = '$row[6]'/>";
            echo "<br>";
            echo "<input class = 'addrescontactinpt' name = 'phone' type = 'text' placeholder = 'Контактный номер' autocomplete = 'off' required maxlength='50' value = '$row[7]'/>";
            echo "<br>";
            echo "<input class = 'addrescontactinpt' name = 'email' type = 'mail' placeholder = 'Почта' autocomplete = 'off' required maxlength='200' value = '$row[8]'/>";
        echo "</div>";

        echo "<br><br><br><input class = 'updvacsbmt' type = 'submit' onclick = 'setCookie($nowid)' value = 'Обновить вакансию' name = 'updvacan'/>";

        echo "</form>";
        echo "</div>";
        echo "</body>";
    }
}

$link->close();

?>