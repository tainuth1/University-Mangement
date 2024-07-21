<?php
include 'sidebar.php';

$getUser = $_GET['studentID'];
$stmt = connection()->prepare("SELECT * FROM student WHERE student_id = ?");
$stmt->execute([$getUser]);
$row = $stmt->fetch();
?>
<link rel="stylesheet" href="css/student-profile.css">

<div class="dashboard-content">
    <div class="title-locate">
        <div class="title">
            <h2>Edit Student Profile</h2>
        </div>
        <div class="locate">
            <p>Student / <span>Edit Profile</span></p>
        </div>
    </div>
    <div class="edit-content-wrapper">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="input-field-wrap">
                <div class="">
                    <label for="">First Name:</label><br>
                    <input required class="input-info edit-profile" type="text" name="firstName"
                        value="<?= $row['firstName'] ?>">
                </div>
                <div class="">
                    <label for="">Last Name: </label><br>
                    <input required class="input-info edit-profile" type="text" name="lastName"
                        value="<?= $row['lastName'] ?>">
                </div>
                <div class="">
                    <label for="">Gender: </label><br>
                    <select required name="gender" class="input-info" id="">
                        <option></option>
                        <option value="Male" <?= ($row['gender']) == 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= ($row['gender']) == 'Female' ? 'selected' : '' ?>>Female</option>
                    </select>
                </div>
                <div class="">
                    <label for="">Date Of Birth: </label><br>
                    <input required class="input-info edit-profile" type="date" name="dob"
                        value="<?= $row['dateOfBirth'] ?>">
                </div>
                <div class="">
                    <label for="">Email: </label><br>
                    <input required class="input-info edit-profile" type="email" name="email"
                        value="<?= $row['email'] ?>">
                </div>
                <div class="">
                    <label for="">Phone Number: </label><br>
                    <input required class="input-info edit-profile" type="phone" name="phone"
                        value="<?= $row['phone'] ?>">
                </div>
                <div class="">
                    <label for="profile">Profile:</label>
                    <input class="input-info" type="file" name="profile" id="profile">
                    <input class="input-info" type="hidden" name="old-profile" value="<?= $row['profile'] ?>">
                </div>
            </div>
            <div class="btn-wrapper">
                <button class="create-btn" type="submit" name="update">Update</button>
                <!-- <button name="cancel-edit">Cancel</button> -->
                <a href="student-profile.php?studentID=<?= $row['student_id'] ?>" class="cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>
<div class="footer footer-student">
    <h2>University | © Copyright</h2>
</div>
</section>
</body>
<script src="javascript/script.js"></script>

</html>