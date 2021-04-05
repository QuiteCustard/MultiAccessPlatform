// Check if page has been loaded
if (localStorage.getItem("page") != null) {
    document.documentElement.setAttribute('data-toggle', localStorage.getItem("page"));
}