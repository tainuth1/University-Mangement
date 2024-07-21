<?php
include 'sidebar.php';
$getStudent = connection()->prepare("SELECT * FROM student");
$getStudent->execute();
$student = $getStudent->rowCount();

$getTeacher = connection()->prepare("SELECT * FROM teacher");
$getTeacher->execute();
$teacher = $getTeacher->rowCount();

$getClass = connection()->prepare("SELECT * FROM class");
$getClass->execute();
$class = $getClass->rowCount();

$getEarn = connection()->prepare("SELECT SUM(amount) AS amount FROM student");
$getEarn->execute();
$earn = $getEarn->fetch();

$getTopStudent = connection()->prepare("SELECT * FROM student AS a INNER JOIN department AS b ON a.department_id = b.department_id WHERE amount >= 500 LIMIT 5");
$getTopStudent->execute();
?>

<div class="dashboard-content">
    <div class="title-locate">
        <div class="title">
            <h2>Admin Dashboard</h2>
        </div>
        <div class="locate">
            <p>Home / <span>Dashboard</span></p>
        </div>
    </div>
    <div class="card-wrapper">
        <div class="card">
            <div class="card-icon">
                <div class="icon-wrapper ic1">
                    <img src="images/student.png" alt="">
                </div>
            </div>
            <div class="card-number">
                <p>Students</p>
                <h3 class="value-number" data-target="<?= $student ?>">0</h3>
            </div>
        </div>
        <div class="card">
            <div class="card-icon">
                <div class="icon-wrapper ic2">
                    <img src="images/teacher.png" alt="">
                </div>
            </div>
            <div class="card-number">
                <p>Teachers</p>
                <h3 class="value-number" data-target="<?= $teacher ?>">0</h3>
            </div>
        </div>
        <div class="card">
            <div class="card-icon">
                <div class="icon-wrapper ic3">
                    <img src="images/school.png" alt="">
                </div>
            </div>
            <div class="card-number">
                <p>Classes</p>
                <h3 class="value-number" data-target="<?= $class ?>">0</h3>
            </div>
        </div>
        <div class="card">
            <div class="card-icon">
                <div class="icon-wrapper ic4">
                    <img src="images/earned.png" alt="">
                </div>
            </div>
            <div class="card-number">
                <p>Earned</p>
                <h3 class="value-number" data-target="<?= $earn['amount'] ?>">$0</h3>
            </div>
        </div>
    </div>
    <div class="chart-container">
        <div class="chart">
            <div class="head-chart">
                <h2>Overviews</h2>
                <div class="guid">
                    <div class="guid-wrap">
                        <div class="dot d1"></div>
                        <p>Teachers</p>
                    </div>
                    <div class="guid-wrap">
                        <div class="dot d2"></div>
                        <p>Students</p>
                    </div>
                    <div class="three-dot">
                        <i class='bx bx-dots-vertical-rounded'></i>
                    </div>
                </div>
            </div>
            <div id="chart-area"></div>
        </div>
        <div class="chart">
            <div class="head-chart">
                <h2>Number Of Students</h2>
                <div class="guid">
                    <div class="guid-wrap">
                        <div class="dot d1"></div>
                        <p>Boys</p>
                    </div>
                    <div class="guid-wrap">
                        <div class="dot d2"></div>
                        <p>Girls</p>
                    </div>
                    <div class="three-dot">
                        <i class='bx bx-dots-vertical-rounded'></i>
                    </div>
                </div>
            </div>
            <div id="number-students"></div>
        </div>
    </div>
    <div class="last-wrapper">
        <div class="top-students-wrap">
            <div class="top-students-head">
                <h2>Top Students</h2>
                <div class="three-dot">
                    <i class='bx bx-dots-vertical-rounded'></i>
                </div>
            </div>
            <table class="top-student">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Department</th>
                </tr>
                <?php 
                    while($topstudent = $getTopStudent->fetch()){
                        ?>
                            <tr>
                                <td><?= $topstudent['student_id'] ?></td>
                                <td>
                                    <a href="">
                                        <img src="profile/<?= $topstudent['profile'] == 'profile.jpg' ? 'noProfile.jpg' : $topstudent['profile'] ?>"
                                            alt="">
                                    </a>
                                    <?= $topstudent['firstName'] ?> <?= $topstudent['lastName'] ?>
                                </td>
                                <td><?= $topstudent['gender'] ?></td>
                                <td><?= $topstudent['departmentName'] ?></td>
                            </tr>
                        <?php
                    }
                ?>
            </table>
        </div>
        <div class="event-wrap">
            <div class="event-head">
                <h2>Upcoming Event</h2>
                <div class="three-dot" id="add-event">
                    <i class='bx bx-dots-vertical-rounded'></i>
                    <div class="sub-menu" id="sub-menu">
                        <ul>
                            <li>
                                <a href="createEvent.php"><i class='bx bx-caret-right'></i> Add Event</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="event-card-wrapper">
                <div class="event-card">
                    <div class="event-logo-detail">
                        <div class="event-logo-wrap">
                            <img src="images/calendar3d.png" alt="">
                        </div>
                        <div class="name-detail">
                            <h2>Meeting Day</h2>
                            <p>This day we have a meeting at .</p>
                        </div>
                    </div>
                    <div class="event-date">
                        <h3>
                            <span>5-27-2024</span>
                            <span>|</span>
                            <span>11:00 PM</span>
                        </h3>
                        <div class="three-dot">
                            <i class='bx bx-dots-vertical-rounded'></i>
                        </div>
                    </div>
                </div>
                <div class="event-card">
                    <div class="event-logo-detail">
                        <div class="event-logo-wrap">
                            <img src="images/calendar3d.png" alt="">
                        </div>
                        <div class="name-detail">
                            <h2>Meeting Day</h2>
                            <p>This day we have a meeting at .</p>
                        </div>
                    </div>
                    <div class="event-date">
                        <h3>
                            <span>5-27-2024</span>
                            <span>|</span>
                            <span>11:00 PM</span>
                        </h3>
                        <div class="three-dot">
                            <i class='bx bx-dots-vertical-rounded'></i>
                        </div>
                    </div>
                </div>
                <div class="event-card">
                    <div class="event-logo-detail">
                        <div class="event-logo-wrap">
                            <img src="images/calendar3d.png" alt="">
                        </div>
                        <div class="name-detail">
                            <h2>Meeting Day</h2>
                            <p>This day we have a meeting at .</p>
                        </div>
                    </div>
                    <div class="event-date">
                        <h3>
                            <span>5-27-2024</span>
                            <span>|</span>
                            <span>11:00 PM</span>
                        </h3>
                        <div class="three-dot">
                            <i class='bx bx-dots-vertical-rounded'></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pagination">
                <div class="pagination-menu">
                    <a class="pag-arrow" href="#"><i class='bx bx-chevron-left'></i></a>
                    <a class="pag-active" href="#">1</a>
                    <a class="" href="#">2</a>
                    <a class="" href="#">3</a>
                    <a class="" href="#">4</a>
                    <a class="pag-arrow" href="#"><i class='bx bx-chevron-right'></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <h2>University | ©Copyright</h2>
