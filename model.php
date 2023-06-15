<?php

/* ------------------ 
    Connexion to database 
------------------ */
try {

    $db_media = new PDO(
        "mysql:dbname=labo_mediatheque2023;host=localhost;port=3308",
        "root",
        "",
        array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        )
    );

} catch (Exception $ex) {
    die("FATAL ERROR (Acces DB) : ". $ex->getMessage().'<form><input type="button" value="Retour" onclick="history.go(-1)"></form>');
}

/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

        MOVIE PANEL

--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

function chooseData($db, $search, $sort, $page, $action) {
    // Get the default sorted tab of movie
    if ($search == '' && $sort == '') {
        $tab = selectData($db, $page*10);
    }
    // Get the search tab of movie
    elseif ($search != '') {
        $tab = searchMovie($db, $search, $page*10);
    }
    // Get the sorted tab of movie
    elseif ($sort != '') {
        $tab = selectSort($db, $page*10, $sort);
    }
    // Get the updating movie
    elseif ($login == true && $action == 'Modify') {
        $tab = selectAMovie($db, $movieID);
    }
    return $tab;
}

/* ------------------ 
    Selecting movie 
------------------ */
function selectData($db, $limit) {
    try {
        $showSql = "SELECT films_id, films_titre, films_resume, films_annee, films_affiche, films_duree, real_nom, group_concat(DISTINCT genres_nom), group_concat(DISTINCT acteurs_nom) FROM FILMS
        left outer JOIN FILMS_GENRES ON films_id = fg_films_id
        left outer JOIN GENRES ON fg_genres_id = genres_id
        left outer JOIN FILMS_ACTEURS ON films_id = fa_films_id
        left outer JOIN ACTEURS ON fa_acteurs_id = acteurs_id
        left outer JOIN REALISATEURS ON real_id = films_real_id
        GROUP BY films_id, films_titre, films_resume, films_annee, films_affiche, films_duree LIMIT ".($limit-10).",10;";
        $stmt = $db -> prepare($showSql);
        $stmt->setFetchMode(PDO::FETCH_NUM);
        $stmt->execute(); 
        $tab=$stmt->fetchAll();
        return $tab;
    } catch (Exception $ex) {
        die("FATAL ERROR (Select Data) : ". $ex->getMessage().'<form><input type="button" value="Retour" onclick="history.go(-1)"></form>');
    }
}

