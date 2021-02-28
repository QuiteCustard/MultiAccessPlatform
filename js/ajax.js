// Show user table
function showUser(str) {
    if (str === "") {
        document.getElementById("ajaxContent").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("ajaxContent").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "users.php?q=" + str, true);
        xmlhttp.send();
    }

}
// Show Courses table
function showCourse(str) {
    if (str === "") {
        document.getElementById("ajaxContent").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("ajaxContent").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "courses.php?q=" + str, true);
        xmlhttp.send();
    }
}

//Delete user
//var jsonData = JSON.parse('<?= $jsonStr; ?>');
/*
document.ajax({
    type: "GET",
    url: 'users.php',
    success: function(data){
        alert(data);
    }
});
//Log the data to the console
console.log(jsonData);


function deleteUser() {
    alert(jsonData);
}
*/



/*var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
           xmlhttp.open("GET", "delete.php?q=jsonData", true);
           xmlhttp.send();*/
