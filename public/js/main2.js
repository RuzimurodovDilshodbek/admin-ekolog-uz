const themeStitcher = document.getElementById("themingSwitcher");
const isSystemThemeSetToDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
const darkIcon = document.querySelectorAll('.darkIcon')
const lightIcon = document.querySelectorAll('.lightIcon')
const progressCircle = document.querySelector(".autoplay-progress svg");
const progressContent = document.querySelector(".autoplay-progress span");

if (isSystemThemeSetToDark) {
    themeStitcher.checked = false;
}

themeStitcher.addEventListener("click", (e) => {
    themeStitcher.checked = !themeStitcher.checked;
    toggleTheme(themeStitcher.checked);
});

const changeIcon = (color) => {
    if (color == "dark") {
        darkIcon.forEach(e => e.classList.add('d-block'))
        darkIcon.forEach(e => e.classList.remove('d-none'))
        lightIcon.forEach(e => e.classList.add('d-none'))
        lightIcon.forEach(e => e.classList.remove('d-block'))
    } else {
        lightIcon.forEach(e => e.classList.remove('d-none'))
        lightIcon.forEach(e => e.classList.add('d-block'))
        darkIcon.forEach(e => e.classList.add('d-none'))
        darkIcon.forEach(e => e.classList.remove('d-block'))
    }
}

const toggleTheme = (isChecked) => {
    const theme = isChecked ? "dark" : "light";
    document.documentElement.dataset.mdbTheme = theme;
    changeIcon(theme)
}

// add listener to toggle theme with Shift + D
document.addEventListener("keydown", (e) => {
    if (e.shiftKey && e.key === "D") {
        themeStitcher.checked = !themeStitcher.checked;
        toggleTheme(themeStitcher.checked);
    }
});

import Swiper from 'swiper/bundle';
let swiper = new Swiper(".mySwiper", {
    spaceBetween: 30,
    centeredSlides: true,
    autoplay: {
        delay: 5000,
        disableOnInteraction: false
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev"
    },
    on: {
        autoplayTimeLeft(s, time, progress) {
            progressCircle.style.setProperty("--progress", 1 - progress);
        }
    }
});