/* ------------------ 
    Sorting movie 
------------------ */
function selectSort($db, $limit, $sort) {
    try {
        if ($sort == "title-asc") {
            $showSql = "SELECT films_id, films_titre, films_resume, films_annee, films_affiche, films_duree, real_nom, group_concat(DISTINCT genres_nom), group_concat(DISTINCT acteurs_nom) FROM FILMS
            left outer JOIN FILMS_GENRES ON films_id = fg_films_id
            left outer JOIN GENRES ON fg_genres_id = genres_id
            left outer JOIN FILMS_ACTEURS ON films_id = fa_films_id
            left outer JOIN ACTEURS ON fa_acteurs_id = acteurs_id
            left outer JOIN REALISATEURS ON real_id = films_real_id
            GROUP BY films_id, films_titre, films_resume, films_annee, films_affiche, films_duree
            ORDER BY films_titre ASC LIMIT ".($limit-10).",10;";
            $stmt = $db -> prepare($showSql);
            $stmt->setFetchMode(PDO::FETCH_NUM);
            $stmt->execute(); 
            $tab=$stmt->fetchAll();
        }
        else if ($sort == "title-desc") {
            $showSql = "SELECT films_id, films_titre, films_resume, films_annee, films_affiche, films_duree, real_nom, group_concat(DISTINCT genres_nom), group_concat(DISTINCT acteurs_nom) FROM FILMS
            left outer JOIN FILMS_GENRES ON films_id = fg_films_id
            left outer JOIN GENRES ON fg_genres_id = genres_id
            left outer JOIN FILMS_ACTEURS ON films_id = fa_films_id
            left outer JOIN ACTEURS ON fa_acteurs_id = acteurs_id
            left outer JOIN REALISATEURS ON real_id = films_real_id
            GROUP BY films_id, films_titre, films_resume, films_annee, films_affiche, films_duree
            ORDER BY films_titre DESC LIMIT ".($limit-10).",10;";
            $stmt = $db -> prepare($showSql);
            $stmt->setFetchMode(PDO::FETCH_NUM);
            $stmt->execute(); 
            $tab=$stmt->fetchAll();
        }
        else if ($sort == "year-asc") {
            $showSql = "SELECT films_id, films_titre, films_resume, films_annee, films_affiche, films_duree, real_nom, group_concat(DISTINCT genres_nom), group_concat(DISTINCT acteurs_nom) FROM FILMS
            left outer JOIN FILMS_GENRES ON films_id = fg_films_id
            left outer JOIN GENRES ON fg_genres_id = genres_id
            left outer JOIN FILMS_ACTEURS ON films_id = fa_films_id
            left outer JOIN ACTEURS ON fa_acteurs_id = acteurs_id
            left outer JOIN REALISATEURS ON real_id = films_real_id
            GROUP BY films_id, films_titre, films_resume, films_annee, films_affiche, films_duree
            ORDER BY films_annee ASC LIMIT ".($limit-10).",10;";
            $stmt = $db -> prepare($showSql);
            $stmt->setFetchMode(PDO::FETCH_NUM);
            $stmt->execute(); 
            $tab=$stmt->fetchAll();
        }
        else if ($sort == "year-desc") {
            $showSql = "SELECT films_id, films_titre, films_resume, films_annee, films_affiche, films_duree, real_nom, group_concat(DISTINCT genres_nom), group_concat(DISTINCT acteurs_nom) FROM FILMS
            left outer JOIN FILMS_GENRES ON films_id = fg_films_id
            left outer JOIN GENRES ON fg_genres_id = genres_id
            left outer JOIN FILMS_ACTEURS ON films_id = fa_films_id
            left outer JOIN ACTEURS ON fa_acteurs_id = acteurs_id
            left outer JOIN REALISATEURS ON real_id = films_real_id
            GROUP BY films_id, films_titre, films_resume, films_annee, films_affiche, films_duree
            ORDER BY films_annee DESC LIMIT ".($limit-10).",10;";
            $stmt = $db -> prepare($showSql);
            $stmt->setFetchMode(PDO::FETCH_NUM);
            $stmt->execute(); 
            $tab=$stmt->fetchAll();
        }
        else if ($sort == "time-asc") {
            $showSql = "SELECT films_id, films_titre, films_resume, films_annee, films_affiche, films_duree, real_nom, group_concat(DISTINCT genres_nom), group_concat(DISTINCT acteurs_nom) FROM FILMS
            left outer JOIN FILMS_GENRES ON films_id = fg_films_id
            left outer JOIN GENRES ON fg_genres_id = genres_id
            left outer JOIN FILMS_ACTEURS ON films_id = fa_films_id
            left outer JOIN ACTEURS ON fa_acteurs_id = acteurs_id
            left outer JOIN REALISATEURS ON real_id = films_real_id
            GROUP BY films_id, films_titre, films_resume, films_annee, films_affiche, films_duree
            ORDER BY films_duree ASC LIMIT ".($limit-10).",10;";
            $stmt = $db -> prepare($showSql);
            $stmt->setFetchMode(PDO::FETCH_NUM);
            $stmt->execute(); 
            $tab=$stmt->fetchAll();
        }
        else if ($sort == "time-desc") {
            $showSql = "SELECT films_id, films_titre, films_resume, films_annee, films_affiche, films_duree, real_nom, group_concat(DISTINCT genres_nom), group_concat(DISTINCT acteurs_nom) FROM FILMS
            left outer JOIN FILMS_GENRES ON films_id = fg_films_id
            left outer JOIN GENRES ON fg_genres_id = genres_id
            left outer JOIN FILMS_ACTEURS ON films_id = fa_films_id
            left outer JOIN ACTEURS ON fa_acteurs_id = acteurs_id
            left outer JOIN REALISATEURS ON real_id = films_real_id
            GROUP BY films_id, films_titre, films_resume, films_annee, films_affiche, films_duree
            ORDER BY films_duree DESC LIMIT ".($limit-10).",10;";
            $stmt = $db -> prepare($showSql);
            $stmt->setFetchMode(PDO::FETCH_NUM);
            $stmt->execute(); 
            $tab=$stmt->fetchAll();
        }
        else if ($sort == "real-asc") {
            $showSql = "SELECT films_id, films_titre, films_resume, films_annee, films_affiche, films_duree, real_nom, group_concat(DISTINCT genres_nom), group_concat(DISTINCT acteurs_nom) FROM FILMS
            left outer JOIN FILMS_GENRES ON films_id = fg_films_id
            left outer JOIN GENRES ON fg_genres_id = genres_id
            left outer JOIN FILMS_ACTEURS ON films_id = fa_films_id
            left outer JOIN ACTEURS ON fa_acteurs_id = acteurs_id
            left outer JOIN REALISATEURS ON real_id = films_real_id
            GROUP BY films_id, films_titre, films_resume, films_annee, films_affiche, films_duree
            ORDER BY real_nom ASC LIMIT ".($limit-10).",10;";
            $stmt = $db -> prepare($showSql);
            $stmt->setFetchMode(PDO::FETCH_NUM);
            $stmt->execute(); 
            $tab=$stmt->fetchAll();
        }
        else {
            $showSql = "SELECT films_id, films_titre, films_resume, films_annee, films_affiche, films_duree, real_nom, group_concat(DISTINCT genres_nom), group_concat(DISTINCT acteurs_nom) FROM FILMS
            left outer JOIN FILMS_GENRES ON films_id = fg_films_id
            left outer JOIN GENRES ON fg_genres_id = genres_id
            left outer JOIN FILMS_ACTEURS ON films_id = fa_films_id
            left outer JOIN ACTEURS ON fa_acteurs_id = acteurs_id
            left outer JOIN REALISATEURS ON real_id = films_real_id
            GROUP BY films_id, films_titre, films_resume, films_annee, films_affiche, films_duree
            ORDER BY real_nom DESC LIMIT ".($limit-10).",10;";
            $stmt = $db -> prepare($showSql);
            $stmt->setFetchMode(PDO::FETCH_NUM);
            $stmt->execute(); 
            $tab=$stmt->fetchAll();
        }
        return $tab;
    } catch (Exception $ex) {
        die("FATAL ERROR (Select Data) : ". $ex->getMessage().'<form><input type="button" value="Retour" onclick="history.go(-1)"></form>');
    }
}

