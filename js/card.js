function flipCard(event) {
  event.preventDefault();
  var $btnFace = $(this),
  $card = $btnFace.parent('.card-object'),
  $com = $card.attr('id');

  if($card.hasClass('flip-in')) {
    closeCards();
  } else {
    closeCards();
    openCard($card);
    setTimeout(function() {
        var Window = window.open("?page=frame&menu=neworderitem&branch=" + $com, "_self");
    }, 2000);
  }
}

function closeCards() {
  $cards
  .filter('.flip-in')
  .removeClass('flip-in')
  .addClass('flip-out');
}

function openCard($card) {
  $card
  .removeClass('flip-out')
  .addClass('flip-in');
}
