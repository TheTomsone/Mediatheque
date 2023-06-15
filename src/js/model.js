/* Function ajax for adding new type, acotr and maker */
function loadList(id, selectTab) {
    if(id!='0'){
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            good= this.responseText; //json
            obj = JSON.parse(good);
            select=document.getElementById(selectTab);
            select.innerHTML="";
            for(let i in obj.movie-maker) {
                opt = document.createElement("option");
                opt.value = obj.movie-maker[i].id;// PK du genre ajouté
                opt.text = obj.movie-maker[i].nom;

                select.add(opt, null);
            }
        }
        xhttp.open("POST", "login.php");
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send("id="+id);
    }
}

/* Function who open and close select button list */
function openSelectButton(btn) {
    // Check if already open
    if (btn.classList.contains('open')) {
        // If open, remove class "open"
        btn.classList.remove('open');
    } else {
        // Else, add class "open"
        btn.classList.add('open');
    }
}

/* Function who select a single item in a single select button */
function selectSingleItem(item) {
    // Vérifier si l'option est déjà sélectionnée
    if (btn.classList.contains('maker')) {
        // Si elle est sélectionnée, retirer la classe "selected"
        btn.classList.remove('open');
    }
}

/* Function who select multiple items in a multiple select button */
function selectMultipleItems(item) {
    // Check if option is selected and remove "selected" class
    if (item.classList.contains('selected-type')) {
        item.classList.remove('selected-type');
    }
    // Else, add "selected" class
    else {
        item.classList.add('selected-type');
    }
}