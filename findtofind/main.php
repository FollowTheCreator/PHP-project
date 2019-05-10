<?php

require_once 'connection.php'; 
 

?>
<link rel="stylesheet" type="text/css"href = "https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css"/>
<style media="screen">

* {
    margin: 0;
    padding: 0;
}
html,
body {
    height: 100%;
    overflow: hidden;
}

.inslide{
position:absolute;
top:50%;
left:50%;
}

#slides{
position: relative;
height: 100%;
padding: 0px;
margin: 0px;
list-style-type: none;
}

.slide{
position: absolute;
left: 0px;
top: 0px;
width: 100%;
height: 100%;
opacity: 0;
z-index: 1;
transition: opacity 1s ease;
}

.showing{
opacity: 1;
z-index: 2;
}

.slide{
padding: 40px;
box-sizing: border-box;
background-size: cover;
}


.slide:nth-of-type(1){
background-image: url('images/vacancy.jpg');
}


.slide:nth-of-type(2){
background-image: url('images/resume.jpg');
}


.slide:nth-of-type(3){
background-image: url('images/company.jpeg');
}

.controlprev{
position: absolute;
top: 45%;
left: 20px;
background-image: url("images/leftarrow.png");
background-size: cover;
height: 80px;
width: 40px;
z-index: 3;
cursor: pointer;
transition: 0.2s;
}

.controlprev:hover{
transform: scale(1.2);
}
.controlnext{
position: absolute;
top: 45%;
right: 20px;
height: 80px;
width: 40px;
background-image: url("images/rightarrow.png");
background-size: cover;
z-index: 3;
cursor: pointer;
transition: 0.2s;
}

.controlnext:hover{
transform: scale(1.2);
}

.container1{
position: absolute;
top:0;
left:0;
height:100%;
width:100%;
}

.mainbutton{
position:absolute;
color: white;
font-family: 'Raleway';
font-size: 80px;
user-select: none;
text-align: center;
cursor: pointer;
text-shadow: 0 0 10px black;
box-shadow: 0 0 10px 1px  #1E1E1E;
border: 3px #1E1E1E solid;
transition-duration: 0.3s;
}
.mainbutton:hover{
    background: rgba(0, 0, 0, 0.3);
    color: white;
}
.mainvac{
top: -150px;
left: calc(50% - 240px);
width: 480px;
}
.mainvacadd{
top: 50px;
left: calc(50% - 440px);
width: 880px;
}
.mainres{
top: -150px;
left: calc(50% - 190px);
width: 380px;
}
.mainresadd{
top: 50px;
left: calc(50% - 380px);
width: 760px;
}
.maincom{
top: -55px;
left: calc(50% - 250px);
width: 500px;
}

#container,
.sections,
.section {

    position: relative;

    height: 100%;
}
.section {

    background-color: #000;
    background-size: cover;
    background-position: 50% 50%;
}


#section0 {
    background-image: url(images/1.png);
}
#section2 {
    background-image: url(images/fortypes.jpg);
}





@media screen and (max-width:1020px) {
    .masfields{
        left: -362px;
    }
    .mainbutton{
        font-size: 50px;
    }
    .mainvac{
        left: calc(50% - 155px);
        width: 310px;
    }
    .mainvacadd{
        top: 50px;
        left: calc(50% - 280px);
        width: 560px;
    }
    .mainres{
        left: calc(50% - 120px);
        width: 240px;
    }
    .mainresadd{
        left: calc(50% - 240px);
        width: 480px;
    }
    .maincom{
        left: calc(50% - 160px);
        width: 320px;
    }
}

</style>

<body>

