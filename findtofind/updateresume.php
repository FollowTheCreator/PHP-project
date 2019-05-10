<?php
require_once 'header.php';
require_once 'connection.php'; 

$link = new mysqli($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));

$currid = $_COOKIE['currid'];
if($_GET['resid'])
    $nowid = $_GET['resid'];
else 
    $nowid = $currid;

if($_COOKIE['type'] == 'res')
{
    $forfield = "
    select
        activity_of_advertisement.id,
        activity_of_advertisement.name
    from
        activity_of_advertisement
    ";
    
    $tage = $_GET['tage'];
    $exp1 = $_GET['exp'];

    $nowres = "
    select distinct
        resume.id,
        resume.post,
        resume.salary,
        resume.currency,
        resume.born,
        resume.about,
        resume.key_skill,
        gender.name,
        activity_of_advertisement.name,
        contact_info_resume.name,
        contact_info_resume.phone,
        contact_info_resume.email
    from
        resume
        join gender on gender.id = resume.gender
        join activity_of_advertisement_resume on activity_of_advertisement_resume.resume = resume.id
        join sub_activity_of_advertisement on sub_activity_of_advertisement.id = activity_of_advertisement_resume.activity_of_advertisement
        join activity_of_advertisement on activity_of_advertisement.id = sub_activity_of_advertisement.parent_activity_of_advertisement
        join contact_info_resume on contact_info_resume.id = resume.contact
    where 
        resume.id = ".$nowid;

    $nowresToE = "
    select 
        type_of_employment_resume.type 
    from 
        resume 
        join union_type_of_employment_resume on resume.id = union_type_of_employment_resume.resume 
        join type_of_employment_resume on type_of_employment_resume.id = union_type_of_employment_resume.type 
    where 
        resume.id = $nowid
    ";
    if($result1 = $link->query($nowresToE)){
        $arrToE = array();
        while($row1 = $result1->fetch_row()){
            array_push($arrToE, $row1[0]);
        }
    }

    $nowresTT = "
    select 
        timetable_resume.type 
    from 
        resume 
        join union_timetable_resume on resume.id = union_timetable_resume.resume 
        join timetable_resume on timetable_resume.id = union_timetable_resume.type 
    where 
        resume.id = $nowid
    ";
    if($result2 = $link->query($nowresTT)){
        $arrTT = array();
        while($row2 = $result2->fetch_row()){
            array_push($arrTT, $row2[0]);
        }
    }

    $nowresEDUC = "
    select 
        profession.name,
        institution.name,
        education.end
    from 
        resume 
        join educations on resume.id = educations.student
        join education on educations.education =  education.id
        join institution on institution.id = education.institution
        join profession on profession.id = education.profession
    where 
        resume.id = $nowid
    ";
    if($result3 = $link->query($nowresEDUC)){
        $arrEDUC = array();
        while($row2 = $result3->fetch_row()){
            array_push($arrEDUC, array($row2[0], $row2[1], $row2[2]));
        }
    }

    $nowresCOURSE = "
    select 
        course.name,
        course.institution,
        course.end
    from 
        resume 
        join courses on courses.student = resume.id
        join course on courses.course = course.id
    where 
        resume.id = $nowid
    ";
    if($result4 = $link->query($nowresCOURSE)){
        $arrCOURSE = array();
        while($row2 = $result4->fetch_row()){
            array_push($arrCOURSE, array($row2[0], $row2[1], $row2[2]));
        }
    }

    $nowresEXP = "
    select
        experience.company,
        experience.post,
        experience.about,
        experience.time,
        experience.end
    from
        resume
        join job_experience on job_experience.employee = resume.id
        join experience on experience.id = job_experience.experience
    where
        resume.id = $nowid
    ";
    if($result5 = $link->query($nowresEXP)){
        $arrEXP = array();
        while($row2 = $result5->fetch_row()){
            array_push($arrEXP, array($row2[0], $row2[1], $row2[2], $row2[3], $row2[4]));
        }
    }

    $nowresAoA = "
    select
        activity_of_advertisement.name,
        sub_activity_of_advertisement.sub_name
    from
        resume
        join activity_of_advertisement_resume on resume.id = activity_of_advertisement_resume.resume
        join sub_activity_of_advertisement on sub_activity_of_advertisement.id = activity_of_advertisement_resume.activity_of_advertisement
        join activity_of_advertisement on sub_activity_of_advertisement.parent_activity_of_advertisement = activity_of_advertisement.id 
    where 
        resume.id = $nowid
    ";
    if($result6 = $link->query($nowresAoA)){
        $arrAoA = array();
        while($row3 = $result6->fetch_row()){
            $parentAoA = $row3[0];
            array_push($arrAoA, $row3[1]);
        }
    }
    
    $forupd = "
        select
            gender.id,
            contact_info_resume.id
        from
            resume
            join contact_info_resume on contact_info_resume.id = resume.contact
            join gender on gender.id = resume.gender
        where
            resume.id = ".$currid;
    if($_GET['updresum'])
    {
        $result7 = $link->query($forupd);
        $row7 = $result7->fetch_row();
        $querycontact = "
        update
            contact_info_resume
        set
            name = '".$_GET['name']."', 
            phone = '".$_GET['phone']."', 
            email = '".$_GET['email']."'
        where
            id = $row7[1]
        ";
        $link->query($querycontact);
        $lastcontact = $link->insert_id;

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////удаление edu course job
        $deledu = "
        select 
            education.id
        from
            education
            join educations on educations.education = education.id
            join resume on resume.id = educations.student
        where
            resume.id = ".$nowid;
        $resdeledu = $link->query($deledu);
        $deleduinst = "
        select 
            education.institution
        from
            education
            join educations on educations.education = education.id
            join resume on resume.id = educations.student
        where
            resume.id = ".$nowid;
        $resdeleduinst = $link->query($deleduinst);
        $deleduprof = "
        select 
            education.profession
        from
            education
            join educations on educations.education = education.id
            join resume on resume.id = educations.student
        where
            resume.id = ".$nowid;
        $resdeleduprof = $link->query($deleduprof);
        $deledu = "
        update 
            educations
        set
            education = null
        where
            student = ".$nowid;
        $link->query($deledu);
        while($rowdeledu = $resdeledu->fetch_row()){
            $link->query("
            delete
            from
                education
            where
                id = ".$rowdeledu[0]); /////////////////////////////////// удаление edu
        }
        
        while($rowdeleduinst = $resdeleduinst->fetch_row()){
            $link->query("
            delete
            from
                institution
            where
                id = ".$rowdeleduinst[0]); /////////////////////////////////// удаление институтов edu
        }
        
        while($rowdeleduprof = $resdeleduprof->fetch_row()){
            $link->query("
            delete
            from
                profession
            where
                id = ".$rowdeleduprof[0]); /////////////////////////////////// удаление профессий edu
        }
        
        $delcourse = "
        select
            courses.course
        from
            courses
            join resume on resume.id = courses.student
        where
            resume.id = ".$nowid;
        $resdelcourse = $link->query($delcourse);
        $delcourse = "
        update 
            courses
        set
            course = null
        where
            student = ".$nowid;
        $link->query($delcourse);
        while($rowdelcourse = $resdelcourse->fetch_row()){
            $link->query("
            delete
            from
                course
            where
                id = ".$rowdelcourse[0]); /////////////////////////////////// удаление course
        }
        $deljob = "
        select
            job_experience.experience
        from
            job_experience
            join resume on resume.id = job_experience.employee
        where
            resume.id = ".$nowid;
        $resdeljob = $link->query($deljob);
        $deljob = "
        update 
            job_experience
        set
            experience = null
        where
            employee = ".$nowid;
        $link->query($deljob);
        while($rowdeljob = $resdeljob->fetch_row()){
            $link->query("
            delete
            from
                experience
            where
                id = ".$rowdeljob[0]); /////////////////////////////////// удаление job
        }
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
        update 
            resume 
        set
            about = '".$_GET['about']."', 
            salary = '".$salary."', 
            post = '".$_GET['post']."', 
            currency = '".$currency."', 
            key_skill = '".$keyskill."', 
            gender = '".$gender."', 
            born = '".$born."', 
            date_of_publication = '".date('Y-m-d')."'
        where
            id = $currid
        ";
        $link->query($queryresume);

        $link->query("
        delete 
        from
            union_type_of_employment_resume 
        where
            resume = ".$currid);
        if($_GET['chToE'])
        {
            foreach($_GET['chToE'] as $value)
            {
                $queryToE = "
                insert into 
                    union_type_of_employment_resume (type, resume)
                select f.id, ".$currid."
                from
                    (select id from type_of_employment_resume where type = '".$value."') f
                ";
                $link->query($queryToE);
            }
        }

        $link->query("
        delete 
        from
            union_timetable_resume 
        where
            resume = ".$currid);
        if($_GET['chTT'])
        {
            foreach($_GET['chTT'] as $value)
            {
                $queryTT = "
                insert into 
                    union_timetable_resume (type, resume)
                select f.id, ".$currid."
                from
                    (select id from timetable_resume where type = '".$value."') f
                ";
                $link->query($queryTT);
            }
        }

        if($_GET['educprof'])
        {
            $queryeducat = "
            delete
            from 
                educations 
            where
                student = $currid";
            $link->query($queryeducat);
            foreach($masedu as $value)
            {
                $queryeducat = "
                insert into 
                    educations (education, student) 
                values
                    ('$value', $currid)";

                $link->query($queryeducat);
            }
        }

        if($_GET['cursprof'])
        {
            $querycourse = "
            delete
            from 
                courses 
            where
                student = $currid";
            $link->query($querycourse);
            foreach($mascurs as $value)
            {
                $querycourse = "
                insert into 
                    courses (course, student) 
                values
                    ('$value', $currid)";

                $link->query($querycourse);
            }
        }

        if($_GET['jobcom'])
        {
            $queryjobs = "
            delete
            from 
                job_experience 
            where
                employee = $currid";
            $link->query($queryjobs);
            foreach($masjob as $value)
            {
                $queryjobs = "
                insert into 
                    job_experience (experience, employee) 
                values
                    ('$value', $currid)";
                $link->query($queryjobs);
            }
        }

        $link->query("
        delete 
        from
            activity_of_advertisement_resume 
        where
            resume = ".$currid);
        if($_GET['prof_obl2'])
        {
            foreach($_GET['prof_obl2'] as $value)
            {
                $queryprof = "
                insert into 
                    activity_of_advertisement_resume (resume, activity_of_advertisement)
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
    if($resultnow = $link->query($nowres)){
    $rownow = $resultnow->fetch_row();
    echo "<body class = 'showback2 addreswidth'>";
        echo "<div class = 'showpage'>";
            echo "<text class = 'addheader'>Обновление резюме</text>";
            echo "<br><br><br>";
            echo "<form method = 'GET'>";

            echo "<br><br><input class = 'addrespost' name = 'post' type = 'text' placeholder = 'Должность' autocomplete = 'off' required maxlength='200' value = '$rownow[1]'/>";
            echo "<br>";

            echo "<br><br><input class = 'addresslr' type = 'text' placeholder = 'Желаемая зарплата' autocomplete = 'off' value = '$rownow[2]'/>";
            echo "
                <select class = 'addrescrrncy' name = 'currency'>
                    <option";
                    if($row[3] == "BYN") echo " selected";
                    echo "><text>BYN</text></option>
                    <option";
                    if($row[3] == "USD") echo " selected";
                    echo "><text>USD</text></option>
                    <option";
                    if($row[3] == "EUR") echo " selected";
                    echo "><text>EUR</text></option>";
            echo "</select>";
            echo "<br>";

            echo "<div class = 'addresgender'>";
            echo "
                <label><input type = 'radio' name = 'gender' value = '1'";
                if($rownow[7] == "мужчина") echo " checked";
                echo "></input><text>Мужчина</text></label><br>
                <label><input type = 'radio' name = 'gender' value = '2'";
                if($rownow[7] == "женщина") echo " checked";
                echo "></input><text>Женщина</text></label><br>";
            echo "</div>";

            echo "<div class = 'addresdate'>";
                echo "<text>Дата рождения</text>";
                echo "<br>";
                echo "<input  class = 'addrescalendar' name = 'born' type = 'date' autocomplete = 'off' value = '$rownow[4]'/>";
            echo "</div>";

            echo "<textarea class = 'addresabout' name = 'about' type = 'textarea' placeholder = 'О себе...' required maxlength='3000'>$rownow[5]</textarea>";
            echo "<br><br>";

            echo "<div class = 'addreskeyskill'>";
                echo "<text>Ключевые навыки</text>";
                echo "<br>";
                echo "<text class = 'plus' onclick = 'addkey()'>добавить</text>";
                echo "<br>";
                echo "<div class = 'contkey'>";
                if($rownow[6] != "")
                {
                    foreach(explode("-/-", $rownow[6]) as $value){
                        echo "<div class = 'inp'><input class = 'forkey' type = 'text' name = 'keyskill[]' onblur = 'addkey1(this)' maxlength='32' value = '$value'></input><text onclick = 'del(this)' class = 'hand'>X</text></div>";
                    }
                }
                echo "</div>";
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
                                <label name = 'prof_obl1'><input name = 'prof_obl3' value = '$rowfield[1]' class = 'prof3' type = 'radio'";
                                if($rowfield[1] == $rownow[8])
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
            echo "<center>";
                echo "<text class = 'text3'>Образование</text>";
                echo "<br>";
                echo "<text class = 'plusedu' onclick = 'addedu()'>добавить</text>";
                echo "<br>";
                echo "<div class = 'edu'>";
                foreach($arrEDUC as $value){
                    echo "<div class = 'inp1'><input class = 'eduprof' type = 'text' name = 'educprof[]' placeholder = 'Профессия по диплому' onblur = 'addedu1(this)' required maxlength='100' value = '$value[0]'></input><br><input class = 'eduinst' type = 'text' name = 'educinst[]' placeholder = 'Учебное заведение' onblur = 'addedu1(this)' required maxlength='100' value = '$value[1]'></input><br><input class = 'eduend' type = 'text' name = 'educend[]' onblur = 'addedu1(this)' placeholder = 'Год окончания' required value = '$value[2]'></input><br><text onclick = 'deledu(this)' class = 'hand'>X</text></div>";
                }
                echo "</div>";
                echo "<br>";
            echo "</center>";

            echo "<br><br><br>";
            echo "<center>";
                echo "<text class = 'text3'>Курсы</text>";
                echo "<br>";
                echo "<text class = 'pluscurs' onclick = 'addcurs()'>добавить</text>";
                echo "<br>";
                echo "<div class = 'curs'>";
                foreach($arrCOURSE as $value){
                    echo "<div class = 'inp2'><input class = 'cursprof' type = 'text' name = 'cursprof[]' placeholder = 'Название курса' onblur = 'addcurs1(this)' required maxlength='100' value = '$value[0]'></input><br><input class = 'cursinst' type = 'text' name = 'cursinst[]' placeholder = 'Учебное заведение' onblur = 'addcurs1(this)' required maxlength='100' value = '$value[1]'></input><br><input class = 'cursend' type = 'text' name = 'cursend[]' onblur = 'addcurs1(this)' placeholder = 'Год окончания' required value = '$value[2]'></input><br><text onclick = 'delcurs(this)' class = 'hand'>X</text></div>";
                }
                echo "</div>";
            echo "</center>";

            echo "<br><br><br>";
            echo "<center>";
                echo "<text class = 'text3'>Опыт работы</text>";
                echo "<br>";
                echo "<text class = 'plusjob' onclick = 'addjob()'>добавить</text>";
                echo "<br>";
                echo "<div class = 'job'>";
                foreach($arrEXP as $value){
                    echo "<div class = 'inp3'><input class = 'jobcom' type = 'text' name = 'jobcom[]' placeholder = 'Компания' onblur = 'addjob1(this)' maxlength='100' required value = '$value[0]'></input><br><input class = 'jobpost' type = 'text' name = 'jobpost[]' placeholder = 'Должность' onblur = 'addjob1(this)' maxlength='100' required value = '$value[1]'></input><br><input class = 'jobabo' type = 'text' name = 'jobabo[]' placeholder = 'Описание работы' onblur = 'addjob1(this)' maxlength='500' value = '$value[2]'></input><br><text class = 'jobtimetext'>Дата начала работы:</text><input class = 'jobtime' type = 'date' name = 'jobtime[]' onfocus = 'setmax(this)' onblur = 'addjob1(this)' required value = '$value[3]'></input><br><text class = 'jobendtext'>Дата окончания работы:</text><input class = 'jobend' type = 'date' name = 'jobend[]' onfocus = 'setmin(this)' onblur = 'addjob1(this)' required value = '$value[4]'></input><br><text onclick = 'deljob(this)' class = 'hand'>X</text></div>";
                }
                echo "</div>";
            echo "</center>";

            echo "<br>";
            echo "<div class = 'addrescontact'>";
                echo "<text>Контактная информация</text>";
                echo "<br>";
                echo "<input class = 'addrescontactinpt' name = 'name' type = 'text' placeholder = 'Ваше имя' autocomplete = 'off' required maxlength='200' value = '$rownow[9]'/>";
                echo "<br>";
                echo "<input class = 'addrescontactinpt' name = 'phone' type = 'text' placeholder = 'Контактный номер' autocomplete = 'off' required maxlength='50' value = '$rownow[10]'/>";
                echo "<br>";
                echo "<input class = 'addrescontactinpt' name = 'email' type = 'mail' placeholder = 'Почта' autocomplete = 'off' required maxlength='200' value = '$rownow[11]'/>";
            echo "</div>";

            echo "<br><br><br><input class = 'updressbmt' type = 'submit' onclick = 'setCookie($nowid)' value = 'Обновить резюме' name = 'updresum'/>";

            echo "</form>";
        echo "</div>";
    echo "</body>";
    }
}

$link->close();

?>