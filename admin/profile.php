<?php 
    include 'sidebar.php';

    $getUser = $_GET['id'];
    $stmt = connection()->prepare("SELECT * FROM admin WHERE admin_id = ?");
    $stmt->execute([$getUser]);
    $row = $stmt->fetch();

?>
<link rel="stylesheet" href="css/profile.css">

        <div class="dashboard-content">
            <div class="title-locate">
                <div class="title">
                    <h2>Admin Profile</h2>
                </div>
                <div class="locate">
                    <p>Admin / <span>Profile</span></p>
                </div>
            </div>
            <div class="profile-wrapper">
                <div class="border">
                    <div class="cover">
                        <img src="https://img.freepik.com/free-photo/2d-graphic-colorful-wallpaper-with-grainy-gradients_23-2151001566.jpg" alt="">
                    </div>
                    <div class="profile-content">
                        <div class="profile-img-names-dis">
                            <div class="pro-img-wrapper">
                                <img src="profile/<?= $row['profile'] ?>" alt="">
                                <!-- <form class="choose-profile" method="post" enctype="multipart/form-data">
                                    <div class="">
                                        <label for="profile"><i class='bx bx-edit'></i></label>
                                        <input class="choose-image" type="file" name="profile" id="profile" style="display: none;">
                                    </div>
                                </form> -->
                            </div>
                            <h3><?= $row['firstName']?> <?= $row['lastName'] ?></h3>
                            <!-- <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Vero praesentium assumenda excepturi laboriosam reiciendis blanditiis, temporibus, totam incidunt sit nobis alias, nulla id voluptatem illo explicabo doloremque quod unde enim.</p> -->
                            <!-- <div class="social-contact">
                                <a href="">
                                    <span><i class='bx bxl-facebook-square' ></i></span> Facebook
                                </a>
                                <a href="">
                                    <span><i class='bx bxl-telegram'></i></span> Telegram
                                </a>
                                <a href="">
                                    <span><i class='bx bxs-envelope' ></i></span> Email
                                </a>
                                <a href="">
                                    <span><i class='bx bxs-phone' ></i></span> +855 81725020
                                </a>
                            </div> -->
                        </div>
                        <div class="edit-pro">
                            <form method="post">
                                <input class="" type="file" name="cover" id="cover" style="display: none;">
                                <label class="choose-cover" for="cover"><i class='bx bx-image' ></i> Change Cover</label>
                            </form>
                            <a href="edit-profile-admin.php?adminID=<?= $row['admin_id'] ?>">
                                <button><i class='bx bxs-edit'></i> Edit Profile</button>
                            </a>
                        </div>
                    </div>
                    <div class="info-detail">
                        <div class="info-row">
                            <div class="info-label">First Name:</div>
                            <div class="info-input">
                                <input type="text" name="first_name" value="<?= $row['firstName'] ?>">
                            </div>
                            <div class="info-label">Last Name:</div>
                            <div class="info-input">
                                <input type="text" name="last_name" value="<?= $row['lastName'] ?>">
                            </div>
                            <div class="info-label">Gender:</div>
                            <div class="info-input">
                                <input type="text" name="gender" value="<?= $row['gender'] ?>">
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Date Of Birth:</div>
                            <div class="info-input">
                                <input type="text" name="dob" value="<?= $row['dateOfBirth'] ?>">
                            </div>
                            <div class="info-label">Email:</div>
                            <div class="info-input">
                                <input type="text" name="email" value="<?= $row['email'] ?>">
                            </div>
                            <div class="info-label">Phone:</div>
                            <div class="info-input">
                                <input type="text" name="phone" value="<?= $row['phone'] ?>">
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Address:</div>
                            <div class="info-input">
                                <input type="text" name="address" value="<?= $row['address'] ?>">
                            </div>
                            <div class="info-label">Role:</div>
                            <div class="info-input">
                                <input type="text" name="role" value="<?= $row['role'] ?>">
                            </div>
                            <div class="info-label">Religion:</div>
                            <div class="info-input">
                                <input type="text" name="religion" value="Khmer">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script src="javascript/script.js"></script>
<script>
    $(document).ready(function(){
        
    });
</script>
</html>