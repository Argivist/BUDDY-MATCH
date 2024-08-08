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
                field.focu
