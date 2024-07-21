<?php 
    include 'sidebar.php';

    $getDepart = connection()->prepare("SELECT * FROM department");
    $getDepart->execute();
    $departOp = connection()->prepare("SELECT * FROM department");
    $departOp->execute();

    $countStudent = connection()->prepare("SELECT * FROM student");
    $countStudent->execute();
    $start = 0;

    $row_per_page = 10;
    $number_of_row = $countStudent->rowCount();
    $pages = ceil($number_of_row / $row_per_page);

    if(isset($_GET['page-nr'])){
        $page = $_GET['page-nr'] - 1;
        $start = $page * $row_per_page;
    }
    $stmtStudent = connection()->prepare("SELECT * FROM student AS a JOIN department AS b ON a.department_id = b.department_id JOIN class AS c ON a.class_id = c.class_id ORDER BY a.firstName ASC LIMIT $start, $row_per_page");
    $stmtStudent->execute();

    if(isset($_GET['update'])){
        $id_to_update = $_GET['update'];
        $stmtUpdateStudent = connection()->prepare("SELECT * FROM student AS a JOIN department AS b ON a.department_id = b.department_id JOIN class AS c ON a.class_id = c.class_id WHERE a.student_id = ?");
        $stmtUpdateStudent->execute([$id_to_update]);
        $update = $stmtUpdateStudent->fetch();
    }

    if(isset($_GET['search'])){
        $searchValue = '%'.$_GET['search'].'%';
        $searchStmt = connection()->prepare("SELECT * FROM student AS a JOIN department AS b ON a.department_id = b.department_id JOIN class AS c ON a.class_id = c.class_id WHERE a.firstName LIKE ? OR a.lastName LIKE ? ORDER BY a.firstName ASC LIMIT $start, $row_per_page");
        $searchStmt->execute([$searchValue, $searchValue]);
    }

