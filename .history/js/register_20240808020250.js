<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form Validation</title>
    <script>
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
    </script>
</head>
<body>
    <form name="signin" onsubmit="return validateForm()">
        <label for="fname">First Name:</label>
        <input type="text" id="fname" name="fname"><br><br>
        <label for="lname">Last Name:</label>
        <input type="text" id="lname" name="lname"><br><br>
        <label for="mail">Email:</label>
        <input type="email" id="mail" name="mail"><br><br>
        <label for="num">Phone Number:</label>
        <input type="text" id="num" name="num"><br><br>
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob"><br><br>
        <label>Gender:</label>
        <input type="radio" id="male" name="gender" value="male">
        <label for="male">Male</label>
        <input type="radio" id="female" name="gender" value="female">
        <label for="female">Female</label><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br><br>
        <label for="passconfirm">Confirm Password:</label>
        <input type="password" id="passconfirm" name="passconfirm"><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
