<?php
require_once 'header.php';
require_once 'connection.php'; 

$link = new mysqli($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));

if($_COOKIE['type'] == 'vac' && $_GET['vacid'])
{
    $nowid = $_GET['vacid'];

    $query = "
    delete
    from
        union_type_of_employment_vacancy
    where
        vacancy = $nowid
    ";
    $link->query($query);

    $query = "
    delete
    from
        union_timetable_vacancy
    where
        vacancy = $nowid
    ";
    $link->query($query);

    $query = "
    delete
    from
        activity_of_advertisement_vacancy
    where
        vacancy = $nowid
    ";
    $link->query($query);
    
    $query = "
    select
        contact,
        address
    from
        vacancy
    where
        id = $nowid
    ";
    $result = $link->query($query);
    $row = $result->fetch_row();
    $contact = $row[0];
    $address = $row[1];

    $query = "
    delete
    from
        vacancy
    where
        id = $nowid
    ";
    $link->query($query);

    $query = "
    delete
    from
        contact_info_vacancy
    where
        id = $contact
    ";
    $link->query($query);

    $query = "
    delete
    from
        address
    where
        id = $address
    ";
    $link->query($query);
}

$link->close();

?>

<script>
    link("http://findtofind/account.php");    
</script>