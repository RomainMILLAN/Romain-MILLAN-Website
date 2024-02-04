const mobileMenu = document.getElementById("mobile_nav-checkbox");
const nextButtonCircle = document.getElementById("next_button_circle");

mobileMenu.addEventListener("click", function() {
    if(nextButtonCircle.style.display !== "none"){
        nextButtonCircle.style.display = "none";
    }else {
        setTimeout(() => {
            nextButtonCircle.style.display = "block";
        }, 300);
    }

})