// If theme is already set, load theme
if (localStorage.getItem("theme") != null) {
    document.documentElement.setAttribute('data-theme', localStorage.getItem("theme"));
}