<div id="container" data-XSwitch>
    <div class="sections">
        <div class="section" id="section0">
            <div class = "mainheader">
                <div class = "mainheadervac" onclick = "document.location.href = 'vacancy.php'">вакансии</div>
                <div class = "mainheaderres" onclick = "document.location.href = 'resume.php'">резюме</div>
                <div class = "mainheadercom" onclick = "document.location.href = 'company.php'">компании</div>
                <?php 
                if($_COOKIE['login']) 
                    echo '<div class = "mainheaderacc" onclick = \'document.location.href = "account.php"\'>аккаунт</div>';
                else
                    echo '<div class = "mainheaderacc" onclick = \'document.location.href = "login.php"\'>аккаунт</div>';
                ?>
                    
            </div>
            <div class = "mainfindtofind">
                FindToFind
            </div>
            <div>
            <form method="GET" class = "mainsearchform post" action = "vacancy.php">
                <input type="text" class="textbox" name = "search" placeholder="Поиск">
                <input title="Search" value="" type="submit" class="button">
            </form>
            </div>
        </div>
        <div class="section" id="section1">
            <ul id="slides">
                <li class="slide showing">
                    <div class = "inslide">
                        <div class = "mainbutton mainvac" onclick = "location.href = 'vacancy.php'">ВАКАНСИИ</div>
                        <br>
                        <div class = "mainbutton mainvacadd" onclick = "location.href = 'addvac.php'">ОТКРЫТЬ ВАКАНСИЮ</div>
                    </div>
                </li>
                <li class="slide">
                    <div class = "inslide">
                        <div class = "mainbutton mainres" onclick = "location.href = 'resume.php'">РЕЗЮМЕ</div>
                        <br>
                        <div class = "mainbutton mainresadd" onclick = "location.href = 'addres.php'">СОЗДАТЬ РЕЗЮМЕ</div>
                    </div>
                </li>
                <li class="slide">
                    <div class = "inslide">
                        <div class = "mainbutton maincom" onclick = "location.href = 'company.php'"><div class = "divprev"></div>КОМПАНИИ</div>
                    </div>
                </li>
            </ul>
            <div class="controlprev" id="previous" onclick = "previousSlide()"></div>
            <div class="controlnext" id="next"  onclick = "nextSlide()"></div>
        </div>
        <div class="section" id="section2">
            <div class = "masfields">
                <div class = "mainfield1 mainfield" onclick = "document.location.href = 'vacancy.php?prof_obl1=Автомобильный бизнес'">
                </div>
                <div class = "center center1" onclick = "document.location.href = 'vacancy.php?prof_obl1=Автомобильный бизнес'">
                    Автомобильный бизнес
                </div>
                <div class = "mainfield2 mainfield" onclick = "document.location.href = 'vacancy.php?prof_obl1=Бухгалтерия'">                    
                </div>
                <div class = "center center2" onclick = "document.location.href = 'vacancy.php?prof_obl1=Бухгалтерия'">
                    Бухгалтерия
                </div>
                <div class = "mainfield3 mainfield" onclick = "document.location.href = 'vacancy.php?prof_obl1=Информационные технологии'">                    
                </div>
                <div class = "center center3" onclick = "document.location.href = 'vacancy.php?prof_obl1=Информационные технологии'">
                    Информационные технологии
                </div>
                <div class = "mainfield4 mainfield" onclick = "document.location.href = 'vacancy.php?prof_obl1=Искусство, развлечения'">                    
                </div>
                <div class = "center center4" onclick = "document.location.href = 'vacancy.php?prof_obl1=Искусство, развлечения'">
                    Искусство<br>развлечения
                </div>
                <div class = "mainfield5 mainfield" onclick = "document.location.href = 'vacancy.php?prof_obl1=Маркетинг, реклама'">                   
                </div>
                <div class = "center center5" onclick = "document.location.href = 'vacancy.php?prof_obl1=БухгаМаркетинг, рекламалтерия'">
                    Маркетинг<br>реклама
                </div>
                <div class = "mainfield6 mainfield" onclick = "document.location.href = 'vacancy.php?prof_obl1=Медицина'">                    
                </div>
                <div class = "center center6" onclick = "document.location.href = 'vacancy.php?prof_obl1=Медицина'">
                    Медицина
                </div>
                <div class = "mainfield7 mainfield" onclick = "document.location.href = 'vacancy.php?prof_obl1=Транспортировка'">                   
                </div>
                <div class = "center center7" onclick = "document.location.href = 'vacancy.php?prof_obl1=Транспортировка'">
                    Транспортировка
                </div>
                <div class = "mainfield8 mainfield" onclick = "document.location.href = 'vacancy.php?prof_obl1=Строительство, архитектура'">                    
                </div>
                <div class = "center center8" onclick = "document.location.href = 'vacancy.php?prof_obl1=Строительство, архитектура'">
                    Строительство<br>архитектура
                </div>
                <div class = "mainfield9 mainfield" onclick = "document.location.href = 'vacancy.php?prof_obl1=Страхование'">                 
                </div>
                <div class = "center center9" onclick = "document.location.href = 'vacancy.php?prof_obl1=Страхование'">
                    Страхование
                </div>
                <div class = "mainfield10 mainfield" onclick = "document.location.href = 'vacancy.php?prof_obl1=Наука, образование'">                 
                </div>
                <div class = "center center10" onclick = "document.location.href = 'vacancy.php?prof_obl1=Наука, образование'">
                    Наука<br>образование
                </div>
                <div class = "mainfield11 mainfield" onclick = "document.location.href = 'vacancy.php?prof_obl1=Туризм, ресторанный бизнес'">                    
                </div>
                <div class = "center center11" onclick = "document.location.href = 'vacancy.php?prof_obl1=Туризм, ресторанный бизнес'">
                    Туризм<br>ресторанный бизнес
                </div>
                <div class = "mainfield12 mainfield" onclick = "document.location.href = 'vacancy.php?prof_obl1=Юридическая деятельность'">
                </div>
                <div class = "center center12" onclick = "document.location.href = 'vacancy.php?prof_obl1=Юридическая деятельность'">
                    Юридическая деятельность
                </div>
            </div>
        </div>
    </div>
</div>


<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="js/script.js" type="text/javascript"></script>
<script src="js/XSwitch.min.js" charset="utf-8"></script>

</body>