</div>
</section>
</body>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="javascript/script.js"></script>
<script>
    var options = {
        chart: {
            height: 350,
            type: "line",
            toolbar: {
                show: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: "smooth"
        },
        series: [
            {
                name: "Teachers",
                color: '#3D5EE1',
                data: [45, 60, 75, 51, 42, 42, 30]
            },
            {
                name: "Students",
                color: '#70C4CF',
                data: [24, 48, 56, 32, 34, 52, 25]
            }
        ],
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul']
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart-area"), options);
    chart.render();

    var optionsBar = {
        chart: {
            type: 'bar',
            height: 350,
            width: '100%',
            stacked: false,
            toolbar: {
                show: false
            },
        },
        dataLabels: {
            enabled: false
        },
        plotOptions: {
            bar: {
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        series: [
            {
                name: "Boys",
                color: '#70C4CF',
                data: [420, 532, 516, 575, 519, 517, 454, 392, 262, 383, 446, 551],
            },
            {
                name: "Girls",
                color: '#3D5EE1',
                data: [336, 612, 344, 647, 345, 563, 256, 344, 323, 300, 455, 456],
            }
        ],
        labels: [2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020],
        xaxis: {
            labels: {
                show: false
            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
        },
        yaxis: {
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            labels: {
                style: {
                    colors: '#777'
                }
            }
        },
        title: {
            text: '',
            align: 'left',
            style: {
                fontSize: '18px'
            }
        }
    };
    var chartBar = new ApexCharts(document.querySelector('#number-students'), optionsBar);
    chartBar.render();

</script>

</html>