?>
<link rel="stylesheet" href="css/student.css">

        <div class="dashboard-content">
            <div class="title-locate">
                <div class="title">
                    <h2>Manage Student</h2>
                </div>
                <div class="locate">
                    <p>Student / <span>Add & Views</span></p>
                </div>
            </div>
            <div class="create-department-wrapper">
                <div class="create-department-card">
                    <div class="create-department-title">
                        <h2>
                            <?= isset($_GET['update']) ? 'Update' : 'Add' ?>    
                        Student</h2>
                    </div>
                    <form  id="student-form" action="" method="POST">
                        <div class="input-field-wrap">
                            <div class="">
                                <label for="">First Name:</label><br>
                                <input required autocomplete="off" class="input-info" placeholder="Enter First Name" type="text" id="first-name" name="first-name" value="<?= isset($update['firstName']) ? $update['firstName'] : '' ?>">
                            </div>
                            <div class="">
                                <label for="">Last Name:</label><br>
                                <input required autocomplete="off" class="input-info" placeholder="Enter Last Name" type="text" id="last-name" name="last-name" value="<?= isset($update['lastName']) ? $update['lastName'] : '' ?>">
                            </div>
                            <div class="">
                                <label for="">Gender:</label><br>
                                <select required name="gender" class="input-info" id="gender">
                                    <option>---Choose Gender---</option>
                                    <option value="Male" <?= (isset($update['gender']) && $update['gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
                                    <option value="Female" <?= (isset($update['gender']) && $update['gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
                                </select>
                            </div>
                            <div class="">
                                <label for="">Birth Date:</label><br>
                                <input required autocomplete="off" class="input-info" placeholder="Enter Email" type="date" id="dob" name="dob" value="<?= isset($update['dateOfBirth']) ? $update['dateOfBirth'] : '' ?>">
                            </div>
                            <div class="">
                                <label for="">Email:</label><br>
                                <input required autocomplete="off" class="input-info" placeholder="Enter Email" type="email" id="email" name="email" value="<?= isset($update['email']) ? $update['email'] : '' ?>">
                            </div>
                            <div class="">
                                <label for="">Phone:</label><br>
                                <input required autocomplete="off" class="input-info" placeholder="Enter Phone Number" type="text" id="phone" name="phone" value="<?= isset($update['phone']) ? $update['phone'] : '' ?>">
                            </div>
                            <div class="">
                                <label for="">Department:</label><br>
                                <select required name="department" class="input-info choose-department" id="department">
                                    <option>---Choose Departmennt---</option>
                                    <?php 
                                        if($getDepart->rowCount() <= 0){
                                            ?>
                                                <option>---No Department Avilable---</option>
                                            <?php
                                        }else{
                                            while($row = $getDepart->fetch()){
                                                ?>
                                                    <option 
                                                        value="<?= $row['department_id'] ?>"
                                                        <?= (isset($update['departmentName']) && $update['departmentName'] == $row['departmentName']) ? 'selected' : '' ?>
                                                    ><?= $row['departmentName'] ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="">
                                <label for="">Class:</label><br>
                                <select required name="class" class="input-info choose-class" id="class">
                                    
                                </select>
                            </div>
                        </div>
                        <div class="btn-wrapper">
                            <?php
                                if(!isset($_GET['update'])){
                                    ?>
                                        <button class="create-btn" name="add-student" id="add-student" type="submit">Create</button>
                                        <button type="reset">Cancel</button>
                                    <?php
                                }else{
                                    ?>
                                        <button class="create-btn" name="update-student"  type="submit">Update</button>
                                        <button type="reset">Cancel</button>
                                    <?php
                                }
                            ?>
                        </div>
                    </form>
                </div>

                <div class="department-list-wrapper">
                    <div class="list-title">
                        <h2>Student List</h2>
                    </div>
                    <div class="list-setting">
                        <div class="list-head-wrap">
                            <div class="left-show">
                                <select name="" id="">
                                    <option value="">10</option>
                                    <option value="">20</option>
                                    <option value="">30</option>
                                </select>
                                <select name="" id="department-show-option">
                                    <option value="All" selected>All</option>
                                    <?php
                                        if($departOp->rowCount() <=0 ){
                                            ?>
                                                <option>No Department</option>
                                            <?php
                                        }else{
                                            while($rowOption = $departOp->fetch()){
                                                ?>
                                                    <option value="<?= $rowOption['departmentName'] ?>"​​​​​​><?= $rowOption['departmentName'] ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                                <form action="">
                                    <input type="text" autocomplete="off" placeholder="Search...." name="search">
                                </form>
                            </div>
                            <div class="right-bar">
                                <i class="fa-solid fa-list"></i>
                                <i class="fa-regular fa-square-plus"></i>
                            </div>
                        </div>
                        <table class="department-table">
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Department</th>
                                <th>Class</th>
                                <th>Study-Time</th>
                                <th>Update</th>
                                <th>Delete</th>
                                <th>Detail</th>
                            </tr>
                            <?php 
                                if($stmtStudent->rowCount() <= 0){
                                    ?>
                                        <tr>
                                            <td rowspan="9">Student Record Not Found</td>
                                        </tr>
                                    <?php
                                }else{
                                    if(!isset($_GET['search'])){
                                        while($row = $stmtStudent->fetch()){
                                            ?>
                                                <tr>
                                                    <td><?= $row['student_id'] ?></td>
                                                    <td><?= $row['firstName'] ?></td>
                                                    <td><?= $row['lastName'] ?></td>
                                                    <td><?= $row['departmentName'] ?></td>
                                                    <td><?= $row['className'] ?></td>
                                                    <td><?= $row['studyTime'] ?></td>
                                                    <td>
                                                        <a href="?update=<?= $row['student_id'] ?>"><i class='bx bxs-edit'></i> Update</a>
                                                    </td>
                                                    <td class="delete-depart">
                                                        <form action="" method="post">
                                                            <button type="submit" name="delete-student" value="<?= $row['student_id'] ?>"><i class='bx bx-trash' ></i> Delete</button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <a href="student-profile.php?studentID=<?= $row['student_id'] ?>"><i class="fa-regular fa-address-card"></i></a>
                                                    </td>
                                                </tr>
                                            <?php
                                        }
                                    }else{
                                        if($searchStmt->rowCount() <=0 ){
                                            ?>
                                                <tr>
                                                    <td rowspan="9">Search Not Found!!</td>
                                                </tr>
                                            <?php
                                        }else{
                                            while($row = $searchStmt->fetch()){
                                                ?>
                                                    <tr>
                                                        <td><?= $row['student_id'] ?></td>
                                                        <td><?= $row['firstName'] ?></td>
                                                        <td><?= $row['lastName'] ?></td>
                                                        <td><?= $row['departmentName'] ?></td>
                                                        <td><?= $row['className'] ?></td>
                                                        <td><?= $row['studyTime'] ?></td>
                                                        <td>
                                                            <a href="?update=<?= $row['student_id'] ?>"><i class='bx bxs-edit'></i> Update</a>
                                                        </td>
                                                        <td class="delete-depart">
                                                            <form action="" method="post">
                                                                <button type="submit" name="delete-student" value="<?= $row['student_id'] ?>"><i class='bx bx-trash' ></i> Delete</button>
                                                            </form>
                                                        </td>
                                                        <td>
                                                            <a href="student-profile.php?studentID=<?= $row['student_id'] ?>"><i class="fa-regular fa-address-card"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php
                                            }
                                        }
                                    }
                                    
                                }
                            ?>
                        </table>
                        <?php
                            if(!isset($_GET['page-nr'])){
                                $p = 1;
                            }else{
                                $p = $_GET['page-nr'];
                            }
                        ?>
                        <!-- pagination-active -->
                        <div class="pagination-wrapper">
                            <?php
                                if(isset($_GET['page-nr']) && $_GET['page-nr'] > 1){
                                    ?> 
                                        <a class="" href="?page-nr=<?php echo $_GET['page-nr']-1; ?>">
                                            <i class='bx bx-chevron-left' ></i>
                                        </a>
                                    <?php
                                }else{
                                    ?>
                                        <a class="">
                                            <i class='bx bx-chevron-left' ></i>
                                        </a>
                                    <?php
                                }
                            ?>
                            <?php 
                                for($i=1 ; $i<=$pages ; $i++){
                                    ?>
                                        <a class="<?php if($p == $i) echo 'pagination-active'; ?>" href="?page-nr=<?= $i ?>"><?= $i ?></a>
                                    <?php
                                }
                            ?>
                            <?php
                                if(!isset($_GET['page-nr'])){
                                    ?>
                                        <a class="">
                                                <i class='bx bx-chevron-right'></i>
                                        </a>
                                    <?php
                                }else{
                                    if($_GET['page-nr'] >= $pages){
                                        ?>
                                            <a class="">
                                                <i class='bx bx-chevron-right'></i>
                                            </a>
                                        <?php
                                    }else{
                                        ?>
                                            <a class="" href="?page-nr=<?php echo $_GET['page-nr']+1; ?>">
                                                <i class='bx bx-chevron-right' ></i>
                                            </a>
                                        <?php
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script src="javascript/script.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#department').change(function() {
            var department = $(this).val();
            var classId = '<?= isset($update['class_id']) ? $update['class_id'] : '' ?>';
            if (department) {
                $.ajax({
                    type: 'POST',
                    url: 'fetchClass.php',
                    data: {
                        department: department,
                        class_id: classId
                    },
                    success: function(response) {
                        $('#class').html(response);
                        // alert(response);
                        $('.choose-class').show();
                    }
                });
            } else {
                $('#class').html('<option value="">---Choose Class---</option>');
                $('.choose-class').hide();
            }
        });

        <?php if (isset($update['class_id'])): ?>
            $('#department').trigger('change');
        <?php endif; ?>

    });
</script>
