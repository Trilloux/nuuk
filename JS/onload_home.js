document.addEventListener("DOMContentLoaded", function() {
    var welcomeText = document.querySelector("#welcome p");

    // Check if animation is already completed
    var animationCompleted = localStorage.getItem("animationCompleted");

    // If animation is not completed
    if (!animationCompleted) {
        setTimeout(function() {
            console.log("Animation started!");
            welcomeText.style.opacity = "1";
            welcomeText.style.transform = "translateY(0)";

            // Log the computed styles to see if they are applied correctly
            console.log("Computed styles:", window.getComputedStyle(welcomeText));

            // Store info that animation is completed permanently
            localStorage.setItem("animationCompleted", "true");
        }, 500); // delay 500 ms
    } else {
        // If animation is completed, store welcome text to be visible
        welcomeText.style.opacity = "1"; // visible
        welcomeText.style.transform = "translateY(0)"; // no more movement
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
        localStorage.removeItem("animationCompleted");
        //localStorage.removeItem("scrollpos");
        window.scrollTo (0, 0);
    });
});



    
