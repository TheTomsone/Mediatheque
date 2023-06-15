<?php
/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

        MAIN FUNCTIONS

--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

/* ------------------ 
    Convert minutes into hour 
------------------ */
function displayHour($time_minutes) {
    $minutes = $time_minutes % 60;
    if ($minutes < 10) {
        $minutes = "0".$minutes;
    }
    $hour = $time_minutes - $minutes;
    $hour = $hour / 60;
    $time = $hour."h".$minutes;
    return $time;
}

function searchID($tab, $id) {
    foreach ($tab as $key => $value) {
        if (is_array($value) && $value[0] == $id) {
            return $value[1];
        }
    }
}

/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

        ADMIN FUNCTIONS

--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Médiathèque | PROFORMA</title>

        <!-- Font Google -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script type="text/javascript" src='src/js/ajax.js'></script>

        <link rel="stylesheet" href="src/css/normalize.css">
        <link rel="stylesheet" href="src/css/main.css">
    </head>

    <body>
        <div class="header">
            <div class="search">
                <input type='search' name='search' id='search' placeholder='Recherche...' value='<?php echo $search; ?>'>
                <button type="submit" name="action" value="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <a href="controller.php"><h1>Médiathèque</h1></a>
        </div>
        <!-- CONTENT -->
        <section id='movies'>
            <h2><?php if ($login == true) { echo "Bienvenue $username"; } else { echo "Nos Films"; } ?><hr></h2>
            <?php
            if ($login == true) {
            ?>
                <!-- ADDING/UPDATING PANEL -->
                <form action="login.php" method="post" enctype="multipart/form-data">
                    <div id='grid-movie' class='grid'>
                        <div class="movie-card">
                            <button type='submit' name='action' value='Add'><i <?php if ($action != "Modify") { echo "class='fa-solid fa-plus'"; } else { echo "class='fa-solid fa-check'"; } ?>></i></button>
                            <hr>
                            <!-- TITLE -->
                            <h3>
                                <input id='title' type='text' name='title' <?php if ($action != "Modify") { echo "placeholder='Titre...'"; } else { echo "value='".$movie[1]."'"; } ?>></input>
                                <span>(<input type='number' name='year' <?php if ($action != "Modify") { echo "placeholder='Année...'"; } else { echo "value='".$movie[3]."'"; } ?>></input>)</span>
                            </h3>
                            <!-- SELECT TYPE -->
                            <div class='multiple-select'>
                                <div class='btn-select'>
                                    <span class='btn-text-type'>Sélectionner Genre</span>
                                    <span class='arrow-dwn'><i class='fa-solid fa-angle-down'></i></span>
                                </div>
                                <ul class='list-items-type'>
                                    <?php
                                    foreach ($tabType as $key => $value) {
                                        if (is_array($value)) {
                                    ?>
                                            <li class='item'>
                                                <span class='checkbox'><i class='fa-solid fa-check check-icon'></i></span>
                                                <input type='hidden' name='typeList[]' value='".$value[0]."'><span class='item-text'> <?php echo $value[1]; ?></span></input>
                                            </li>
                                    <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                            <!-- IMAGE UPLOAD -->
                            <hr style='color:#fff;width:80%;'>
                            <br>
                            <div style='text-align:center;'>
                                <label for="image">Choisissez une image : </label>
                                <input id='image' type='file' name='image'></input>
                            </div>
                            <!-- <img src='src/img/movies/<?php //echo $value[4]; ?>' alt='Affiche'> -->
                            <br>
                            <div class="details">
                                <!-- SELECT MAKER -->
                                <p><span>Réalisateur :</span></p>
                                <!-- SELECT MAKER -->
                                <div class='multiple-select'>
                                    <div class='btn-select maker'>
                                        <span class='btn-text-maker'>Sélectionner </span>
                                        <span class='arrow-dwn'><i class='fa-solid fa-angle-down'></i></span>
                                    </div>
                                    <ul class='list-items-maker'>
                                        <?php
                                        foreach ($tabMaker as $key => $value) {
                                            if (is_array($value)) {
                                        ?>
                                                <li class='item'>
                                                    <input type='hidden' name='maker' value='".$value[0]."'><span class='item-text'> <?php echo $value[1]; ?></span></input>
                                                </li>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <p><span>Acteurs :</span></p>
                                <!-- SELECT ACTOR -->
                                <div class='multiple-select'>
                                    <div class='btn-select'>
                                        <span class='btn-text-actor'>Sélectionner</span>
                                        <span class='arrow-dwn'><i class='fa-solid fa-angle-down'></i></span>
                                    </div>
                                    <ul class='list-items-actor'>
                                        <?php
                                        foreach ($tabActor as $key => $value) {
                                            if (is_array($value)) {
                                        ?>
                                                <li class='item'>
                                                    <span class='checkbox'><i class='fa-solid fa-check check-icon'></i></span>
                                                    <input type='hidden' name='actorList[]' value='".$value[0]."'><span class='item-text'> <?php echo $value[1]; ?></span></input>
                                                </li>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <p><span>Durée : </span><input type='number' name='time' <?php if ($action != "Modify") { echo "placeholder='Durée...'"; } else { echo "value='".$movie[5]."'"; } ?>></input></p>
                                <p><textarea id='resume' name='resume' <?php if ($action != "Modify") { echo "placeholder='Description du film...'"; } ?>><?php if ($action == "Modify") { echo $movie[2]; } ?></textarea></p>
                            </div>
                        </div>
                    </div>
                </form>

            <?php
            } else {
            ?>

                <!-- SELECT SORT FORM -->
                <form action="controller.php" method="post">
                    <select name="sort" id="tri">
                        <option value="">------ Choisissez un tri ------</option>
                        <option <?php if (isset($_POST['sort']) && $_POST['sort'] == 'title-asc') { echo "selected='selected'"; } ?> value="title-asc">Titre - Croissant</option>
                        <option <?php if (isset($_POST['sort']) && $_POST['sort'] == 'title-desc') { echo "selected='selected'"; } ?> value="title-desc">Titre - Décroissant</option>
                        <option <?php if (isset($_POST['sort']) && $_POST['sort'] == 'year-asc') { echo "selected='selected'"; } ?> value="year-asc">Année - Croissant</option>
                        <option <?php if (isset($_POST['sort']) && $_POST['sort'] == 'year-desc') { echo "selected='selected'"; } ?> value="year-desc">Année - Décroissant</option>
                        <option <?php if (isset($_POST['sort']) && $_POST['sort'] == 'time-asc') { echo "selected='selected'"; } ?> value="time-asc">Durée - Croissant</option>
                        <option <?php if (isset($_POST['sort']) && $_POST['sort'] == 'time-desc') { echo "selected='selected'"; } ?> value="time-desc">Durée - Décroissant</option>
                        <option <?php if (isset($_POST['sort']) && $_POST['sort'] == 'real-asc') { echo "selected='selected'"; } ?> value="real-asc">Réalisateur - Croissant</option>
                        <option <?php if (isset($_POST['sort']) && $_POST['sort'] == 'real-desc') { echo "selected='selected'"; } ?> value="real-desc">Réalisateur - Décroissant</option>
                    </select>
                    <button class="sortBtn" type="submit" name='action' value='Sort'>Trier</button>
                </form>

            <?php
            }
            ?>

            <div id='grid-movie' class='grid'>
            
            <!-- MOVIES PANEL -->
                <?php
                    foreach($tab as $key => $value) {
                        if(is_array($value)) {
                ?>

                            <div class="movie-card">
                                <?php
                                if ($login == true) {
                                ?>
                                    <form action="login.php" method="post" enctype="multipart/form-data">
                                        <button type='submit' name='action' value='Delete'><i class='fa-solid fa-trash-can'></i></button>
                                        <button type='submit' name='action' value='Modify'><i class='fa-solid fa-pen-to-square'></i></button>
                                    </form>
                                <?php
                                }
                                ?>
                                <hr>
                                <h3><?php echo $value[1]; ?><span>(<?php echo $value[3]; ?>)</span></h3>
                                <p class='type'><?php echo $value[7]; ?></p>
                                <img src='src/img/movies/<?php echo $value[4]; ?>' alt='Affiche'>
                                <div class="details">
                                    <p><span>Réalisateur :</span> <?php echo $value[6]; ?></p>
                                    <p><span>Acteurs :</span> <?php echo $value[8]; ?></p>
                                    <p><span>Durée :</span> <?php echo displayHour($value[5]); ?></p>
                                    <p><?php echo $value[2]; ?></p>
                                </div>
                            </div>

                <?php 
                        }
                    } 
                ?>

            </div>

            <!-- PAGINATION -->
            <?php
            if ($page_max > 1) {
            ?>

                <div class="movie-card">
                    <form action="<?php if ($login == true) { echo "login.php"; } else { echo "#"; } ?>" method="post">
                        <button class='btn previous' type='submit' name='action' value='Précédent'><i class='fa-solid fa-angles-left'></i></button>
                        <button class='btn next' type='submit' name='action' value='Suivant'><i class='fa-solid fa-angles-right'></i></button>
                        <p class='page'><?php echo $page; ?> - <?php echo $page_max; ?></p>
                        <input type='hidden' name='page-id' value='<?php echo $page;?>'></input>
                    </form>
                </div>

            <?php
            }
            ?>

        </section>
        
        <!-- FOOTER -->
        <div class='air air1'></div>
        <div class='air air2'></div>
        <div class='air air3'></div>
        <div class='air air4'></div>
        <footer>
            <p class="footer-text"><i class="fa-regular fa-copyright"></i> | Thomas Stassart</p>
        </footer>

        <script src="src/js/model.js"></script>
        <script src="src/js/controller.js"></script>
        <!--<script src="src/js/select.js"></script>-->
        <script src="https://kit.fontawesome.com/1905ce4e1a.js" crossorigin="anonymous"></script>

    </body>
</html>