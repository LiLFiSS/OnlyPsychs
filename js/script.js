
// Hide and Show Password
const eyeIcons = document.querySelectorAll(".show-hide");

eyeIcons.forEach(eyeIcon => {
    eyeIcon.addEventListener("click", () => {
        const pInput = eyeIcon.parentElement.querySelector("input");
        if (pInput.type === "password"){
            eyeIcon.classList.replace("bx-hide", "bx-show-alt");
            return (pInput.type = "text");
        }
        eyeIcon.classList.replace("bx-show-alt", "bx-hide");
        return (pInput.type = "password");
    });
});









