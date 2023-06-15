const selectBtn = document.querySelectorAll("div.btn-select");
//console.log(selectBtn.length);
var singleItem = document.querySelectorAll('.list-items-maker li');
// Sélectionner tous les éléments "li" de la liste déroulante
var typeItems = document.querySelectorAll('.list-items-type li');
// Sélectionner tous les éléments "li" de la liste déroulante
var actorItems = document.querySelectorAll('.list-items-actor li');

selectBtn.forEach(function(btn) {
  btn.addEventListener('click', function() {
    openSelectButton(btn);
  });
});

// Add an event listener "click" on each element
singleItem.forEach(function(item) {
  item.addEventListener('click', function() {
    let selectedOtpion = item.querySelector(".item-text").innerText;
    let btnText = document.querySelector(".btn-text-maker");
    btnText.innerText = selectedOtpion;
    selectBtn.forEach(function(btn) {
        selectSingleItem(btn);
    });
  });
});

typeItems.forEach(function(item) {
  item.addEventListener('click', function() {
    selectMultipleItems(item);
  });
});

actorItems.forEach(function(item) {
  item.addEventListener('click', function() {
    selectMultipleItems(item);
  });
});