/* ------------------ 
    Searching Movie 
------------------ */
function searchMovie($db, $search, $limit) {
    try {
        $searchSql = "SELECT films_id, films_titre, films_resume, films_annee, films_affiche, films_duree, real_nom, group_concat(DISTINCT genres_nom), group_concat(DISTINCT acteurs_nom) FROM FILMS
        left outer JOIN FILMS_GENRES ON films_id = fg_films_id
        left outer JOIN GENRES ON fg_genres_id = genres_id
        left outer JOIN FILMS_ACTEURS ON films_id = fa_films_id
        left outer JOIN ACTEURS ON fa_acteurs_id = acteurs_id
        left outer JOIN REALISATEURS ON real_id = films_real_id
        WHERE films_titre LIKE '%$search%' OR films_resume LIKE '%$search%' OR real_nom LIKE '%$search%' OR genres_nom LIKE '%$search%' OR acteurs_nom LIKE '%$search%'
        /* Showing every actor and type when searching */
        OR EXISTS (SELECT * FROM acteurs JOIN films_acteurs ON fa_acteurs_id=acteurs_id  WHERE acteurs_nom LIKE '%$search%' AND fa_films_id = films_id)
        OR EXISTS (SELECT * FROM genres JOIN films_genres ON fg_genres_id=genres_id  WHERE genres_nom LIKE '%$search%' AND fg_films_id = films_id)
        /* ------------------------------------------- */
        GROUP BY films_id, films_titre, films_resume, films_annee, films_affiche, films_duree LIMIT ".($limit-10).",10;";
        $stmt = $db -> prepare($searchSql);
        $stmt->setFetchMode(PDO::FETCH_NUM);
        $stmt->execute();
        $tab=$stmt->fetchAll();
        return $tab;
    } catch (Exception $ex) {
        die("FATAL ERROR (Searching movie) : ". $ex->getMessage().'<form><input type="button" value="Retour" onclick="history.go(-1)"></form>');
    }
}

