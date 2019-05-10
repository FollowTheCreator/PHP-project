<?php
$host = 'localhost:3306'; 
$database = 'findjob';
$user = 'root';
$password = '1111';
 
$link = new mysqli($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));


function generateCode($length=6) {

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";

    $code = "";

    $clen = strlen($chars) - 1;  
    while (strlen($code) < $length) {

            $code .= $chars[mt_rand(0,$clen)];  
    }

    return $code;

}

function login($llogin, $lpass){
    global $link;
    $query = $link->query("SELECT id, pass, login FROM user_resume WHERE login='$llogin' LIMIT 1");
    $query1 = $link->query("SELECT id, pass, login FROM company WHERE login='$llogin' LIMIT 1");
    if($query->num_rows > 0)
    {
        $data = $query->fetch_assoc();

        if($data['pass'] === $lpass)
        {
            $hash = md5(generateCode(10));
            $link->query("UPDATE user_resume SET hash='".$hash."' WHERE id=".$data['id']);

            setcookie("id", $data['id'], time()+60*60*24*30);
            setcookie("login", $data['login'], time()+60*60*24*30);
            setcookie("hash", $hash, time()+60*60*24*30);
            setcookie("type", 'res', time()+60*60*24*30);

            header("Location: main.php"); 
            exit();
        }
        else
        {
            echo "Вы ввели неправильный логин/пароль";
        }
    }
    else if($query1->num_rows > 0)
    {
        $data = $query1->fetch_assoc();

        if($data['pass'] === $lpass)
        {
            $hash = md5(generateCode(10));
            $link->query("UPDATE company SET hash='".$hash."' WHERE id=".$data['id']);

            setcookie("id", $data['id'], time()+60*60*24*30);
            setcookie("login", $data['login'], time()+60*60*24*30);
            setcookie("hash", $hash, time()+60*60*24*30);
            setcookie("type", 'vac', time()+60*60*24*30);

            header("Location: main.php"); 
            exit();
        }
        else
        {
            echo "Вы ввели неправильный логин/пароль";
        }
    }
    else echo "Вы ввели неправильный логин/пароль";
}



if(isset($_POST['submit1']))
{
    login($_POST['login'], md5(md5($_POST['password'])));
}



if(isset($_POST['submit2']))
{
    $err = array();
    if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
    {
        $err[] = "Логин может состоять только из букв английского алфавита и цифр";
    }

    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
    {
        $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
    }

    $query = $link->query("SELECT id FROM user_resume WHERE login='".$_POST['login']."'");
    $query1 = $link->query("SELECT id FROM company WHERE login='".$_POST['login']."'");
    if($query->num_rows > 0 || $query1->num_rows > 0)
    {
        $err[] = "Пользователь с таким логином уже существует в базе данных";
    }

    if(count($err) == 0)
    {
        $login = $_POST['login'];
        $password = md5(md5(trim($_POST['password'])));

        $link->query("INSERT INTO user_resume SET login='".$login."', pass='".$password."'");

        login($login, $password);
    }
    else print_r($err);
}

if(isset($_POST['submit3']))
{
    $err = array();
    if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
    {
        $err[] = "Логин может состоять только из букв английского алфавита и цифр";
    }

    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
    {
        $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
    }

    $query = $link->query("SELECT id FROM user_resume WHERE login='".$_POST['login']."'");
    $query1 = $link->query("SELECT id FROM company WHERE login='".$_POST['login']."'");
    if($query->num_rows > 0 || $query1->num_rows > 0)
    {
        $err[] = "Пользователь с таким логином уже существует в базе данных";
    }

    if(count($err) == 0)
    {
        $login = $_POST['login'];
        $namecomp = $_POST['namecomp'];
        $password = md5(md5(trim($_POST['password'])));

        $link->query("INSERT INTO company SET login='".$login."', pass='".$password."', name='".$namecomp."'");

        login($login, $password);
    }
    else print_r($err);
}
 
$link->close();
 
require_once 'header.php';

?>

<link rel="stylesheet" type="text/css" href="style.css"/>
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<script src="js/script.js" type="text/javascript"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>

<div class = "mainlogreg">
    <div class = 'logreg'>

        <div class = 'formlogin'>
            <form method="POST">
                <input class = "inpt pos1" size = "30" name="login" type="text" placeholder = "Логин"><br>
                <input class = "inpt pos2" size = "30" name="password" type="password" placeholder = "Пароль"><br>
                <input class = "sbmt pos3" name="submit1" type="submit" value="Войти">
            </form>
        </div>

        <div class = "formreg">
            <div class = "formreguser">
                <form method="POST">
                    <input class = "inpt pos4" size = "30" name="login" type="text" placeholder = "Логин" maxlength = "30"><br>
                    <input class = "inpt pos5" size = "30" name="password" type="password" placeholder = "Пароль" minlength = "3"><br>
                    <input class = "sbmt pos6" name="submit2" type="submit" value="Зарегистрироваться">
                </form>
            </div>
            <div class = "logdelimeter"></div>
            <div class = "formregcom">
                <form method="POST">
                    <input class = "inpt pos7" size = "30" name="login" type="text" placeholder = "Логин" maxlength = "30"><br>
                    <input class = "inpt pos8" size = "30" name="namecomp" type="text" placeholder = "Название компании"><br>
                    <input class = "inpt pos9" size = "30" name="password" type="password" placeholder = "Пароль" minlength = "3"><br>
                    <input class = "sbmt pos10" name="submit3" type="submit" value="Зарегистрировать компанию">
                </form>
            </div>
        </div>

        <div class = "sliderlogin">
            <div class = "regbutton" onclick = "slidelogin(this)">
                РЕГИСТРАЦИЯ
            </div>
        </div>

    </div>
</div>