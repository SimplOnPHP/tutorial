$(document).ready(function() {
  var $overlay = $(".page-overlay");
  var $message = $(".message");
  var $messageText = $(".messageText");
  var $showMessageButton = $(".show-message-button");
  var position = $showMessageButton.offset(); 


  function cleanMessage() { $messageText.text(''); }

  function showMessage(message='') {
    if(message.length > 0 ){ $messageText.text(message);}
    if($messageText.text().trim().length > 0 ){
      $overlay.fadeIn();
      $message.animate({
        fontSize: "2rem",
        width: "90vw",
        padding: "0.25rem",
        left: "50vw",
        top: "30vh"
      }, 700 );
    }else{
        $message.css('display', 'none');
        $overlay.css('display', 'none'); 
    }
  }
  
  function hideMessage() {
    $overlay.fadeOut();
    $message.animate({
      fontSize: "0rem",
      width: "0vw",
      padding: "0rem",
      left: position ? position.left + 'px' : '0px', 
      top: position ? position.top + 'px' : '0px' 
    }, 700 );

    var currentUrl = window.location.href;
    var newUrl = currentUrl.split('!!')[0];
    history.pushState({}, '', newUrl);
  }

  $(document).click(function(event) {
    if ($overlay.is(event.target)) {
      hideMessage();
    }
  });

  $message.find(".close").click(function() {
    hideMessage();
  });

  $showMessageButton.click(function() {
    showMessage();
  });
  
  // Initial positioning
  if (position) {
    $message.css({
      'top': position.top + 'px',    // Added px unit
      'left': position.left + 'px'   // Added px unit
    });
  }
  
  showMessage('');

  setTimeout(function(){
    hideMessage();
  }, 2000);
});
