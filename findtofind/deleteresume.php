<?php
require_once 'header.php';
require_once 'connection.php'; 

$link = new mysqli($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));

if($_COOKIE['type'] == 'res' && $_GET['resid'])
{
    $nowid = $_GET['resid'];

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
        $deledu = "
        delete
        from 
            educations
        where
            student = ".$nowid;
        $link->query($deledu);
        
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
        $delcourse = "
        delete 
        from
            courses
        where
            student = ".$nowid;
        $link->query($delcourse);
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
        $deljob = "
        delete
        from
            job_experience
        where
            employee = ".$nowid;
        $link->query($deljob);

        $query = "
        delete
        from
            union_type_of_employment_resume
        where
            resume = $nowid
        ";
        $link->query($query);
    
        $query = "
        delete
        from
            union_timetable_resume
        where
            resume = $nowid
        ";
        $link->query($query);
    
        $query = "
        delete
        from
            activity_of_advertisement_resume
        where
            resume = $nowid
        ";
        $link->query($query);
        
        $query = "
        select
            contact
        from
            resume
        where
            id = $nowid
        ";
        $result = $link->query($query);
        $row = $result->fetch_row();
        $contact = $row[0];
        
    $query = "
    delete
    from
        resume
    where
        id = $nowid
    ";
    $link->query($query);

    $query = "
    delete
    from
        contact_info_resume
    where
        id = $contact
    ";
    $link->query($query);
}

$link->close();


?>

<script>
    link("http://findtofind/account.php");    
</script>