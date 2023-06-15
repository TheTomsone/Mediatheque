<?php
/* -------------- 
    FUNCTIONS
-------------- */
require_once("model.php");

/* -------------- 
    VARIABLES
-------------- */
// Users
$action = '';
$search = '';
$sort = '';
$page = 1;
$page_min = 1;
// Admin
$login = false;
$movieID = '';
$movie = '';
$file_name = '';
$file_tmp = '';
$file_destination = '';
$typeList = '';
$tabMovieType = '';
$tabMovieActor = '';
$new_maker = '';
$new_type = '';
$new_actor = '';

// Check if login
if (isset($login_ok)) {
    $login = true;
    // Get the movie ID
    if (isset($_POST['movieID'])) {
        $movieID = $_POST['movieID'];
    }
    // Get file name and destination for upload
    if(isset($_FILES['image'])){
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_destination = 'src/img/movies/'.$file_name;
    }
    if (isset($_POST['typeList'])) {
        $selectedOptions = $_POST['typeList'];
        // Boucle sur les options sélectionnées
        foreach ($selectedOptions as $option) {
            // Conversion en entier
            $id = (int)$option;
            addType($db_media, $movieID, $id);
        }
    }
    /* Get the type list for movie
    if (isset($_POST['typeList'])) {
        $typeList = $_POST['typeList'];
        var_dump($typeList);
        //$movieID = $_POST['movieID'];
    }
    // Get the actor list for movie
    if (isset($_POST['actorList'])) {
        $actorList = $_POST['actorList'];
        //$movieID = $_POST['movieID'];
    }*/
    // Get movie maker
    if (isset($_POST['movies-maker'])) {
        $new_maker = $_POST['movies-maker'];
        addMovieMaker($db_media, $new_maker);
    }
    // Get movie types
    if (isset($_POST['movies-type'])) {
        $new_type = $_POST['movies-type'];
        addMovieType($db_media, $new_type);
    }
    // Get movie actors
    if (isset($_POST['movies-actor'])) {
        $new_actor = $_POST['movies-actor'];
        addMovieActor($db_media, $new_actor);
    }
}
// Get the action button
if (isset($_POST['action'])) {
    $action = $_POST['action'];
}
// Get the page ID
if (isset($_POST['page-id'])) {
    $page = $_POST['page-id'];
}
// Get the search input
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}
// Get the sorting choice
if (isset($_POST['sort'])) {
    $sort = $_POST['sort'];
}
// Count number of movie and get the number of page
$tab_number = countMovie($db_media, $search);
$page_max = $tab_number[0][0];
if ($page_max > 1) {
    while ($page_max % 10 != 0) {
        $page_max++;
    }
    $page_max = $page_max / 10;
}
// Triggers action for page, movies,...
switch ($action) {
    // Page --
    case "Précédent" :
        if ($page > $page_min) {
            $page--;
        }
        else {
            $page = $page_max;
        }
        break;
    // Page ++
    case "Suivant" :
        if ($page < $page_max) {
            $page++;
        }
        else {
            $page = $page_min;
        }
        break;
    // Setting default sort when searching
    case "Search" :
        $sort = '';
        break;
    // Delete a movie
    case "Delete" :
        deleteMovie($db_media, $movieID);
        break;
    // Add new movie
    case "Add" :
        move_uploaded_file($file_tmp, $file_destination);
        addMovie($db_media);
        break;
    case 'Modify';
        //$tab = selectAMovie($db_media, $movieID);
        break;
    // Modify a movie
    case "Apply" :
        modifyMovie($db_media, $movieID, $tab);
        break;
}

$tab = chooseData($db_media, $search, $sort, $page, $action);
// Get every tab for admin panel
if ($login == true) {
    $tabMovieType = selectTypeMovie($db_media, $movieID);
    $tabMovieActor = selectActorMovie($db_media, $movieID);
    $tabMaker = selectMaker($db_media);
    $tabActor = selectActor($db_media);
    $tabType = selectType($db_media);
}

/* -------------- 
    TEMPLATE
-------------- */
require_once("view.php");
?>