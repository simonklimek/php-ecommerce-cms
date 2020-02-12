// takes username and sends the info to the edit php file where the data corroesponding to the username is shown 
function edit() {
    var un = document.getElementById("loggeduser").value;
    var user = "update.php?username=" + un;
    
    // link made with given username for edit page
    document.getElementById("editButton").href = user;
    console.log(user);
}