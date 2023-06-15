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