<?php 
    include 'sidebar.php';
    $stmt = connection()->prepare("SELECT *, CONCAT(firstName, ' ', lastName) AS fullName FROM teacher");
    $stmt->execute();

    $start = 0;

    $row_per_page = 10;
    $number_of_row = $stmt->rowCount();
    $pages = ceil($number_of_row / $row_per_page);

    if(isset($_GET['page-nr'])){
        $page = $_GET['page-nr'] - 1;
        $start = $page * $row_per_page;
    }

    $stmt2 = connection()->prepare("SELECT * FROM department AS a INNER JOIN teacher AS b ON a.departmentHead = b.teacher_id ORDER BY department_id ASC LIMIT $start, $row_per_page");
    $stmt2->execute();

    
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $stmt3 = connection()->prepare("SELECT a.departmentName, CONCAT(b.firstName, ' ', b.lastName) AS fullName FROM department AS a INNER JOIN teacher AS b ON a.departmentHead = b.teacher_id WHERE a.department_id = ?");
        $stmt3->execute([$id]);
        $update = $stmt3->fetch();
    }
   
    // Search statement
    if(isset($_GET['search'])){
        $searchValue = '%'.$_GET['search'].'%';
        $searchStmt = connection()->prepare("SELECT * FROM department AS a INNER JOIN teacher AS b ON a.departmentHead = b.teacher_id WHERE a.departmentName LIKE ? OR CONCAT(b.firstName, ' ', b.lastName) LIKE ? ORDER BY a.department_id ASC");
        $searchStmt->execute([$searchValue, $searchValue]);
    }


?>
<link rel="stylesheet" href="css/department.css">

        <div id="add-more" class="dashboard-content">
            <div class="title-locate">
                <div class="title">
                    <h2>Manage Department</h2>
                </div>
                <div class="locate">
                    <p>Department / <span>Create & Views</span></p>
                </div>
            </div>
            <div class="create-department-wrapper">
                <div class="create-department-card">
                    <div class="create-department-title">
                        <h2>
                        <?php 
                            echo isset($_GET['id']) ? 'Update' : 'Create';
                        ?>    
                        Department</h2>
                    </div>
                    <form action="" method="POST">
                        <div class="input-field-wrap">
                            <div class="">
                                <label for="">Department Name:</label><br>
                                <input name="dp_name" 
                                    required 
                                    autocomplete="off" 
                                    class="input-department" 
                                    placeholder="Enter Department Name" 
                                    type="text" 
                                    value="<?= isset($update['departmentName']) ? $update['departmentName'] : ''; ?>"
                                >
                            </div>
                            <div class="">
                                <label for="">Department Head:</label><br>
                                <select required name="dp_head" class="input-department" id="">
                                    <option value="">----Select Department Head----</option>
                                    <?php 
                                        while($row = $stmt->fetch()){
                                            ?>
                                                <option value="<?= $row['teacher_id']?>" <?= (isset($update) && $update['fullName'] == $row['fullName']) ? 'selected' : ''; ?> ><?= $row['fullName'] ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="btn-wrapper">

                            <?php 
                                if(isset($_GET['id'])){
                                    ?>
                                        <button class="create-btn" name="update-dp" type="submit">Update</button>
                                        <button type="reset" name="cancel-update">Cancel</button>
                                    <?php
                                }else{
                                    ?>
                                        <button class="create-btn" name="create-dp" type="submit">Create</button>
                                        <button type="reset">Cancel</button>
                                    <?php
                                }
                            ?>
                            
                        </div>
                    </form>
                </div>

                <div class="department-list-wrapper">
                    <div class="list-title">
                        <h2>Department List</h2>
                    </div>
                    <div class="list-setting">
                        <div class="list-head-wrap">
                            <div class="left-show">
                                <select name="showRow" id="rowSelector" onchange="rowChange()">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                </select>
                                <form action="">
                                    <input type="text" autocomplete="off" placeholder="Search...." name="search">
                                </form>
                            </div>
                            <div class="right-bar">
                                <i class="fa-solid fa-list"></i>
                                <a href="#add-more">
                                    <i class="fa-regular fa-square-plus"></i>
                                </a>
                            </div>
                        </div>
                        <table class="department-table">
                            <tr>
                                <th>ID</th>
                                <th>Department Name</th>
                                <th>Head</th>
                                <th>Create-Date</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                            <?php
                                if($stmt2->rowCount() <= 0){
                                    echo '
                                        <tr>
                                            <td rowspan="6">No Record Found</td>
                                        </tr>
                                    ';
                                }else{
                                    if(!isset($_GET['search'])){
                                        while($row = $stmt2->fetch()){
                                            echo '
                                                <tr>
                                                    <td>'.$row['department_id'].'</td>
                                                    <td>'.$row['departmentName'].'</td>
                                                    <td>'.$row['firstName'].' '.$row['lastName'].'</td>
                                                    <td>'.$row['create_date'].'</td>
                                                    <td>
                                                        <a href="?id='.$row['department_id'].'"><i class="bx bxs-edit" ></i>Update</a>
                                                    </td>
                                                    <form method="post">
                                                        <td class="delete-depart">
                                                            <button type="submit" name="delete_dp" value="'.$row['department_id'].'"><i class="bx bx-trash" ></i>Delete</button>
                                                        </td>
                                                    </form>
                                                </tr>
                                            ';
                                        }
                                    }else{
                                        // Search Views
                                        if($searchStmt->rowCount() <=0){
                                            echo '
                                            <tr>
                                                <td rowspan="6">No Record Found</td>
                                            </tr>
                                            ';
                                        }else{
                                            while($row = $searchStmt->fetch()){
                                                echo '
                                                    <tr>
                                                        <td>'.$row['department_id'].'</td>
                                                        <td>'.$row['departmentName'].'</td>
                                                        <td>'.$row['firstName'].' '.$row['lastName'].'</td>
                                                        <td>'.$row['create_date'].'</td>
                                                        <td>
                                                            <a href="?id='.$row['department_id'].'"><i class="bx bxs-edit" ></i>Update</a>
                                                        </td>
                                                        <form method="post">
                                                            <td class="delete-depart">
                                                                <button type="submit" name="delete_dp" value="'.$row['department_id'].'"><i class="bx bx-trash" ></i>Delete</button>
                                                            </td>
                                                        </form>
                                                    </tr>
                                                ';
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