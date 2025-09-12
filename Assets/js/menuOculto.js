window.nav = {
  status: false,
  menu: function(){
    if (nav.status){
      // here put class when menu is open - eg:
      document.getElementById("menu-box").className = "menu-box menuopen";
      nav.status = false;
    } else {
      // here put class when menu is closed - eg:
      document.getElementById("menu-box").className = "menu-box";
      nav.status = true;
    } 
  }
}