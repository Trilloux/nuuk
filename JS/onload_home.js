document.addEventListener("DOMContentLoaded", function() {
    var welcomeText = document.querySelector("#welcome p");

    // Pārbaudiet, vai lietotājs ir ielogojies pirmo reizi, izmantojot sesijas uzglabāšanu
    var isFirstLogin = sessionStorage.getItem("firstLogin");

    // Ja lietotājs ielogojies pirmo reizi
    if (!isFirstLogin) {
        // Pievienojiet animācijas klasi
        welcomeText.classList.add("animated");

        // Saglabājiet informāciju, ka lietotājs ir ielogojies pirmo reizi
        sessionStorage.setItem("firstLogin", true);
    }
   
  
    // Restore scroll position on DOMContentLoaded
    var scrollpos = localStorage.getItem("scrollpos");
    if (scrollpos) window.scrollTo(0, parseInt(scrollpos));
  
    // Save scroll position before unloading
    window.onbeforeunload = function(e) {
      localStorage.setItem("scrollpos", window.scrollY);
    };
    
    // Add event listener to logout button
    var logoutButton = document.getElementById("logout_link");
logoutButton.addEventListener("click", function() {
    // Remove the information about the first login when logging out
    sessionStorage.removeItem("firstLogin");
          
      // Scroll page to top when logging out 
      window.scrollTo (0, 0);
    });
  });



    
