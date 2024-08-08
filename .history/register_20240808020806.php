<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <br><br>
    <div class="cont">
        <div class="form sign-in">
            <h2>Welcome Back</h2>
            <form action="action/registerAction.php" method="post" name="signin" id="signin" onsubmit="return validateSigninForm()">
                <!-- fail message -->
                <?php
                $fail = isset($_GET['fail']) ? $_GET['fail'] : null;
                if ($fail == 0) {
                    echo "<p style='color: red;'>User doesnt Exist</p>";
                }elseif($fail == 1){
                    echo "<p style='color: red;'>Password is incorrect</p>";
                }
                ?>
                <!-- email -->
                <label>
                    <span>Email</span>
                    <input type="email" name="email" required pattern="[a-zA-Z0-9._%+-]+@ashesi\.edu\.gh" required/>
                </label>
                <!-- password -->
                <label>
                    <span>Password</span>
                    <input type="password" name="password" required />
                </label>
                <p class="forgot-pass">Forgot password?</p>
                <button type="submit" name="login" class="submit">Sign In</button>
            </form>
        </div>
        <div class="sub-cont">
            <div class="img">
                <div class="img__text m--up">
                    <h3>Don't have an account? Please Sign up!</h3>
                </div>
                <div class="img__text m--in">
                    <h3>If you already have an account, just sign in.</h3>
                </div>
                <div class="img__btn">
                    <span class="m--up">Sign Up</span>
                    <span class="m--in">Sign In</span>
                </div>
            </div>
            <div class="form sign-up">
                <h2>Create your Account</h2>
                <div class="scrollable-box">
                <form action="action/registerAction.php" method="POST" name="signup" id="signup" onsubmit="return validateSignupForm()">
                    <!-- success message -->
                    <?php
                $success = $_GET['success'] ?? null;
                if ($success == 1) {
                    echo "<p style='color: green;'>Account created successfully.</p>";
                } elseif ($success == 0) {
                    echo "<p style='color: red;'>Failed to create account.</p>";
                } elseif ($success == 2) {
                    echo "<p style='color: red;'>Email already exists.</p>";
                } 
                ?>
                <!-- name -->
                    <label>
                        <span>Name</span>
                        <input type="text" name="name" required />
                    </label>
                    <!-- email -->
                    <label>
                        <span>Email</span>
                        <input type="email" name="email" required pattern="[a-zA-Z0-9._%+-]+@ashesi\.edu\.gh" required/>
                    </label>
                    <!-- major -->
                    <label>
                        <span>Major</span>
                        <select name="major" required>
                            <?php
                                
                               require 'subaction/major.php';
    

                            ?>
                        </select>
                    </label>
                    <!-- password -->
                    <label>
                        <span>Password</span>
                        <input type="password" name="password" required />
                    </label>
                    <!-- confirm password -->
                    <label>
                        <span>Confirm Password</span>
                        <input type="password" name="confirm_password" required />
                    </label>
                    <label>
                        <span>Role</span>
                        <select name="role" required>
                            <option value="2">Student</option>
                            <option value="3">Peer Tutor</option>
                            <option value="4">Faculty Intern</option>
                        </select>
                    </label>
                    <button type="submit" name="register" class="submit">Sign Up</button>
                </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('.img__btn').addEventListener('click', function() {
            document.querySelector('.cont').classList.toggle('s--signup');
        });

        function validateSigninForm() {
            var email = document.forms["signin"]["email"].value.trim();
            var password = document.forms["signin"]["password"].value;
            if (password.length < 8) {
                alert("Password must be at least 8 characters long.");
                return false;
            }
            return true;
        }

        function validateSignupForm() {
            var name = document.forms["signup"]["name"].value.trim();
            var password = document.forms["signup"]["password"].value;
            var confirmPassword = document.forms["signup"]["confirm_password"].value;

            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
