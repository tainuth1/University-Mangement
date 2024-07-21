<?php 
    include 'sidebar.php';

    $id_to_update = $_GET['teacherID'];
    $stmt = connection()->prepare("SELECT * FROM teacher WHERE teacher_id = ?");
    $stmt->execute([$id_to_update]);
    $row = $stmt->fetch();
?>
<link rel="stylesheet" href="css/student-profile.css">

        <div class="dashboard-content">
            <div class="title-locate">
                <div class="title">
                    <h2>Edit Teacher Profile</h2>
                </div>
                <div class="locate">
                    <p>Teacher / <span>Edit Profile</span></p>
                </div>
            </div>
            <div class="edit-content-wrapper">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="input-field-wrap">
                        <div class="">
                            <label for="">First Name:</label><br>
                            <input class="input-info edit-profile " type="text" name="first_name" value="<?= $row['firstName'] ?>">
                        </div>
                        <div class="">
                            <label for="">Last Name: </label><br>
                            <input class="input-info edit-profile"  type="text" name="last_name" value="<?= $row['lastName'] ?>">
                        </div>
                        <div class="">
                            <label for="">Gender: </label><br>
                            <select name="gender" class="input-info edit-profile" id="">
                                <option value=""></option>
                                <option value="Male" <?= $row['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= $row['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                            </select>
                        </div>
                        <div class="">
                            <label for="">Date Of Birth: </label><br>
                            <input class="input-info edit-profile" type="date" name="birth_date" value="<?= $row['dateOfBirth'] ?>">
                        </div>
                        <div class="">
                            <label for="">Email: </label><br>
                            <input class="input-info edit-profile" type="email" name="email" value="<?= $row['email'] ?>">
                        </div>
                        <div class="">
                            <label for="">Phone Number: </label><br>
                            <input class="input-info edit-profile" type="phone" name="phone" value="<?= $row['phone'] ?>">
                        </div>
                        <div class="">
                            <label for="">Address: </label><br>
                            <input class="input-info edit-profile" type="text" name="address" value="<?= $row['address'] ?>">
                        </div>
                        <div class="">
                            <label for="">Role:</label><br>
                            <select name="role" class="input-info edit-profile" id="">
                                <option></option>
                                <option value="Admin" <?= $row['role'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="Administrator" <?= $row['role'] == 'Administrator' ? 'selected' : '' ?>>Administrator</option>
                                <option value="Teacher" <?= $row['role'] == 'Teacher' ? 'selected' : '' ?>>Teacher</option>
                                <option value="Developer" <?= $row['role'] == 'Developer' ? 'selected' : '' ?>>Developer</option>
                                <option value="Assistant" <?= $row['role'] == 'Assistant' ? 'selected' : '' ?>>Assistant</option>
                                <option value="Analysis" <?= $row['role'] == 'Analysis' ? 'selected' : '' ?>>Analysis</option>
                            </select>
                        </div>
                        <div class="">
                            <label for="profile">Profile:</label>
                            <input class="input-info" type="file" name="profile" id="profile">
                            <input class="input-info" type="hidden" name="old-profile" value="<?= $row['profile'] ?>">
                        </div>
                    </div>
                    <div class="btn-wrapper">
                        <button class="create-btn" name="teacher" type="submit">Update</button>
                        <!-- <button name="cancel-edit">Cancel</button> -->
                        <a href="teacher-profile.php?teacherID=<?= $row['teacher_id'] ?>" class="cancel">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="footer">
            <h2>University | ©Copyright</h2>
        </div>
    </section>
</body>
<script src="javascript/script.js"></script>
</html>