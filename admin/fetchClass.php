<?php

require '../connection/db.php';

if (isset($_POST['department']) && isset($_POST['class_id'])) {
    $departmentId = $_POST['department'];
    $classId = $_POST['class_id'];
    $sqlDepartment = connection()->prepare("SELECT * FROM department WHERE department_id = ?");
    $sqlDepartment->execute([$departmentId]);
    $row = $sqlDepartment->fetch();
    $request_class = $row['departmentName'];
    $getClass = connection()->prepare("SELECT * FROM class AS a INNER JOIN department AS b ON a.department_id = b.department_id WHERE b.departmentName = ? ORDER BY a.className ASC");
    $getClass->execute([$request_class]);
    
    if ($getClass->rowCount() > 0) {
        while ($row = $getClass->fetch()) {
            $selected = ($row['class_id'] == $classId) ? 'selected' : '';
            echo '<option value="' . $row['class_id'] . '" ' . $selected . '>' . $row['className'] . '</option>';
        }
    } else {
        echo '<option>---No Class Available---</option>';
    }
    exit;
}