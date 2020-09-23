tries=0;
initRequired = true;
jQuery(function() {
  uponResize();

  jQuery('.no-hover').parent('a').addClass('no-hover-a'); // removing the hover-animation

  jQuery(window).resize(uponResize);
});

function uponResize() {
  windowSize();
  let waiter;
  if(windowWidth <= 720) {
    // Mobile filtering
    if( jQuery(".main-filter").length && jQuery("body.has-filters").length === 0) {
      jQuery("body").addClass("has-filters");
    }
    // Filter toggle
    jQuery(".has-filters a.toggle-filter").unbind('click').click(function(e) {
      e.preventDefault();
      jQuery("#secondary").fadeToggle(100);
      jQuery('.js-dgwt-wcas-om-return').trigger('click');
    });
    jQuery(".has-filters .bapf_update").unbind('click').click(function(e) {
      jQuery("#secondary").fadeToggle(100);
    });
    // Search button
    waiter = waitForEl('.dgwt-wcas-search-wrapp', attachSearchClose, stopSearchCloseAttaching);
  } else if(waiter) {
    clearInterval(waiter);
    tries = 0;
  }
}

///////////
// MISC

// Attaching the close function on the search menu button
function attachSearchClose() {
  jQuery('.js-dgwt-wcas-enable-mobile-form').click(function(e) {
    jQuery('.js-dgwt-wcas-om-hook').unbind('click').click(function(e) {
      jQuery('.js-dgwt-wcas-om-return').trigger('click');
    });
  });
  initRequired = false;
}
function stopSearchCloseAttaching() {
  return (!initRequired || (tries >= 30));
}

function waitForEl(selector, callback, stopper) {
  var poller1 = setInterval(function(limit) {
    let stopCondition = stopper();
    if(!stopCondition) {
      tries++;
      $jObject = jQuery(selector);
      if($jObject.length < 1) {
        return;
      }
    }
    clearInterval(poller1);
    tries = 0;
    callback($jObject)
  }, 100);
  return poller1;
}

function windowSize() {
  windowHeight = window.innerHeight ? window.innerHeight : jQuery(window).height();
  windowWidth = window.innerWidth ? window.innerWidth : jQuery(window).width();
}