/* ------------------ 
    Counting Movie 
------------------ */
function countMovie($db, $search) {
    try {
        if ($search != "") {
            $countSql = "SELECT COUNT(DISTINCT films_id) FROM FILMS
            left outer JOIN FILMS_GENRES ON films_id = fg_films_id
            left outer JOIN GENRES ON fg_genres_id = genres_id
            left outer JOIN FILMS_ACTEURS ON films_id = fa_films_id
            left outer JOIN ACTEURS ON fa_acteurs_id = acteurs_id
            left outer JOIN REALISATEURS ON real_id = films_real_id
            WHERE films_titre LIKE '%$search%' OR real_nom LIKE '%$search%' OR genres_nom LIKE '%$search%' OR acteurs_nom LIKE '%$search%';";
            $stmt = $db -> prepare($countSql);
            $stmt->execute();  
            $stmt->setFetchMode(PDO::FETCH_NUM);
            $tab=$stmt->fetchAll();
        }
        else {
            $countSql = "SELECT COUNT(*) AS num FROM FILMS;";
            $stmt = $db -> prepare($countSql);
            $stmt->execute(); 
            $stmt->setFetchMode(PDO::FETCH_NUM);
            $tab=$stmt->fetchAll();
        }
        return $tab;
    } catch (Exception $ex) {
        die("FATAL ERROR (Counting Movie) : ". $ex->getMessage().'<form><input type="button" value="Retour" onclick="history.go(-1)"></form>');
    }

}

/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

        ADMIN PANEL

--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

/* ------------------ 
    Get Users table 
------------------ */
function getUsers($db) {
    try {
        $searchSql = "SELECT users_name, users_pwd FROM USERS;";
        $stmt = $db -> prepare($searchSql);
        $stmt->setFetchMode(PDO::FETCH_NUM);
        $stmt->execute(); 
        $tab=$stmt->fetchAll();
        return $tab;
    } catch (Exception $ex) {
        die("FATAL ERROR (Searching users) : ". $ex->getMessage().'<form><input type="button" value="Retour" onclick="history.go(-1)"></form>');
    }
}

/* ------------------ 
    Select a movie
------------------ */
function selectAMovie($db, $movieID) {
    try {
        $showMovieSql = "SELECT films_id, films_titre, films_resume, films_annee, films_affiche, films_duree, real_nom, group_concat(DISTINCT genres_nom), group_concat(DISTINCT acteurs_nom) FROM FILMS
        left outer JOIN FILMS_GENRES ON films_id = fg_films_id
        left outer JOIN GENRES ON fg_genres_id = genres_id
        left outer JOIN FILMS_ACTEURS ON films_id = fa_films_id
        left outer JOIN ACTEURS ON fa_acteurs_id = acteurs_id
        left outer JOIN REALISATEURS ON real_id = films_real_id
        WHERE films_id = :id
        GROUP BY films_id, films_titre, films_resume, films_annee, films_affiche, films_duree;";
        $stmt = $db -> prepare($showMovieSql);
        $stmt -> bindValue('id', $movieID, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_NUM);
        $stmt->execute();
        $movie=$stmt->fetchAll();
        return $movie;
    } catch (Exception $ex) {
        die("FATAL ERROR (Select a Movie) : ". $ex->getMessage().'<form><input type="button" value="Retour" onclick="history.go(-1)"></form>');
    }
}

/* ------------------ 
    Select movie maker 
------------------ */
function selectMaker($db) {
    try {
        $showSql = "SELECT * FROM realisateurs;";
        $stmt = $db -> prepare($showSql);
        $stmt->setFetchMode(PDO::FETCH_NUM);
        $stmt->execute(); 
        $tab=$stmt->fetchAll();
        return $tab;
    } catch (Exception $ex) {
        die("FATAL ERROR (Select Movie Maker) : ". $ex->getMessage().'<form><input type="button" value="Retour" onclick="history.go(-1)"></form>');
    }
}

/* ------------------ 
    Select Type
------------------ */
function selectType($db) {
    try {
        $showSql = "SELECT * FROM genres;";
        $stmt = $db -> prepare($showSql);
        $stmt->setFetchMode(PDO::FETCH_NUM);
        $stmt->execute(); 
        $tab=$stmt->fetchAll();
        return $tab;
    } catch (Exception $ex) {
        die("FATAL ERROR (Select Type) : ". $ex->getMessage().'<form><input type="button" value="Retour" onclick="history.go(-1)"></form>');
    }
}

/* ------------------ 
    Select actor
------------------ */
function selectActor($db) {
    try {
        $showSql = "SELECT * FROM acteurs;";
        $stmt = $db -> prepare($showSql);
        $stmt->setFetchMode(PDO::FETCH_NUM);
        $stmt->execute(); 
        $tab=$stmt->fetchAll();
        return $tab;
    } catch (Exception $ex) {
        die("FATAL ERROR (Select Actor) : ". $ex->getMessage().'<form><input type="button" value="Retour" onclick="history.go(-1)"></form>');
    }
}

