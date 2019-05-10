<?php
echo '<div class = "header">';
    echo '<text class = "hand logo" onclick = "location.href = \'main.php\'"></text>';
    $user = $_COOKIE['login'];
    echo '
    <form id = "form1" class = "forsearch" method = "GET" action = "vacancy.php">
        <input name = "search" type = "text" class = "headersearch" placeholder = "Поиск..." autocomplete = "off"/>
        <select size = "1" onchange = "chng(this)" class = "headertype">
            <option value = "vacancy.php" class = "search.php?now=vac">Вакансии</option>
            <option value = "resume.php" class = "search.php?now=res">Резюме</option>
            <option value = "company.php" class = "search.php?now=com">Компании</option>
        </select>
        <input type = "submit" class = "headersearchsubmit" value = "&#128270"/>
        <text id = "srch" class = "hand extendedsearch" onclick = "locat(this)">
            Расширенный поиск
        </text>';
    if (!$user)
        echo '<text class = "hand headeruser" onclick = "location.href = \'login.php\'">Войти</text>';
    else 
    {
        echo '<div class = "headeruser">
                <div class = "hand" onclick = \'location.href = "account.php"\'><text>'.$user.'</text></div>';
        echo '</div>';
    }
    echo'</form>';
echo '</div>';
?>
