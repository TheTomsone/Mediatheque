const selectBtn = document.querySelectorAll("div.btn-select");
//console.log(selectBtn.length);

selectBtn.forEach(function(btn) {
  btn.addEventListener('click', function() {
    // Vérifier si l'option est déjà sélectionnée
    if (btn.classList.contains('open')) {
      // Si elle est sélectionnée, retirer la classe "selected"
      btn.classList.remove('open');
    } else {
      // Sinon, ajouter la classe "selected"
      btn.classList.add('open');
    }
  });
});

// Sélectionner tous les éléments "li" de la liste déroulante
var typeItems = document.querySelectorAll('.list-items-type li');

// Add an event listener "click" on each element
typeItems.forEach(function(item) {
  item.addEventListener('click', function() {
      // Check if option is selected and remove "selected" class
      if (item.classList.contains('selected-type')) {
        item.classList.remove('selected-type');
      }
      // Else, add "selected" class
      else {
        item.classList.add('selected-type');
      }

    let itemsSelectedType = document.querySelectorAll(".selected-type");
    let btnTextType = document.querySelector(".btn-text-type");
      
    if (itemsSelectedType && itemsSelectedType.length > 0) {
        if (itemsSelectedType.length == 1) {
          btnTextType.innerText = `${itemsSelectedType.length} Genre sélectionné`;
        }
        else {
          btnTextType.innerText = `${itemsSelectedType.length} Genres sélectionnés`;
        }
    }
    else {
      btnTextType.innerText = "Sélectionner Genre";
    }

  });
});

var singleItems = document.querySelectorAll('.list-items-maker li');

// Add an event listener "click" on each element
singleItems.forEach(function(item) {
  item.addEventListener('click', function() {
    let selectedOtpion = item.querySelector(".item-text").innerText;
    let btnText = document.querySelector(".btn-text-maker");
    btnText.innerText = selectedOtpion;
    selectBtn.forEach(function(btn) {
      // Vérifier si l'option est déjà sélectionnée
      if (btn.classList.contains('maker')) {
        // Si elle est sélectionnée, retirer la classe "selected"
        btn.classList.remove('open');
      }
    });
  });
});

// Sélectionner tous les éléments "li" de la liste déroulante
var actorItems = document.querySelectorAll('.list-items-actor li');

// Add an event listener "click" on each element
actorItems.forEach(function(item) {
  item.addEventListener('click', function() {
      // Check if option is selected and remove "selected" class
      if (item.classList.contains('selected-actor')) {
        item.classList.remove('selected-actor');
      }
      // Else, add "selected" class
      else {
        item.classList.add('selected-actor');
      }

    let itemsSelectedActor = document.querySelectorAll(".selected-actor");
    let btnText = document.querySelector(".btn-text-actor");
      
    if (itemsSelectedActor && itemsSelectedActor.length > 0) {
        if (itemsSelectedActor.length == 1) {
            btnText.innerText = `${itemsSelectedActor.length} sélectionné`;
        }
        else {
            btnText.innerText = `${itemsSelectedActor.length} sélectionnés`;
        }
    }
    else {
        btnText.innerText = "Sélectionner";
    }

  });
});