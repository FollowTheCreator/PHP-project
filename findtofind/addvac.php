<?php

require_once 'header.php';
require_once 'connection.php'; 
echo '<script src="js/yandex.js" type="text/javascript"></script>';
 
$link = new mysqli($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));

if($_COOKIE['type'] == 'vac')
{
    $forfield = "
    select
        activity_of_advertisement.id,
        activity_of_advertisement.name
    from
        activity_of_advertisement
    ";
    if($_GET['addvacan'])
    {
        $queryaddress = "
        insert into 
            address (country, city, street, house, point) 
        values 
            ('".$_GET['country']."', '".$_GET['city']."', '".$_GET['street']."', '".$_GET['house']."', '".$_GET['coord']."')
        ";
        $link->query($queryaddress);
        $lastaddress = $link->insert_id;

        $querycontact = "
        insert into 
            contact_info_vacancy (name, phone, email)
        values 
            ('".$_GET['name']."', '".$_GET['phone']."', '".$_GET['email']."')
        ";
        $link->query($querycontact);
        $lastcontact = $link->insert_id;

        if($_GET['experience']) $exp = $_GET['experience'];
        else $exp = null;
        if($_GET['salary']) {$salary = $_GET['salary']; $currency = $_GET['currency'];}
        else {$salary = null; $currency = null;}
        if($_GET['keyskill']) $keyskill = implode('-/-', $_GET['keyskill']);
        else $keyskill = null;
        $queryvacancy = "
        insert into 
            vacancy (address, employer, experience, header, description, date_of_publication, salary, key_skill, currency, contact)
        values 
            ('".$lastaddress."', '".$_COOKIE['id']."', '".$exp."', '".$_GET['header']."', '".$_GET['description']."', '".date('Y-m-d')."', '".$salary."', '".$keyskill."', '".$currency."', '".$lastcontact."')
        ";
        $link->query($queryvacancy);
        $lastvacancy = $link->insert_id;

        if($_GET['chToE'])
        {
            foreach($_GET['chToE'] as $value)
            {
                $queryToE = "
                insert into 
                    union_type_of_employment_vacancy (type, vacancy)
                select f.id, ".$lastvacancy."
                from
                    (select id from type_of_employment_vacancy where type = '".$value."') f
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
                    union_timetable_vacancy (type, vacancy)
                select f.id, ".$lastvacancy."
                from
                    (select id from timetable_vacancy where type = '".$value."') f
                ";
                $link->query($queryTT);
            }
        }

        if($_GET['prof_obl2'])
        {
            foreach($_GET['prof_obl2'] as $value)
            {
                $queryprof = "
                insert into 
                    activity_of_advertisement_vacancy (vacancy, activity_of_advertisement)
                select $lastvacancy , f.id
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

    echo "<body class = 'showback1'>";
        echo "<div class = 'showpage'>";
            echo "<text class = 'addheader'>Открыть вакансию</text>";
            echo "<br><br><br>";
            echo "<form method = 'GET'>";

            echo "<br><br><input class = 'addrespost' name = 'header' type = 'text' placeholder = 'Должность' autocomplete = 'off' required maxlength='100'/>";
            echo "<br>";

            echo "<br><br><input class = 'addresslr' name = 'salary' type = 'text' placeholder = 'Зарплата' autocomplete = 'off'/>";
            echo "
                <select class = 'addrescrrncy' name = 'currency'>
                    <option selected><text>BYN</text></option>
                    <option><text>USD</text></option>
                    <option><text>EUR</text></option>
                </select>";
            echo "<br><br><br><br><br>";

            echo "<textarea class = 'addresabout' name = 'description' type = 'textarea' placeholder = 'Описание...' required maxlength='10000'></textarea>";
            echo "<br><br>";

            echo "<div class = 'addreskeyskill'>";
                echo "<text>Ключевые навыки</text>";
                echo "<br>";
                echo "<text class = 'plus' onclick = 'addkey()'>добавить</text>";
                echo "<br>";
                echo "<div class = 'contkey'></div>";
            echo "</div><br><br>";

            echo "<div class = 'addvacexp'>";
                echo "<text>Опыт</text>";
                echo "<input class = 'addvacexpinpt' name = 'experience' type = 'text' placeholder = 'От...' autocomplete = 'off'/><text>лет</text>";
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

            echo "<div class = 'addvacaddress'>";
                echo "<text>Адрес вакансии</text>";
                echo "<br>";
                echo "<div id = 'map'></div>";
                echo "<input class = 'addvaccountry' name = 'country' type = 'text' placeholder = 'Страна' autocomplete = 'off' required maxlength='100'/>";
                echo "<br>";
                echo "<input class = 'addvaccity' name = 'city' type = 'text' placeholder = 'Город' autocomplete = 'off' required maxlength='100'/>";
                echo "<br>";
                echo "<input class = 'addvacstreet' name = 'street' type = 'text' placeholder = 'Улица' autocomplete = 'off' required maxlength='100'/>";
                echo "<br>";
                echo "<input class = 'addvachouse' name = 'house' type = 'text' placeholder = 'Дом' autocomplete = 'off' required maxlength='10'/>";
                echo "<input name = 'coord' type = 'text' autocomplete = 'off' style = 'display:none;' required/>";
            echo "</div>";

            echo "<div class = 'addrescontact'>";
                echo "<text>Контактная информация</text>";
                echo "<br>";
                echo "<input class = 'addrescontactinpt' name = 'name' type = 'text' placeholder = 'Ваше имя' autocomplete = 'off' required maxlength='200'/>";
                echo "<br>";
                echo "<input class = 'addrescontactinpt' name = 'phone' type = 'text' placeholder = 'Контактный номер' autocomplete = 'off' required maxlength='50'/>";
                echo "<br>";
                echo "<input class = 'addrescontactinpt' name = 'email' type = 'mail' placeholder = 'Почта' autocomplete = 'off' required maxlength='200'/>";
            echo "</div>";

            echo "<br><br><br><input class = 'addvacsbmt' type = 'submit' value = 'Открыть вакансию' name = 'addvacan'/>";

            echo "</form>";
        echo "</div>";
    echo "</body>";
}
else if($_COOKIE['type'] == 'res')
{
    echo "<div class = 'indentation'>";
    echo "<text class = 'hand' onclick = \"location.href = 'account.php'\">Необходимо войти на аккаунт компании</text>";
    echo "</div>";
}
else
{
    echo "<div class = 'indentation'>";
    echo "<text class = 'hand' onclick = \"location.href = 'account.php'\">Необходимо зарегистрировать или войти на аккаунт компании</text>";
    echo "</div>";
}
 
$link->close();

?>
