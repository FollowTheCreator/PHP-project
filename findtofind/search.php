<?php
require_once 'header.php';
require_once 'connection.php'; 
 
$link = new mysqli($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));

$curr = $_GET['now'];

$forfield = "
select
    activity_of_advertisement.id,
    activity_of_advertisement.name
from
    activity_of_advertisement
";

if ($curr == 'res')
{
    echo "<body class = 'backsearch'>";
        echo "<div class = 'searchpage'>";
            echo "<form method = 'POST' action = 'resume.php'>";
                echo "<div>";
                    echo "<input class = 'searchmainword' name = 'search' type = 'text' autocomplete = 'off' placeholder = 'Ключевые слова'/>";
                echo "</div>";
                echo "<div class = 'searchfield'>";
                echo "<text>Профессиональная область:</text>";
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
                            <div class = 'sfers'>
                                <input name = 'prof_obl1s[]' value = '$rowfield[1]' class = 'prof3s' type = 'checkbox'/><text class = 'profs'>$rowfield[1]</text>
                                <ul class = 'prof1s'>
                            ";
                                while($rowsubfield = $resultsubfield->fetch_row()){
                                    echo "<li><label><input name = 'prof_obl2s[]' value = '$rowsubfield[0]' class = 'prof2s' type = 'checkbox'/>$rowsubfield[0]</label></li>";
                                }
                            echo "
                                </ul>
                            </div>
                            ";
                        }
                    }
                }
                echo "</div>";
                echo "<div>";
                    echo "<input class = 'searchkeyskill' name = 'key_skills' type = 'text' autocomplete = 'off' placeholder = 'Ключевые навыки'/>";
                echo "</div>";
                echo "<div class = 'searchgender'>";
                echo "<text>Пол: </text>";
                echo "
                <div>
                    <label><input type = 'radio' name = 'gender' value = 'Мужчина'>Мужчина</input></label><br>
                    <label><input type = 'radio' name = 'gender' value = 'Женщина'>Женщина</input></label><br>
                </div>
                ";
                echo "</div>";
                echo "<div class = 'searchage'>";
                echo "<text>Возраст: </text>";
                echo "<input class = 'searchsince' name = 'from' type = 'text' placeholder = 'От' autocomplete = 'off'/>
                      <input class = 'searchbefore' name = 'until' type = 'text' placeholder = 'До' autocomplete = 'off'/>";
                echo "</div>";
                echo "<div class = 'searchsalary'>";
                    echo "
                    <div>
                        <input class = 'searchsalaryinpt' name = 'zarpl' type = 'text' autocomplete = 'off' placeholder = 'Зарплата до...'/>
                        <select class = 'searchsalarycurr' name = 'zarplcurr'>
                            <option selected><text>BYN</text></option>
                            <option><text>USD</text></option>
                            <option><text>EUR</text></option>
                        </select>
                    </div>
                    ";
                echo "</div>";

                echo "<div class = 'searchexp'>";
                    echo "<text>Требуемый опыт работы: </text>";
                    echo "
                    <div>
                        <label><input type = 'radio' name = 'exper' value = 'nodiff' checked>Без разницы</input></label><br>
                        <label><input type = 'radio' name = 'exper' value = 'no'>Без опыта</input></label><br>
                        <label><input type = 'radio' name = 'exper' value = 'one'>Более 1 года</input></label><br>
                        <label><input type = 'radio' name = 'exper' value = 'three'>Более 3 лет</input></label><br>
                        <label><input type = 'radio' name = 'exper' value = 'five'>Более 5 лет</input></label>
                    </div>
                    ";
                echo "</div>";
                echo "<div class = 'searchToE'>";
                echo "<text>Тип занятости: </text>";
                echo "
                <div>
                    <label><input type = 'checkbox' name = 'chToE[]' value = 'Полная занятость'>Полная занятость</input></label><br>
                    <label><input type = 'checkbox' name = 'chToE[]' value = 'Частичная занятость'>Частичная занятость</input></label><br>
                    <label><input type = 'checkbox' name = 'chToE[]' value = 'Проектная/временная работа'>Проектная/временная работа</input></label><br>
                    <label><input type = 'checkbox' name = 'chToE[]' value = 'Волонтёрство'>Волонтёрство</input></label><br>
                    <label><input type = 'checkbox' name = 'chToE[]' value = 'Стажировка'>Стажировка</input></label>
                </div>
                ";
                echo "</div>";
                echo "<div class = 'searchTT'>";
                    echo "<text>График работы: </text>";
                    echo "
                    <div>
                        <label><input type = 'checkbox' name = 'chTT[]' value = 'Полный день'>Полный день</input></label><br>
                        <label><input type = 'checkbox' name = 'chTT[]' value = 'Сменный график'>Сменный график</input></label><br>
                        <label><input type = 'checkbox' name = 'chTT[]' value = 'Гибкий график'>Гибкий график</input></label><br>
                        <label><input type = 'checkbox' name = 'chTT[]' value = 'Удалённая работа'>Удалённая работа</input></label><br>
                    </div>
                    ";
                echo "</div>";
                echo "<div class = 'searchsort'>";
                    echo "<text>Сортировать: </text>";
                    echo "
                    <div>
                        <label><input type = 'radio' name = 'sort' value = 'new' checked>Сначала новые</input></label><br>
                        <label><input type = 'radio' name = 'sort' value = 'old'>Сначала старые</input></label><br>
                        <label><input type = 'radio' name = 'sort' value = 'high'>По убыванию зарплат</input></label><br>
                        <label><input type = 'radio' name = 'sort' value = 'low'>По возрастанию зарплат</input></label><br>
                    </div>
                    ";
                echo "</div>";
                echo "<div>";
                    echo "<input class = 'searchsbmt' type = 'submit' value = 'Поиск'/>";
                echo "</div>";
                echo "<div class = 'searchline1'></div><div class = 'searchline2'></div><div class = 'searchline3'></div>";
            echo "</form>";
        echo "</div>";
    echo "</body>";
}
else if ($curr == 'vac')
{
    echo "<body class = 'backsearch'>";
        echo "<div class = 'searchpage'>";
            echo "<form method = 'POST' action = 'vacancy.php'>";
                echo "<div>";
                    echo "<input class = 'searchmainword' name = 'search' type = 'text' autocomplete = 'off' placeholder = 'Ключевые слова'/>";
                echo "</div>";
                echo "<div class = 'searchfield'>";
                echo "<text>Профессиональная область:</text>";
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
                            <div class = 'sfers'>
                                <input name = 'prof_obl1s[]' value = '$rowfield[1]' class = 'prof3s' type = 'checkbox'/><text class = 'profs'>$rowfield[1]</text>
                                <ul class = 'prof1s'>
                            ";
                                while($rowsubfield = $resultsubfield->fetch_row()){
                                    echo "<li><label><input name = 'prof_obl2s[]' value = '$rowsubfield[0]' class = 'prof2s' type = 'checkbox'/>$rowsubfield[0]</label></li>";
                                }
                            echo "
                                </ul>
                            </div>
                            ";
                        }
                    }
                }
                echo "</div>";
                echo "<div>";
                    echo "<input class = 'searchkeyskill' name = 'key_skills' type = 'text' autocomplete = 'off' placeholder = 'Ключевые навыки'/>";
                echo "</div>";
                echo "<div class = 'searchregion'>";
                    echo "<text>Регион: </text>";
                    echo "
                    <div>
                        <input name = 'reg1' value = 'РБ' class = 'searchprof3' type = 'checkbox'/><text class = 'searchprof'>РБ</text>
                        <ul class = 'searchprof1'>
                            <li><label><input value = 'Минск' name = 'reg2[]' class = 'searchprof2' type = 'checkbox'/>Минск</label></li>
                            <li><label><input value = 'Брест' name = 'reg2[]' class = 'searchprof2' type = 'checkbox'/>Брест</label></li>
                            <li><label><input value = 'Витебск' name = 'reg2[]' class = 'searchprof2' type = 'checkbox'/>Витебск</label></li>
                            <li><label><input value = 'Гомель' name = 'reg2[]' class = 'searchprof2' type = 'checkbox'/>Гомель</label></li>
                            <li><label><input value = 'Гродно' name = 'reg2[]' class = 'searchprof2' type = 'checkbox'/>Гродно</label></li>
                            <li><label><input value = 'Могилев' name = 'reg2[]' class = 'searchprof2' type = 'checkbox'/>Могилев</label></li>
                        </ul>
                    </div>
                    ";
                echo "</div>";
                echo "<div class = 'searchsalary'>";
                    echo "
                    <div>
                        <input class = 'searchsalaryinpt' name = 'zarpl' type = 'text' autocomplete = 'off' placeholder = 'Зарплата от...'/>
                        <select class = 'searchsalarycurr' name = 'zarplcurr'>
                            <option selected><text>BYN</text></option>
                            <option><text>USD</text></option>
                            <option><text>EUR</text></option>
                        </select>
                    </div>
                    ";
                echo "</div>";
                echo "<div>";
                    echo "<input class = 'searchcompany' name = 'company' type = 'text' autocomplete = 'off' placeholder = 'Название компании'/>";
                echo "</div>";
                echo "<div class = 'searchexp'>";
                    echo "<text>Требуемый опыт работы: </text>";
                    echo "
                    <div>
                        <label><input type = 'radio' name = 'exper' value = 'nodiff' checked>Без разницы</input></label><br>
                        <label><input type = 'radio' name = 'exper' value = 'no'>Без опыта</input></label><br>
                        <label><input type = 'radio' name = 'exper' value = 'three'>До 3 лет</input></label><br>
                        <label><input type = 'radio' name = 'exper' value = 'bfive'>До 5 лет</input></label><br>
                        <label><input type = 'radio' name = 'exper' value = 'afive'>Более 5 лет</input></label>
                    </div>
                    ";
                echo "</div>";
                echo "<div class = 'searchToE'>";
                    echo "<text>Тип занятости: </text>";
                    echo "
                    <div>
                        <label><input type = 'checkbox' name = 'chToE[]' value = 'Полная занятость'>Полная занятость</input></label><br>
                        <label><input type = 'checkbox' name = 'chToE[]' value = 'Частичная занятость'>Частичная занятость</input></label><br>
                        <label><input type = 'checkbox' name = 'chToE[]' value = 'Проектная/временная работа'>Проектная/временная работа</input></label><br>
                        <label><input type = 'checkbox' name = 'chToE[]' value = 'Волонтёрство'>Волонтёрство</input></label><br>
                        <label><input type = 'checkbox' name = 'chToE[]' value = 'Стажировка'>Стажировка</input></label>
                    </div>
                    ";
                echo "</div>";
                echo "<div class = 'searchTT'>";
                    echo "<text>График работы: </text>";
                    echo "
                    <div>
                        <label><input type = 'checkbox' name = 'chTT[]' value = 'Полный день'>Полный день</input></label><br>
                        <label><input type = 'checkbox' name = 'chTT[]' value = 'Сменный график'>Сменный график</input></label><br>
                        <label><input type = 'checkbox' name = 'chTT[]' value = 'Гибкий график'>Гибкий график</input></label><br>
                        <label><input type = 'checkbox' name = 'chTT[]' value = 'Удалённая работа'>Удалённая работа</input></label><br>
                    </div>
                    ";
                echo "</div>";
                echo "<div class = 'searchsort'>";
                    echo "<text>Сортировать: </text>";
                    echo "
                    <div>
                        <label><input type = 'radio' name = 'sort' value = 'new' checked>Сначала новые</input></label><br>
                        <label><input type = 'radio' name = 'sort' value = 'old'>Сначала старые</input></label><br>
                        <label><input type = 'radio' name = 'sort' value = 'high'>По убыванию зарплат</input></label><br>
                        <label><input type = 'radio' name = 'sort' value = 'low'>По возрастанию зарплат</input></label><br>
                    </div>
                    ";
                echo "</div>";
                echo "<div>";
                    echo "<input class = 'searchsbmt' type = 'submit' value = 'Поиск'/>";
                echo "</div>";
                echo "<div class = 'searchline1'></div><div class = 'searchline2'></div><div class = 'searchline3'></div>";
            echo "</form>";
        echo "</div>";
    echo "</body>";
}
else 
{
    echo "<script>document.location = 'company.php'</script>";
}
 
$link->close();

?>
