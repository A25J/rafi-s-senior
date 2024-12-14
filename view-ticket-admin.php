<?php
include 'includes/connect.php';
include 'includes/wallet.php';

$continue = 0;

if (isset($_SESSION['admin_sid']) && $_SESSION['admin_sid'] == session_id()) {
    
    $ticket_id = intval($_GET['id']);
    $stmt = $con->prepare("SELECT * FROM tickets WHERE id = ?");
    $stmt->bind_param("i", $ticket_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $type = htmlspecialchars($row['type']);
        $subject = htmlspecialchars($row['subject']);
        $description = htmlspecialchars($row['description']);
        $date = htmlspecialchars($row['date']);
        $status = htmlspecialchars($row['status']);
        $role = 'admin';
        $continue = 1;
    }
    $stmt->close();
}

if ($continue) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <title>Ticket No. <?php echo $ticket_id . ' - ' . $type; ?></title>

    <!-- Favicons -->
    <link rel="icon" href="images/favicon/favicon-32x32.png" sizes="32x32">
    <link rel="apple-touch-icon-precomposed" href="images/favicon/apple-touch-icon-152x152.png">
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">

    <!-- CORE CSS -->
    <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js" type="text/css" rel="stylesheet" media="screen,projection">

    <style type="text/css">
        .input-field div.error {
            position: relative;
            top: -1rem;
            left: 0rem;
            font-size: 0.8rem;
            color: #FF4081;
            transform: translateY(0%);
        }
        .input-field label.active {
            width: 100%;
        }
    </style>
</head>
<body>
   
    <header id="header" class="page-topbar">
        <div class="navbar-fixed">
            <nav class="navbar-color">
                <div class="nav-wrapper">
                    <ul class="left">
                        <li><h1 class="logo-wrapper"><a href="index.php" class="brand-logo darken-1"><img src="images/materialize-logo.png" alt="logo"></a> <span class="logo-text">Logo</span></h1></li>
                    </ul>
                    <ul class="right hide-on-med-and-down">
                        <li><a href="#" class="waves-effect waves-block waves-light"><i class="mdi-editor-attach-money"><?php echo htmlspecialchars($balance); ?></i></a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
   
    <div id="main">
        <div class="wrapper">

           
            <aside id="left-sidebar-nav">
                <ul id="slide-out" class="side-nav fixed leftside-navigation">
                    <li class="user-details cyan darken-2">
                        <div class="row">
                            <div class="col col s4 m4 l4">
                                <img src="images/avatar.jpg" alt="" class="circle responsive-img valign profile-image">
                            </div>
                            <div class="col col s8 m8 l8">
                                <ul id="profile-dropdown" class="dropdown-content">
                                    <li><a href="routers/logout.php"><i class="mdi-hardware-keyboard-tab"></i> Logout</a></li>
                                </ul>
                            </div>
                            <div class="col col s8 m8 l8">
                                <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown"><?php echo htmlspecialchars($name); ?> <i class="mdi-navigation-arrow-drop-down right"></i></a>
                                <p class="user-role"><?php echo htmlspecialchars($role); ?></p>
                            </div>
                        </div>
                    </li>
                    <li class="bold"><a href="index.php" class="waves-effect waves-cyan"><i class="mdi-editor-border-color"></i> Order Food</a></li>
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li class="bold"><a class="collapsible-header waves-effect waves-cyan"><i class="mdi-editor-insert-invitation"></i> Orders</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="all-orders.php">All Orders</a></li>
                                        <?php
                                        $sql = mysqli_query($con, "SELECT DISTINCT status FROM orders;");
                                        while ($row = mysqli_fetch_array($sql)) {
                                            echo '<li><a href="all-orders.php?status=' . htmlspecialchars($row['status']) . '">' . htmlspecialchars($row['status']) . '</a></li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li class="bold"><a class="collapsible-header waves-effect waves-cyan"><i class="mdi-action-question-answer"></i> Tickets</a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="all-tickets.php">All Tickets</a></li>
                                        <?php
                                        $sql = mysqli_query($con, "SELECT DISTINCT status FROM tickets;");
                                        while ($row = mysqli_fetch_array($sql)) {
                                            echo '<li><a href="all-tickets.php?status=' . htmlspecialchars($row['status']) . '">' . htmlspecialchars($row['status']) . '</a></li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="bold"><a href="details.php" class="waves-effect waves-cyan"><i class="mdi-social-person"></i> Edit Details</a></li>
                </ul>
                <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan"><i class="mdi-navigation-menu"></i></a>
            </aside>
           
            <section id="content">

               
                <div id="breadcrumbs-wrapper">
                    <div class="container">
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <h5 class="breadcrumbs-title">Provide Order Details</h5>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="container">
                    <p class="caption">Order Details</p>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="row">
                                        <form method="POST">
                                            <div class="input-field col s12">
                                                <input type="text" value="<?php echo htmlspecialchars($subject); ?>" disabled>
                                                <label>Subject</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <textarea class="materialize-textarea" disabled><?php echo htmlspecialchars($description); ?></textarea>
                                                <label>Description</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <input type="text" value="<?php echo htmlspecialchars($date); ?>" disabled>
                                                <label>Date</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <select name="status">
                                                    <option value="<?php echo htmlspecialchars($status); ?>"><?php echo htmlspecialchars($status); ?></option>
                                                    <option value="Pending">Pending</option>
                                                    <option value="In Progress">In Progress</option>
                                                    <option value="Resolved">Resolved</option>
                                                    <option value="Closed">Closed</option>
                                                </select>
                                                <label>Status</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <button type="submit" name="update" class="btn waves-effect waves-light">Update Status</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php
                if (isset($_POST['update'])) {
                    $new_status = $_POST['status'];
                    $update_sql = "UPDATE tickets SET status = '$new_status' WHERE id = $ticket_id;";
                    if (mysqli_query($con, $update_sql)) {
                        echo '<script>alert("Status updated successfully!"); window.location.href = "all-tickets.php";</script>';
                    } else {
                        echo '<script>alert("Error updating status: ' . mysqli_error($con) . '");</script>';
                    }
                }
                ?>

            </section>
          
            <footer class="page-footer">
                <div class="footer-copyright">
                    <div class="container">
                        © 2024 All rights reserved. 
                        <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
                    </div>
                </div>
            </footer>
           

        </div>
    </div>
   
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="js/materialize.min.js"></script>
    <script src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="js/custom-script.js"></script>
    <script>
    $(document).ready(function() {
        $('select').formSelect();
    });
</script>
 
</body>

</html>

<?php
} else {
    header('Location: index.php');
}
?>
