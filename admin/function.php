<?php

function successAlert($errorName){
    echo '
        <div class="alert success-alert" id="alert-box">
            <div class="message">
                <i class="bx bxs-check-circle"></i>
                <p>'.$errorName.'</p>
            </div>
            <button id="hide">
                <i class="bx bx-x"></i>
            </button>
        </div>
        ';
}
function falseAlert($errorName){
    echo '
        <div class="alert success-alert" id="alert-box">
            <div class="message">
                    <i class="bx bxs-x-circle"></i>
                <p>'.$errorName.'</p>
            </div>
            <button id="hide">
                <i class="bx bx-x"></i>
            </button>
        </div>
        ';
}

function updateAdmin(){
    
    if(isset($_POST['admin'])){
        $idToUpdate = $_GET['adminID'];
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $gender = $_POST['gender'];
        $dob = $_POST['dateOfBirth'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $role = $_POST['role'];
        $oldProfile = $_POST['old-profile'];
        
        if (isset($_FILES['profile']) && $_FILES['profile']['error'] == UPLOAD_ERR_OK) {
            $profile = $_FILES['profile']['name'];
            $path = 'profile/'.$oldProfile;
            if(file_exists($path)){
                unlink($path);
            }
            move_uploaded_file($_FILES['profile']['tmp_name'], 'profile/' . $profile);
        } else {
            $profile = $oldProfile;
        }

        if(!empty($firstName) && !empty($lastName) && !empty($gender) && !empty($dob) && !empty($address) && !empty($email) && !empty($role) && !empty($phone)){
            $updateStmt = connection()->prepare("UPDATE admin SET firstName = ?, lastName = ?, gender = ?, dateOfBirth = ?, email = ?, phone = ?, address = ?, role = ?, profile = ? WHERE admin_id = ?");
            if($updateStmt->execute([$firstName, $lastName, $gender, $dob, $email, $phone, $address, $role, $profile, $idToUpdate])){
                $_SESSION['alert'] = 'Update Admin Information Successfully.';
                $_SESSION['alert_type'] = 'success';
                header("Location: profile.php?id=".$idToUpdate);
                exit();
            }else{
                $_SESSION['alert'] = 'Update Admin Information False!';
                $_SESSION['alert_type'] = 'false';
            }
        }else{
            $_SESSION['alert'] = 'Please fill out all field!';
            $_SESSION['alert_type'] = 'false';
        }
    }

}
updateAdmin();

function createDepartment(){
    if(isset($_POST['create-dp'])){
        $dep_name = $_POST['dp_name'];
        $dep_head = $_POST['dp_head'];
        if(!empty($dep_name) || !empty($dep_head)){
            $stmt = connection()->prepare("INSERT INTO department (departmentName, departmentHead) VALUES(?, ?)");
            if($stmt->execute([$dep_name, $dep_head])){
                $_SESSION['alert'] = 'Create Department Successfully.';
                $_SESSION['alert_type'] = 'success';
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }else{
                $_SESSION['alert'] = 'Create Department False!';
                $_SESSION['alert_type'] = 'false';
            }
        }else{
            $_SESSION['alert'] = 'Please Fill Out All Field';
            $_SESSION['alert_type'] = 'false';
        }
    }
}
createDepartment();


function updateDepartment(){

    if(isset($_POST['update-dp'])){
        $id_to_update = $_GET['id'];
        $dep_name = $_POST['dp_name'];
        $dep_head = $_POST['dp_head'];
        if(!empty($dep_name) || !empty($dep_head)){
            $stmt = connection()->prepare("UPDATE department SET departmentName = ? , departmenthead = ? WHERE department_id = ?");
            if($stmt->execute([$dep_name, $dep_head, $id_to_update])){
                $_SESSION['alert'] = 'Update Department Successfully.';
                $_SESSION['alert_type'] = 'success';
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }else{
                $_SESSION['alert'] = 'Update Department False!';
                $_SESSION['alert_type'] = 'false';
            }
        }else{
            $_SESSION['alert'] = 'Please Fill Out All Field';
            $_SESSION['alert_type'] = 'false';
        }
    }
}
updateDepartment();

function deleteDepartment(){
    if(isset($_POST['delete_dp'])){
        $idToDelete = $_POST['delete_dp'];
        $stmt = connection()->prepare("DELETE FROM department WHERE department_id = ?");
        if($stmt->execute([$idToDelete])){
            $_SESSION['alert'] = 'Delete Department Successfully.';
            $_SESSION['alert_type'] = 'success';
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }else{
            falseAlert("Delete Department False!");
        }
    }
}
deleteDepartment();
 
function addTeacher(){

    if(isset($_POST['add-teacher'])){
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $gender = $_POST['gender'];
        $dob = $_POST['birth_date'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $role = $_POST['role'];

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            falseAlert('Not not validate!');
            return;
        }

        if(!empty($firstName) || !empty($lastName) || !empty($gender) || !empty($dob) || !empty($address) || !empty($email) || !empty($role) || !empty($phone)){
            $stmt = connection()->prepare("INSERT INTO teacher (firstName, lastName, gender, email, phone, dateOfBirth, address, role) 
                                                        VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
            if($stmt->execute([$firstName, $lastName, $gender, $email, $phone, $dob, $address, $role])){
                $_SESSION['alert'] = 'Add Teacher Successfully.';
                $_SESSION['alert_type'] = 'success';
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }else{
                falseAlert('Add Teacher False!');
            }
        }else{
            falseAlert('Please Fill All Fields.');
        }
    }

}
addTeacher();

function updateTeacher(){
    
    if(isset($_POST['update-teacher'])){
        $idToUpdate = $_GET['id_update'];
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $gender = $_POST['gender'];
        $dob = $_POST['birth_date'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $role = $_POST['role'];

        if(!empty($firstName) || !empty($lastName) || !empty($gender) || !empty($dob) || !empty($address) || !empty($email) || !empty($role) || !empty($phone)){
            $updateStmt = connection()->prepare("UPDATE teacher SET firstName = ?, lastName = ?, gender = ?, dateOfBirth = ?, email = ?, phone = ?, address = ?, role = ? WHERE teacher_id = ?");
            if($updateStmt->execute([$firstName, $lastName, $gender, $dob, $email, $phone, $address, $role, $idToUpdate])){
                $_SESSION['alert'] = 'Update teacher data Successfully.';
                $_SESSION['alert_type'] = 'success';
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }else{
                $_SESSION['alert'] = 'Update teacher data False!';
                $_SESSION['alert_type'] = 'false';
            }
        }else{
            $_SESSION['alert'] = 'Please fill out all field!';
            $_SESSION['alert_type'] = 'false';
        }
    }

}
updateTeacher();

function updateTeacherProfile(){
    
    if(isset($_POST['teacher'])){
        $idToUpdate = $_GET['teacherID'];
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $gender = $_POST['gender'];
        $dob = $_POST['birth_date'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $role = $_POST['role'];
        $oldProfile = $_POST['old-profile'];
        
        if (isset($_FILES['profile']) && $_FILES['profile']['error'] == UPLOAD_ERR_OK) {
            $profile = $_FILES['profile']['name'];
            move_uploaded_file($_FILES['profile']['tmp_name'], 'profile/' . $profile);
            $path = 'profile/'.$oldProfile;
            if(file_exists($path)){
                unlink($path);
            }
        } else {
            $profile = $oldProfile;
        }

        if(!empty($firstName) || !empty($lastName) || !empty($gender) || !empty($dob) || !empty($address) || !empty($email) || !empty($role) || !empty($phone)){
            $updateStmt = connection()->prepare("UPDATE teacher SET firstName = ?, lastName = ?, gender = ?, dateOfBirth = ?, email = ?, phone = ?, address = ?, role = ?, profile = ? WHERE teacher_id = ?");
            if($updateStmt->execute([$firstName, $lastName, $gender, $dob, $email, $phone, $address, $role, $profile, $idToUpdate])){
                $_SESSION['alert'] = 'Update teacher data Successfully.';
                $_SESSION['alert_type'] = 'success';
                header("Location: teacher-profile.php?teacherID=".$idToUpdate);
                exit();
            }else{
                $_SESSION['alert'] = 'Update teacher data False!';
                $_SESSION['alert_type'] = 'false';
            }
        }else{
            $_SESSION['alert'] = 'Please fill out all field!';
            $_SESSION['alert_type'] = 'false';
        }
    }

}
updateTeacherProfile();

function deleteTeacher(){
    if(isset($_POST['delete-teacher'])){
        $idToDelete = $_POST['delete-teacher'];
        $stmt = connection()->prepare("DELETE FROM teacher WHERE teacher_id = ?");
        if($stmt->execute([$idToDelete])){
            $_SESSION['alert'] = 'Delete Successfully.';
            $_SESSION['alert_type'] = 'success';
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }else{
            $_SESSION['alert'] = 'Delete teacher False!';
            $_SESSION['alert_type'] = 'false';
        }
    }
}
deleteTeacher();

function createClass(){

    if(isset($_POST['create-class'])){
        $className = $_POST['class-name'];
        $department = $_POST['department'];
        $studyTime = $_POST['study-time'];

        if(!empty($className) && !empty($department) && !empty($studyTime)){
            $stmt = connection()->prepare("INSERT INTO class (className, department_id, studyTime) VALUES(?, ?, ?)");

            if($stmt->execute([$className, $department, $studyTime])){
                $_SESSION['alert'] = 'Create Class Successfully.';
                $_SESSION['alert_type'] = 'success';
                header('Location: '. $_SERVER['PHP_SELF']);
                exit();
            }else{
                $_SESSION['alert'] = 'Create Class False!';
                $_SESSION['alert_type'] = 'false'; 
            }
        }else{
            $_SESSION['alert'] = 'Please Fill Out/Select All Field.';
            $_SESSION['alert_type'] = 'false'; 
        }
    }

}
createClass();

function updateClass(){
    if(isset($_POST['update-class'])){
        $id_to_update = $_GET['id'];
        $className = $_POST['class-name'];
        $department = $_POST['department'];
        $studyTime = $_POST['study-time'];

        if(!empty($className) && !empty($department) && !empty($studyTime)){
            $stmt = connection()->prepare("UPDATE class SET className = ?, department_id = ?, studyTime = ? WHERE class_id = ?");

            if($stmt->execute([$className, $department, $studyTime, $id_to_update])){
                $_SESSION['alert'] = 'Update Class Successfully.';
                $_SESSION['alert_type'] = 'success';
                header('Location: '. $_SERVER['PHP_SELF']);
                exit();
            }else{
                $_SESSION['alert'] = 'Update Class False!';
                $_SESSION['alert_type'] = 'false'; 
            }
        }else{
            $_SESSION['alert'] = 'Please Fill Out/Select All Field.';
            $_SESSION['alert_type'] = 'false'; 
        }
    }
}
updateClass();

function deleteClass(){
    if(isset($_POST['delete-class'])){
        $id_to_delete = $_POST['delete-class'];
        $stmt = connection()->prepare("DELETE FROM class WHERE class_id = ?");
        if($stmt->execute([$id_to_delete])){
            $_SESSION['alert'] = 'Delete Class Successfully.';
            $_SESSION['alert_type'] = 'success';
            header('Location: '. $_SERVER['PHP_SELF']);
            exit();
        }else{
            $_SESSION['alert'] = 'Delete Class False!';
            $_SESSION['alert_type'] = 'false'; 
        }
    }
}
deleteClass();

function addStudent(){
    if(isset($_POST['add-student'])){
        $firstName = $_POST['first-name'];
        $lastName = $_POST['last-name'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $department = $_POST['department'];
        $class = $_POST['class'];

        if (!empty($firstName) && !empty($lastName) && !empty($gender) && !empty($dob) && !empty($email) && !empty($phone) && !empty($department) && !empty($class)) {
            $stmt = connection()->prepare("INSERT INTO student (firstName, lastName, gender, dateOfBirth, email, phone, class_id, department_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$firstName, $lastName, $gender, $dob, $email, $phone, $class, $department])) {
                $_SESSION['alert'] = 'Add Student Successfully.';
                $_SESSION['alert_type'] = 'success';
                header('Location: createStudent.php');
                exit();
            } else {
                $_SESSION['alert'] = 'Add Student False!';
                $_SESSION['alert_type'] = 'false';
            }
        } else {
            $_SESSION['alert'] = 'Please Fill/Select All Field.';
            $_SESSION['alert_type'] = 'false';
        }
    }
}
addStudent();

function updateStudent(){
    if(isset($_POST['update-student'])){
        $id_to_update = $_GET['update'];
        $firstName = $_POST['first-name'];
        $lastName = $_POST['last-name'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $department = $_POST['department'];
        $class = $_POST['class'];

        if (!empty($firstName) && !empty($lastName) && !empty($gender) && !empty($dob) && !empty($email) && !empty($phone) && !empty($department) && !empty($class)) {
            $stmt = connection()->prepare("UPDATE student SET firstName = ?, lastName = ?, gender = ?, dateOfBirth = ?, email = ?, phone = ?, class_id = ?, department_id = ? WHERE student_id = ?");
            if ($stmt->execute([$firstName, $lastName, $gender, $dob, $email, $phone, $class, $department, $id_to_update])) {
                $_SESSION['alert'] = 'Update Student Successfully.';
                $_SESSION['alert_type'] = 'success';
                header('Location: createStudent.php');
                exit();
            } else {
                $_SESSION['alert'] = 'Update Student False!';
                $_SESSION['alert_type'] = 'false';
            }
        } else {
            $_SESSION['alert'] = 'Please Fill/Select All Field.';
            $_SESSION['alert_type'] = 'false';
        }
    }
}
updateStudent();

function update(){
    if(isset($_POST['update'])){
        $id_to_update = $_GET['studentID'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $oldProfile = $_POST['old-profile'];
        
        if (isset($_FILES['profile']) && $_FILES['profile']['error'] == UPLOAD_ERR_OK) {
            $profile = $_FILES['profile']['name'];
            move_uploaded_file($_FILES['profile']['tmp_name'], 'profile/' . $profile);
            $path = 'profile/'.$oldProfile;
            if(file_exists($path)){
                unlink($path);
            }
        } else {
            $profile = $oldProfile;
        }

        if (!empty($firstName) && !empty($lastName) && !empty($gender) && !empty($dob) && !empty($email) && !empty($phone)) {
            $stmt = connection()->prepare("UPDATE student SET firstName = ?, lastName = ?, gender = ?, dateOfBirth = ?, email = ?, phone = ?, profile = ? WHERE student_id = ?");
            if ($stmt->execute([$firstName, $lastName, $gender, $dob, $email, $phone, $profile, $id_to_update])) {
                $_SESSION['alert'] = 'Update Student Successfully.';
                $_SESSION['alert_type'] = 'success';
                header('Location: student-profile.php?studentID='.$id_to_update);
                exit();
            } else {
                $_SESSION['alert'] = 'Update Student False!';
                $_SESSION['alert_type'] = 'false';
            }
        } else {
            $_SESSION['alert'] = 'Please Fill/Select All Field.';
            $_SESSION['alert_type'] = 'false';
        }
    }
}
update();

function deleteStudent(){
    if(isset($_POST['delete-student'])){
        $id_to_delete = $_POST['delete-student'];
        $stmt = connection()->prepare("DELETE FROM student WHERE student_id = ?");
        if($stmt->execute([$id_to_delete])){
            $_SESSION['alert'] = 'Delete Student Successfully.';
            $_SESSION['alert_type'] = 'success';
            header('Location: createStudent.php');
            exit();
        } else {
            $_SESSION['alert'] = 'Delete Student False!';
            $_SESSION['alert_type'] = 'false';
        }

    }
}
deleteStudent();


function studentPay(){

    if(isset($_POST['pay-btn'])){
        $student_id = $_POST['student-id'];
        $paymentType = $_POST['payment-type'];
        $amount = $_POST['amount'];

        if(!empty($paymentType) && !empty($amount)){
            $stmt = connection()->prepare("UPDATE student SET paymentType = ?, amount = amount + ? WHERE student_id = ?");
            if($stmt->execute([$paymentType, $amount, $student_id])){
                $_SESSION['alert'] = 'Payment Successfully.';
                $_SESSION['alert_type'] = 'success';
                header('Location: studentPayment.php');
                exit();
            } else {
                $_SESSION['alert'] = 'Payment False!';
                $_SESSION['alert_type'] = 'false';
            }
        }else {
            $_SESSION['alert'] = 'Payment False!';
            $_SESSION['alert_type'] = 'false';
        }
    }
}
studentPay();

function createEvent(){
    if(isset($_POST['create-event'])){
        $eventTitle = $_POST['event-title'];
        $eventDis = $_POST['event-dis'];
        $startDate = $_POST['sd'];
        $startTime = $_POST['st'];
        $endDate = $_POST['ed'];
        $endTime = $_POST['et'];
        
        if(!empty($eventTitle) && !empty($eventDis) && !empty($startDate) && !empty($startTime) && !empty($endDate) && !empty($endTime)){
            $stmt = connection()->prepare("INSERT INTO event (eventName, eventDis, eventSD, eventST, eventED, eventET)
                                           VALUES(?, ?, ?, ?, ?, ?) 
                                        ");
            if($stmt->execute([$eventTitle, $eventDis, $startDate, $startTime, $endDate, $endTime])){
                $_SESSION['alert'] = 'Create Event Successfully.';
                $_SESSION['alert_type'] = 'success';
                header('Location: createEvent.php');
                exit();
            }else{
                $_SESSION['alert'] = 'Create Event False!.';
                $_SESSION['alert_type'] = 'false';
            }
        }else {
            $_SESSION['alert'] = 'Please Fill/Select All Field.';
            $_SESSION['alert_type'] = 'false';
        }
    }
}
createEvent();

if(isset($_SESSION['alert']) && isset($_SESSION['alert_type'])){
    if($_SESSION['alert_type'] == 'success'){
        successAlert($_SESSION['alert']);
    }elseif($_SESSION['alert_type'] == 'false'){
        falseAlert($_SESSION['alert']);
    }
    unset($_SESSION['alert']);
    unset($_SESSION['alert_type']);
}