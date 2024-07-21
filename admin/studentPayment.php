<?php 
    include 'sidebar.php';
    
    $stmt = connection()->prepare("SELECT * FROM student AS a INNER JOIN department AS b ON a.department_id = b.department_id");
    $stmt->execute();

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

    if(isset($_GET['payId'])){
        $student_id = $_GET['payId'];
        $payStmt = connection()->prepare("SELECT * FROM student WHERE student_id = ? LIMIT $start, $row_per_page");
        $payStmt->execute([$student_id]);
        $pay = $payStmt->fetch();
    }


    if(isset($_GET['search'])){
        $searchValue = '%'.$_GET['search'].'%';
        $searchStmt = connection()->prepare("SELECT * FROM student AS a JOIN department AS b ON a.department_id = b.department_id WHERE a.firstName LIKE ? OR a.lastName LIKE ? ORDER BY a.firstName ASC LIMIT $start, $row_per_page");
        $searchStmt->execute([$searchValue, $searchValue]);
    }
?>
<link rel="stylesheet" href="css/studentPayment.css">

        <div class="dashboard-content">
            <div class="title-locate">
                <div class="title">
                    <h2>Student Payment</h2>
                </div>
                <div class="locate">
                    <p>Student / <span>Payments</span></p>
                </div>
            </div>
            <div class="create-department-wrapper">
                <div class="create-department-card">
                    <div class="create-department-title">
                        <h2>Payment</h2>
                    </div>
                    <form action="" method="POST">
                        <div class="input-field-wrap">
                            <div class="">
                                <label for="">First Name:</label><br>
                                <input name="first_name" required autocomplete="off" class="input-info nameP" placeholder="Enter First Name" type="text" value="<?= (isset($pay['firstName'])) ? $pay['firstName'] : '' ?>">
                            </div>
                            <div class="">
                                <label for="">Last Name:</label><br>
                                <input name="last_name" required autocomplete="off" class="input-info nameP" placeholder="Enter Last Name" type="text" value="<?= (isset($pay['firstName'])) ? $pay['lastName'] : '' ?>">
                            </div>
                            <input name="student-id" required autocomplete="off" class="input-info nameP" placeholder="Enter Last Name" type="hidden" value="<?= (isset($pay['student_id'])) ? $pay['student_id'] : '' ?>">
                            <div class="">
                                <label for="">Payment Type:</label><br>
                                <select required name="payment-type" class="input-info" id="">
                                    <option value="">---Choose Payment Type---</option>
                                    <option value="half">Half</option>
                                    <option value="full">Full</option>
                                </select>
                            </div>
                            <div class="">
                                <label for="">Amount:</label><br>
                                <input name="amount" required autocomplete="off" class="input-info" placeholder="Enter Amount Money" type="text" value="">
                            </div>
                        </div>
                        <div class="btn-wrapper">
                            <button class="create-btn" name="pay-btn" type="submit">Pay</button>
                            <button type="reset">Cancel</button>
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
                                <th>Department</th>
                                <th>Payment Status</th>
                                <th>Amount</th>
                                <th>Pay</th>
                            </tr>
                            <?php 
                                if(isset($_GET['search'])){
                                    if($searchStmt->rowCount() <= 0){
                                        ?>
                                            <tr>
                                                <td>Search Not Found</td>
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
                                                    <td>
                                                        <?php 
                                                            if($row['paymentType'] == 'half'){
                                                                echo 'Half Paid';
                                                            }elseif($row['paymentType'] == 'full'){
                                                                echo 'Full Paid'; 
                                                            }else{
                                                                echo 'Not Paid';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>$<?= $row['amount'] ?></td>
                                                    <td>
                                                        <a href="?payId=<?= $row['student_id'] ?>"><i class="fa-solid fa-money-bill-wave"></i> Pay</a>
                                                    </td>
                                                </tr>
                                            <?php
                                        }
                                    }
                                }else{
                                    while($row = $stmt->fetch()){
                                        ?>
                                            <tr>
                                                <td><?= $row['student_id'] ?></td>
                                                <td><?= $row['firstName'] ?></td>
                                                <td><?= $row['lastName'] ?></td>
                                                <td><?= $row['departmentName'] ?></td>
                                                <td>
                                                    <?php 
                                                        if($row['paymentType'] == 'half'){
                                                            echo 'Half Paid';
                                                        }elseif($row['paymentType'] == 'full'){
                                                            echo 'Full Paid'; 
                                                        }else{
                                                            echo 'Not Paid';
                                                        }
                                                    ?>
                                                </td>
                                                <td>$<?= $row['amount'] ?></td>
                                                <td>
                                                    <a href="?payId=<?= $row['student_id'] ?>"><i class="fa-solid fa-money-bill-wave"></i> Pay</a>
                                                </td>
                                            </tr>
                                        <?php
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