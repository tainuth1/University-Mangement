<?php 
    include 'sidebar.php';
    
    $stmt = connection()->prepare("SELECT * FROM teacher WHERE 1");
    $stmt->execute();

    $start = 0;
    $row_per_page = 10;
    $number_of_row = $stmt->rowCount();
    $pages = ceil($number_of_row / $row_per_page);

    if(isset($_GET['id_update'])){
        $id = $_GET['id_update'];
        $updateStmt = connection()->prepare("SELECT * FROM teacher WHERE teacher_id = ?");
        $updateStmt->execute([$id]);
        $update = $updateStmt->fetch();
    }

    if(isset($_GET['page-nr'])){
        $page = $_GET['page-nr'] - 1;
        $start = $page * $row_per_page;
    }
    $stmt = connection()->prepare("SELECT * FROM teacher ORDER BY teacher_id ASC LIMIT $start, $row_per_page");
    $stmt->execute();
    
    if(isset($_GET['search'])){
        $searchValue = '%'.$_GET['search'].'%';
        $searchStmt = connection()->prepare("SELECT * FROM teacher WHERE CONCAT(firstName, ' ', lastName) LIKE ? ORDER BY teacher_id ASC");
        $searchStmt->execute([$searchValue]);
    }
?>
<link rel="stylesheet" href="css/teacher.css">

        <div class="dashboard-content">
            <div class="title-locate">
                <div class="title">
                    <h2>Manage Teacher</h2>
                </div>
                <div class="locate">
                    <p>Teacher / <span>Add & Views</span></p>
                </div>
            </div>
            <div class="create-department-wrapper">
                <div class="create-department-card">
                    <div class="create-department-title">
                        <h2>
                        <?= isset($_GET['id_update']) ? 'Update' : 'Add' ?>    
                        Teacher</h2>
                    </div>
                    <form action="" method="POST">
                        <div class="input-field-wrap">
                            <div class="">
                                <label for="">First Name:</label><br>
                                <input name="first_name" required autocomplete="off" class="input-info" placeholder="Enter First Name" type="text" value="<?= (isset($update['firstName'])) ? $update['firstName'] : '' ?>">
                            </div>
                            <div class="">
                                <label for="">Last Name:</label><br>
                                <input name="last_name" required autocomplete="off" class="input-info" placeholder="Enter Last Name" type="text" value="<?= (isset($update['lastName'])) ? $update['lastName'] : '' ?>">
                            </div>
                            <div class="">
                                <label for="">Gender:</label><br>
                                <select required name="gender" class="input-info" id="">
                                    <option value="">---Gender---</option>
                                    <option value="Male" <?= (isset($update) && $update['gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
                                    <option value="Felmale" <?= (isset($update) && $update['gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
                                </select>
                            </div>
                            <div class="">
                                <label for="">Email:</label><br>
                                <input name="email" required autocomplete="off" class="input-info" placeholder="Enter Email" type="email" value="<?= (isset($update['email'])) ? $update['email'] : '' ?>">
                            </div>
                            <div class="">
                                <label for="">Birth Date:</label><br>
                                <input name="birth_date" required autocomplete="off" class="input-info" placeholder="Enter Email" type="date" value="<?= (isset($update['dateOfBirth'])) ? $update['dateOfBirth'] : '' ?>">
                            </div>
                            <div class="">
                                <label for="">Phone:</label><br>
                                <input name="phone" required autocomplete="off" class="input-info" placeholder="Enter Phone Number" type="text" value="<?= (isset($update['phone'])) ? $update['phone'] : '' ?>">
                            </div>
                            <div class="">
                                <label for="">Address:</label><br>
                                <input name="address" required autocomplete="off" class="input-info" placeholder="Enter Address" type="text" value="<?= (isset($update['address'])) ? $update['address'] : '' ?>">
                            </div>
                            <div class="">
                                <label for="">Role:</label><br>
                                <select name="role" class="input-info" id="">
                                    <option value="">---Choose Role---</option>
                                    <option value="Teacher" <?= (isset($update) && $update['role'] == 'Teacher') ? 'selected' : '' ?>>Teacher</option>
                                    <option value="Administrator" <?= (isset($update) && $update['role'] == 'Administrator') ? 'selected' : '' ?>>Administrator</option>
                                    <option value="Assistant" <?= (isset($update) && $update['role'] == 'Assistant') ? 'selected' : '' ?>>Assistant</option>
                                </select>
                            </div>
                        </div>
                        <div class="btn-wrapper">
                            <?php 
                                if(isset($_GET['id_update'])){
                                    ?>
                                        <button class="create-btn" name="update-teacher" type="submit">Update</button>
                                        <button type="reset">Cancel</button>
                                    <?php
                                }else{
                                    ?>
                                        <button class="create-btn" name="add-teacher" type="submit">Add</button>
                                        <button type="reset">Cancel</button>
                                    <?php
                                }
                            ?>
                            
                        </div>
                    </form>
                </div>

                <div class="department-list-wrapper">
                    <div class="list-title">
                        <h2>Teacher List</h2>
                    </div>
                    <div class="list-setting">
                        <div class="list-head-wrap">
                            <div class="left-show">
                                <select name="" id="">
                                    <option value="">10</option>
                                    <option value="">20</option>
                                    <option value="">30</option>
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
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Details</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                            <?php
                                if($stmt->rowCount() <= 0){
                                    echo '
                                    <tr>
                                        <td rowspan="6">No Record Found</td>
                                    </tr>
                                    ';
                                }else{
                                    if(!isset($_GET['search'])){
                                        while($row = $stmt->fetch()){
                                            echo '
                                            <tr>
                                                <td>'.$row['teacher_id'].'</td>
                                                <td>'.$row['firstName'].'</td>
                                                <td>'.$row['lastName'].'</td>
                                                <td>'.$row['email'].'</td>
                                                <td>'.$row['phone'].'</td>
                                                <td>
                                                    <a href="teacher-profile.php?teacherID='.$row['teacher_id'].'"><i class="fa-solid fa-id-card"></i></a>
                                                </td>
                                                <td>
                                                    <a href="?id_update='.$row['teacher_id'].'"><i class="bx bxs-edit" ></i>Update</a>
                                                </td>
                                                <form method="POST">
                                                    <td class="delete-depart">
                                                        <button name="delete-teacher" value="'.$row['teacher_id'].'"><i class="bx bx-trash" ></i>Delete</button>
                                                    </td>
                                                </form>
                                            </tr>
                                            ';
                                        }
                                    }else{
                                        if($searchStmt->rowCount() <= 0 ){
                                            echo '
                                            <tr>
                                                <td rowspan="6">No Record Found</td>
                                            </tr>
                                            ';
                                        }else{
                                            while($row = $searchStmt->fetch()){
                                                ?>
                                                    <tr>
                                                        <td><?= $row['teacher_id'] ?></td>
                                                        <td><?= $row['firstName'] ?></td>
                                                        <td><?= $row['lastName'] ?></td>
                                                        <td><?= $row['email'] ?></td>
                                                        <td><?= $row['phone'] ?></td>
                                                        <td><?= $row['role'] ?></td>
                                                        <td>
                                                            <a href="teacher-profile.php?id=<?= $row['teacher_id'] ?>"><i class="fa-solid fa-id-card"></i></a>
                                                        </td>
                                                        <td>
                                                            <a href="?id_update=<?= $row['teacher_id'] ?>"><i class="bx bxs-edit" ></i>Update</a>
                                                        </td>
                                                        <form method="POST">
                                                            <td class="delete-depart">
                                                                <button name="delete-teacher" value="<?= $row['teacher_id'] ?>"><i class="bx bx-trash" ></i>Delete</button>
                                                            </td>
                                                        </form>
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
</html>