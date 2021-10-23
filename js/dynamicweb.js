//alert(4);
const typedTextSpan = document.querySelector(".typed-text");
const cursorSpan = document.querySelector(".cursor");

const textArry = ["Excellence Service..", "Delicious Meals..", "Door Step"];
const typingDelay = 150;
const erasingDelay = 100;
const newTextDelay = 50;
let textArryIndex = 0;
let charIndex = 0;

function type() {
//    alert(3);
    if (charIndex < textArry[textArryIndex].length) {
        if (!cursorSpan.classList.contains("typing"))
            cursorSpan.classList.add("typing");
        typedTextSpan.textContent += textArry[textArryIndex].charAt(charIndex);
        charIndex++;
        setTimeout(type, typingDelay);
    } else {
        cursorSpan.classList.remove("typing");
        setTimeout(erase, newTextDelay);
    }
}

function erase() {
//    alert(2);
    if (charIndex > 0) {
        if (!cursorSpan.classList.contains("typing"))
            cursorSpan.classList.add("typing");
        typedTextSpan.textContent = textArry[textArryIndex].substring(0, charIndex - 1);
        charIndex--;
        setTimeout(erase, newTextDelay);
    } else {
        textArryIndex++;
        cursorSpan.classList.remove("typing");
        if (textArryIndex >= textArry.length)
            textArryIndex = 0;
        setTimeout(type, typingDelay + 100);
    }
}

document.addEventListener("DOMContentLoaded", function () {
//    alert(1);
    if (textArry.length)
        setTimeout(type, newTextDelay + 250);
});