/* ------------------ 
    Adding Movie 
------------------ */
function addMovie($db) {
    try {
        $insertSql = "INSERT INTO films (films_id,films_titre,films_resume,films_annee,films_affiche,films_duree,films_real_id) VALUES (
            DEFAULT, 
            :titre,
            :decr,
            :annee,
            :affiche,
            :duree,
            :reali);";
        $title = $_POST["title"];
        $resume = $_POST["resume"];
        $year = $_POST["year"];
        $poster = $_FILES['image']['name'];
        $time = $_POST["time"];
        $maker = $_POST["maker"];

        $stmt = $db -> prepare($insertSql);
        $stmt -> bindValue('titre', $title, PDO::PARAM_STR);
        $stmt -> bindValue('decr', $resume, PDO::PARAM_STR);
        $stmt -> bindValue('annee', $year, PDO::PARAM_INT);
        $stmt -> bindValue('affiche', $poster, PDO::PARAM_STR);
        $stmt -> bindValue('duree', $time, PDO::PARAM_INT);
        $stmt -> bindValue('reali', $maker, PDO::PARAM_INT);

        $stmt -> execute();

        $movieID = $db -> lastInsertId();
        foreach ($_POST["typeList"] as $key => $value) {
            addType($db, $movieID, $value);
        }
        foreach ($_POST["actorList"] as $key => $value) {
            addActor($db, $movieID, $value);
        }

    } catch (Exception $ex) {
        die("FATAL ERROR (Add movie) : ". $ex->getMessage().'<form><input type="button" value="Retour" onclick="history.go(-1)"></form>');
    }
}

/* ------------------ 
    Adding Maker 
------------------ */
function addMovieMaker($db, $new_maker) {
    try {
        $insertSql = "INSERT INTO realisateurs (real_id, real_nom) VALUES (
            DEFAULT, 
            :nom);";
        $name = $new_maker;

        $stmt = $db -> prepare($insertSql);
        $stmt -> bindValue('nom', $name, PDO::PARAM_STR);

        $stmt -> execute(); 

        echo $db -> lastInsertId();
    } catch (Exception $ex) {
        die("FATAL ERROR (Add new movie maker) : ". $ex->getMessage().'<form><input type="button" value="Retour" onclick="history.go(-1)"></form>');
    }
}

/* ------------------ 
    Adding Type to film 
------------------ */
function addType($db, $movieID, $type) {
    try {
        $insertSql = "INSERT INTO films_genres (fg_films_id,fg_genres_id) VALUES (
            :film, 
            :genre);";

        $stmt = $db -> prepare($insertSql);
        $stmt -> bindValue('film', $movieID, PDO::PARAM_INT);
        $stmt -> bindValue('genre', $type, PDO::PARAM_INT);

        $stmt -> execute(); 
    } catch (Exception $ex) {
        die("FATAL ERROR (Adding type to movie) : ". $ex->getMessage().'<form><input type="button" value="Retour" onclick="history.go(-1)"></form>');
    }
}

/* ------------------ 
    Adding Type 
------------------ */
function addMovieType($db, $new_type) {
    try {
        $insertSql = "INSERT INTO genres (genres_id, genres_nom) VALUES (
            DEFAULT, 
            :nom);";
        $name = $new_type;

        $stmt = $db -> prepare($insertSql);
        $stmt -> bindValue('nom', $name, PDO::PARAM_STR);

        $stmt -> execute(); 

        echo $db -> lastInsertId();
    } catch (Exception $ex) {
        die("FATAL ERROR (Add new movie type) : ". $ex->getMessage().'<form><input type="button" value="Retour" onclick="history.go(-1)"></form>');
    }
}

/* ------------------ 
    Adding Actor to film 
------------------ */
function addActor($db, $movieID, $actor) {
    try {
        $insertSql = "INSERT INTO films_acteurs (fa_films_id,fa_acteurs_id) VALUES (
            :film, 
            :acteur);";

        $stmt = $db -> prepare($insertSql);
        $stmt -> bindValue('film', $movieID, PDO::PARAM_INT);
        $stmt -> bindValue('acteur', $actor, PDO::PARAM_INT);

        $stmt -> execute(); 
    } catch (Exception $ex) {
        die("FATAL ERROR (Adding actor to movie) : ". $ex->getMessage().'<form><input type="button" value="Retour" onclick="history.go(-1)"></form>');
    }
}

