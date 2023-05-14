<?php

date_default_timezone_set('Asia/Bangkok');

require_once __DIR__ . '/../../App/config/connectdb.php';
require_once __DIR__ . '/../../App/models/TarotCards.php';


if (!isset($_POST['action'])) {
    return false;
}

$card_key = isset($_POST['card_key']) ? $_POST['card_key'] : false;

if (!$card_key) {
    return false;
}


$TarotCards = new TarotCards();
$TarotCards->getShowTarotCardsOne($card_key);


?>

<style>
    .modal-fullscreen {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1050;
        overflow: auto;
        overflow-y: auto;
        background-color: #ffffff;
    }

    .modal-fullscreen .modal-dialog {
        margin: 0;
        max-width: 100%;
        height: 100%;
    }

    .modal-fullscreen .modal-content {
        height: 100%;
        border: 0;
        border-radius: 0;
    }
</style>


<!-- Fullscreen Modal -->
<div class="modal fade " id="showCard"  tabindex="-1" role="dialog" aria-labelledby="fullscreenModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-fullscreen modal-dialog-scrollable" style='width: 100%;'>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="fullscreenModalLabel">Fullscreen Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Modal content goes here -->
        <p>This is a fullscreen modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>