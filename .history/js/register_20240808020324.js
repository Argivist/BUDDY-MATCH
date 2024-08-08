function validateForm() {
    // Get form inputs
    var form = document.forms["signin"];
    var fname = form["fname"].value.trim();
    var lname = form["lname"].value.trim();
    var mail = form["mail"].value.trim();
    var phoneNumber = form["num"].value.trim();
    var dob = form["dob"].value.trim();
    var gender = form["gender"];
    var password = form["password"].value;
    var passconfirm = form["passconfirm"].value;

    // Regular expressions for validation
    var nameRegex = /^[a-zA-Z]+$/;
    var emailRegex = /^[a-zA-Z0-9._%+-]+@ashesi\.edu\.gh$/;
    var phoneRegex = /^[0-9]{10,20}$/;
    var passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;

    // Helper function to show alert and focus on the field
    function showError(message, field) {
        alert(message);
        field.focus();
        return false;
    }

    // Validation checks
    if (!fname.match(nameRegex)) {
        return showError("Please enter a valid first name.", form["fname"]);
    }
    if (!lname.match(nameRegex)) {
        return showError("Please enter a valid last name.", form["lname"]);
    }
    if (!mail.match(emailRegex)) {
        return showError("Please enter a valid email address.", form["mail"]);
    }
    if (!phoneNumber.match(phoneRegex)) {
        return showError("Please enter a valid phone number.", form["num"]);
    }
    if (!dob) {
        return showError("Please select your date of birth.", form["dob"]);
    }
    if (!Array.from(gender).some(radio => radio.checked)) {
        alert("Please select your gender.");
        return false;
    }
    if (!password.match(passwordRegex)) {
        return showError("Password must contain at least 8 characters, including one uppercase letter, one lowercase letter, and one number.", form["password"]);
    }
    if (password !== passconfirm) {
        return showError("Passwords do not match.", form["passconfirm"]);
    }

    // Display success message
    alert("Registration successful!");
    return true;
}