<?php 
    include 'sidebar.php';

    $stmtDepatment = connection()->prepare("SELECT * FROM department");
    $stmtDepatment->execute();

    $getClass = connection()->prepare("SELECT * FROM class");
    $getClass->execute(); 

    $start = 0;

    $row_per_page = 10;

    $number_of_row = $getClass->rowCount();
    $pages = ceil($number_of_row / $row_per_page);

    if(isset($_GET['page-nr'])){
        $page = $_GET['page-nr'] - 1;
        $start = $page * $row_per_page;
    }

    $stmtClass = connection()->prepare("SELECT * FROM class AS a INNER JOIN department AS b ON a.department_id = b.department_id ORDER BY className ASC LIMIT $start, $row_per_page");
    $stmtClass->execute();

    if(isset($_GET['search'])){
        $searchValue = '%'.$_GET['search'].'%';
        $searchStmt = connection()->prepare("SELECT * FROM class AS a INNER JOIN department AS b ON a.department_id = b.department_id WHERE className LIKE ? OR departmentName LIKE ? ORDER BY className ASC");
        $searchStmt->execute([$searchValue, $searchValue]);
    }

    if(isset($_GET['id'])){
        $id_to_update = $_GET['id'];
        $updateStmt = connection()->prepare("SELECT * FROM class AS a INNER JOIN department AS b ON a.department_id = b.department_id WHERE a.class_id = ?");
        $updateStmt->execute([$id_to_update]);
        $updateClass = $updateStmt->fetch();
    }
?>  

<link rel="stylesheet" href="css/class.css">
        <div class="dashboard-content">
            <div class="title-locate">
                <div class="title">
                    <h2>Manage Class</h2>
                </div>
                <div class="locate">
                    <p>Class / <span>Create & Views</span></p>
                </div>
            </div>
            <div class="create-department-wrapper">
                <div class="create-department-card">
                    <div class="create-department-title">
                        <h2>Create Class</h2>
                    </div>
                    <form action="" method="POST">
                        <div class="input-field-wrap">
                            <div class="">
                                <label for="">Class Name:</label><br>
                                <input required autocomplete="off" class="input-info" placeholder="Enter Class Name" type="text" name="class-name" value="<?= isset($updateClass['className']) ? $updateClass['className'] : '' ?>">
                            </div>
                            <div class="">
                                <label for="">Department:</label><br>
                                <select required name="department" class="input-info" id="">
                                    <option>---Select Department---</option>
                                    <?php
                                        if($stmtDepatment->rowCount() <= 0){
                                            ?> <option>No Department</option> <?php
                                        }else{
                                            while($row = $stmtDepatment->fetch()){
                                                ?>
                                                    <option value="<?= $row['department_id'] ?>" <?= (isset($updateClass) && $updateClass['departmentName'] == $row['departmentName']) ? 'selected' : ''; ?>><?= $row['departmentName'] ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="">
                                <label for="">Study Time:</label><br>
                                <select required name="study-time" class="input-info" id="">
                                    <option>---Choose Study Schedule---</option>
                                    <option value="Morning" <?= (isset($updateClass) && $updateClass['studyTime'] == 'Morning') ? 'selected' : ''; ?>>Morning</option>
                                    <option value="Afternoon" <?= (isset($updateClass) && $updateClass['studyTime'] == 'Afternoon') ? 'selected' : ''; ?>>Afternoon</option>
                                    <option value="Night" <?= (isset($updateClass) && $updateClass['studeyTime'] == 'Night') ? 'selected' : ''; ?>>Night</option>
                                </select>
                            </div>
                        </div>
                        <div class="btn-wrapper">
                            <?php 
                                if(isset($_GET['id'])){
                                    ?> 
                                        <button class="create-btn" name="update-class" type="submit">Update</button>
                                        <button type="reset">Cancel</button>
                                    <?php
                                }else{
                                    ?>
                                        <button class="create-btn" name="create-class" type="submit">Create</button>
                                        <button type="reset">Cancel</button>
                                    <?php
                                }
                            ?>
                        </div>
                    </form>
                </div>

                <div class="department-list-wrapper" id="data">
                    <div class="list-title">
                        <h2>Class List</h2>
                    </div>
                    <div class="list-setting">
                        <div class="list-head-wrap">
                            <div class="left-show">
                                <select name="rows" id="rows" onchange="getRow()">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                </select>
                                <select name="" id="">
                                    <option value="">All</option>
                                    <option value="">IT</option>
                                    <option value="">English</option>
                                    <option value="">Khmer</option>
                                </select>
                                <form action="" method="get">
                                    <input type="text" autocomplete="off" placeholder="Search..." name="search">
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
                                <th>Class-Name</th>
                                <th>Department</th>
                                <th>Study-Time</th>
                                <th>Create-Date</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                            <?php 
                                if($stmtClass->rowCount() <= 0){
                                    ?> <td colspan="7">No Record Found</td> <?php
                                }else{
                                    if(!isset($_GET['search'])){
                                        while($row = $stmtClass->fetch()){
                                            ?> 
                                                <tr>
                                                    <td><?= $row['class_id'] ?></td>
                                                    <td><?= $row['className'] ?></td>
                                                    <td><?= $row['departmentName'] ?></td>
                                                    <td><?= $row['studyTime'] ?></td>
                                                    <td><?= $row['create_date'] ?></td>
                                                    <td>
                                                        <a href="?id=<?= $row['class_id'] ?>"><i class='bx bxs-edit' ></i>Update</a>
                                                    </td>
                                                    <td class="delete-depart">
                                                        <form action="" method="post">
                                                            <button type="submit" name="delete-class" value="<?= $row['class_id'] ?>"><i class='bx bx-trash' ></i>Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                        }
                                    }else{
                                        if($searchStmt->rowCount() <=0){
                                            ?> <td colspan="7">No Record Found</td> <?php
                                        }else{
                                            while($row = $searchStmt->fetch()){
                                                ?> 
                                                    <tr>
                                                        <td><?= $row['class_id'] ?></td>
                                                        <td><?= $row['className'] ?></td>
                                                        <td><?= $row['departmentName'] ?></td>
                                                        <td><?= $row['studyTime'] ?></td>
                                                        <td><?= $row['create_date'] ?></td>
                                                        <td>
                                                            <a href="?id=<?= $row['class_id'] ?>"><i class='bx bxs-edit' ></i>Update</a>
                                                        </td>
                                                        <td class="delete-depart">
                                                            <form action="" method="post">
                                                                <button type="submit" value="<?= $row['class_id'] ?>"><i class='bx bx-trash' ></i>Delete</button>
                                                            </form>
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
</html>