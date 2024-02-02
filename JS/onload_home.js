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

    // Add event listener to logout button
    var logoutButton = document.getElementById("logout_button");
    if (logoutButton) {
        logoutButton.addEventListener("click", function() {
            // Delete the welcome text permanently
            localStorage.removeItem("animationCompleted");
        });
    }
});


