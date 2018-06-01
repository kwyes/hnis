<link rel="stylesheet" href="css/card.css?ver=1">
<script src="js/card.js?ver=1"></script>

  <div class="col-md-11 md-long-width" style="margin-top:10%;">
    <div class="cards-wrapper">
      <div class="card-wrapper">
        <div class="card-1 card-object card-object-hf" id="bby">
          <a class="face front" href="#">
            <div class="title-wrapper">
              <div class="title">Burnaby</div>
              <div class="subtitle">Hannam Burnaby</div>
            </div>
          </a>
          <a class="face back" href="#">
            <div class="img-wrapper">
              <div class="avatar"></div>
            </div>
            <div class="info-wrapper">
              <div class="info-title">Burnaby</div>
              <div class="info-content">
                <address class="">
                  4501 North Rd #106, Burnaby, BC V3N 4R7
                </address>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="card-wrapper">
        <div class="card-2 card-object card-object-hf" id="sry">
          <a class="face front" href="#">
            <div class="title-wrapper">
              <div class="title">Surrey</div>
              <div class="subtitle">Hannam Surrey</div>
            </div>
          </a>
          <a class="face back" href="#">
            <div class="img-wrapper">
              <div class="avatar"></div>
            </div>
            <div class="info-wrapper">
              <div class="info-title">Surrey</div>
              <div class="info-content">
                <address class="">
                  15357 104 Ave #1, Surrey, BC V3R 1N5
                </address>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="card-wrapper">
        <div class="card-3 card-object card-object-hf" id="dt">
          <a class="face front" href="#">
            <div class="title-wrapper">
              <div class="title">Downtown</div>
              <div class="subtitle">Hannam Downtown</div>
            </div>
          </a>
          <a class="face back" href="#">
            <div class="img-wrapper">
              <div class="avatar"></div>
            </div>
            <div class="info-wrapper">
              <div class="info-title">Downtown</div>
              <div class="info-content">
                <address class="">
                  DT Address soon
                </address>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript">
  var $cards = $('.card-object'),
  $faceButtons = $('.face');
  $faceButtons.on('click', flipCard);
</script>
