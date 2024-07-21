<?php 
    include 'sidebar.php';
    $stmt = connection()->prepare("SELECT * FROM event");
    $stmt->execute();

    $start = 0;

    $row_per_page = 10;
    $number_of_row = $stmt->rowCount();
    $pages = ceil($number_of_row / $row_per_page);

    if(isset($_GET['page-nr'])){
        $page = $_GET['page-nr'] - 1;
        $start = $page * $row_per_page;
    }

    $stmtEvent = connection()->prepare("SELECT * FROM event ORDER BY event_id DESC LIMIT ?, ?");
    $stmtEvent->execute([$start, $row_per_page]);

?>
<link rel="stylesheet" href="css/department.css">

        <div id="add-more" class="dashboard-content">
            <div class="title-locate">
                <div class="title">
                    <h2>Manage Event</h2>
                </div>
                <div class="locate">
                    <p>Event / <span>Create & Views</span></p>
                </div>
            </div>
            <div class="create-department-wrapper">
                <div class="create-department-card">
                    <div class="create-department-title">
                        <h2>
                        <?php 
                            echo isset($_GET['id']) ? 'Update' : 'Create';
                        ?>    
                        Event</h2>
                    </div>
                    <form action="" method="POST">
                        <div class="input-field-wrap">
                            <div class="">
                                <label for="">Event Title:</label><br>
                                <input type="text" name="event-title" placeholder="Enter Event Title" class="input-department">
                            </div>
                            <div class="">
                                <label for="">Event Discription:</label><br>
                                <input type="text" name="event-dis" placeholder="Enter Event Discription" class="input-department">
                            </div>
                            <div class="">
                                <label for="">Event Start Date:</label><br>
                                <input type="date" name="sd" class="input-department">
                            </div>
                            <div class="">
                                <label for="">Event Start Time:</label><br>
                                <input type="time" name="st" class="input-department">
                            </div>
                            <div class="">
                                <label for="">Event End Date:</label><br>
                                <input type="date" name="ed" class="input-department">
                            </div>
                            <div class="">
                                <label for="">Event End Time:</label><br>
                                <input type="time" name="et" class="input-department">
                            </div>

                        </div>
                        <div class="btn-wrapper">

                            <?php 
                                if(isset($_GET['id'])){
                                    ?>
                                        <button class="create-btn" name="update-event" type="submit">Update</button>
                                        <button type="reset" name="cancel-update">Cancel</button>
                                    <?php
                                }else{
                                    ?>
                                        <button class="create-btn" name="create-event" type="submit">Create</button>
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
                                <th>Event Title</th>
                                <th>StartTime</th>
                                <th>EndTIme</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                            
                            <?php
                                if($stmtEvent->rowCount() <= 0){
                                    ?>
                                        <tr>
                                            <th>Record Not Found.</th>
                                        </tr>
                                    <?php
                                }else{
                                    while($row = $stmtEvent->fetch()){
                                        ?>
                                            <tr>
                                                <td><?= $row['event_id'] ?></td>
                                                <td><?= $row['eventName'] ?></td>
                                                <td><?= $row['eventSD'] ?> | <?= $row['eventST'] ?></td>
                                                <td><?= $row['eventED'] ?> | <?= $row['eventET'] ?></td>
                                                <td>
                                                    <a href="?id=<?= $row['event_id'] ?>"><i class='bx bxs-edit'></i> Update</a>
                                                </td>
                                                <td class="delete-depart">
                                                    <form action="" method="post">
                                                        <button type="submit" name="delete-event" value="<?= $row['event_id'] ?>"><i class='bx bx-trash' ></i> Delete</button>
                                                    </form>
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