/* ------------------ 
    Adding Actor 
------------------ */
function addMovieActor($db, $new_actor) {
    try {
        $insertSql = "INSERT INTO acteurs (acteurs_id, acteurs_nom) VALUES (
            DEFAULT, 
            :nom);";
        $name = $new_actor;

        $stmt = $db -> prepare($insertSql);
        $stmt -> bindValue('nom', $name, PDO::PARAM_STR);

        $stmt -> execute(); 

        echo $db -> lastInsertId();
    } catch (Exception $ex) {
        die("FATAL ERROR (Add new movie actor) : ". $ex->getMessage().'<form><input type="button" value="Retour" onclick="history.go(-1)"></form>');
    }
}

/* ------------------ 
    Deleting Movie 
------------------ */
function deleteMovie($db, $movieID) {
    try {
        $deleteSql = "DELETE FROM films WHERE films_id = :id;";
        $stmt = $db -> prepare($deleteSql);
        $stmt -> bindValue('id', $movieID, PDO::PARAM_INT);
        $stmt -> execute();
    } catch (Exception $ex) {
        die("FATAL ERROR (Delete movie) : ". $ex->getMessage().'<form><input type="button" value="Retour" onclick="history.go(-1)"></form>');
    }
}

/* ------------------ 
    Modifying Movie 
------------------ */
function modifyMovie($db, $movieID, $movie) {
    try {
        $updateSql = "UPDATE films SET films_titre=:titre, films_resume=:descr, films_annee=:annee, films_affiche=:affiche, films_duree=:duree, films_real_id=:reali WHERE films_id = :id;";

        $title = $_POST["title"];
        $resume = $_POST["resume"];
        $year = $_POST["year"];
        if (isset($_FILES['image'])) {
            $poster = $_FILES['image']['name'];
        }
        else {
            $poster = $movie[4];
        }
        $time = $_POST["time"];
        $maker = $_POST["maker"];

        

        $stmt = $db -> prepare($updateSql);
        $stmt -> bindValue('id', $movieID, PDO::PARAM_INT);
        $stmt -> bindValue('titre', $title, PDO::PARAM_STR);
        $stmt -> bindValue('descr', $resume, PDO::PARAM_STR);
        $stmt -> bindValue('annee', $year, PDO::PARAM_STR);
        $stmt -> bindValue('affiche', $poster, PDO::PARAM_STR);
        $stmt -> bindValue('duree', $time, PDO::PARAM_INT);
        $stmt -> bindValue('reali', $maker, PDO::PARAM_INT);

        $stmt -> execute();
        
        if (isset($_POST["typeList"]) && isset($_POST["actorList"])) {
            foreach ($_POST["typeList"] as $key => $value) {
                addType($db, $movieID, $value);
            }
            foreach ($_POST["actorList"] as $key => $value) {
                addActor($db, $movieID, $value);
            }
        }
    } catch (Exception $ex) {
        die("FATAL ERROR (Modify movie) : ". $ex->getMessage().'<form><input type="button" value="Retour" onclick="history.go(-1)"></form>');
    }
}

function selectTypeMovie($db, $movieID) {
    try {
        $showMovieSql = "SELECT genres_nom FROM GENRES
            left outer JOIN FILMS_GENRES ON genres_id = fg_genres_id
            left outer JOIN FILMS ON films_id = fg_films_id
            WHERE fg_films_id = :id;";
        $stmt = $db -> prepare($showMovieSql);
        $stmt -> bindValue('id', $movieID, PDO::PARAM_INT);
        $stmt -> setFetchMode(PDO::FETCH_NUM);
        $stmt -> execute();
        $movieType = $stmt -> fetchAll();
        return $movieType;
    } catch (Exception $ex) {
        die("FATAL ERROR (Select types of movie) : ". $ex->getMessage().'<form><input type="button" value="Retour" onclick="history.go(-1)"></form>');
    }
}

function selectActorMovie($db, $movieID) {
    try {
        $showMovieSql = "SELECT acteurs_nom FROM ACTEURS
            left outer JOIN FILMS_ACTEURS ON acteurs_id = fa_acteurs_id
            left outer JOIN FILMS ON films_id = fa_films_id
            WHERE fa_films_id = :id;";
        $stmt = $db -> prepare($showMovieSql);
        $stmt -> bindValue('id', $movieID, PDO::PARAM_INT);
        $stmt -> setFetchMode(PDO::FETCH_NUM);
        $stmt -> execute();
        $movieType = $stmt -> fetchAll();
        return $movieType;
    } catch (Exception $ex) {
        die("FATAL ERROR (Select actors of movie) : ". $ex->getMessage().'<form><input type="button" value="Retour" onclick="history.go(-1)"></form>');
    }
}

?>