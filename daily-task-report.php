<?php 
if(isset($_SERVER['HTTPS'])){
    $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
} else {
    $protocol = 'http';
}
$base_url = $protocol . "://".$_SERVER['SERVER_NAME'].'/' .(explode('/',$_SERVER['PHP_SELF'])[1]).'/';
?>
<?php
require 'authentication.php'; // admin authentication check 

// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
}

// check admin
$user_role = $_SESSION['user_role'];

if(isset($_GET['delete_task'])){
    $action_id = $_GET['task_id'];
    
    $sql = "DELETE FROM task_info WHERE task_id = :id";
    $sent_po = "task-info.php";
    $obj_admin->delete_data_by_this_method($sql,$action_id,$sent_po);
}

if(isset($_POST['add_task_post'])){
    $obj_admin->add_new_task($_POST);
}

$page_name="Task_Info";
include("include/sidebar.php");
// include('ems_header.php');
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="row">
    <div class="col-md-12">
        <div class="well well-custom rounded-0">
            <div class="gap"></div>
            <div class="row">
                <div class="col-md-4">
                    <input type="text" id="search" class="form-control rounded-0" placeholder="Search...">
                </div>
                <div class="col-md-4">
                    <select id="statusFilter" class="form-control rounded-0">
                        <option value="">All Status</option>
                        <option value="1">In Progress</option>
                        <option value="2">Completed</option>
                        <option value="0">In Completed</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" id="dateFilter" class="form-control rounded-0" placeholder="Date">
                </div>
            </div>
            <div class="gap"></div>
            <div class="gap"></div>
            <div class="row">
                <div class="col-md-2 col-md-offset-10">
                    <button class="btn btn-primary btn-sm btn-menu" type="button" id="print"><i class="glyphicon glyphicon-print"></i> Print</button>
                </div>
            </div>
            <center><h3>Task Report</h3></center>
            <div class="gap"></div>
            <div class="gap"></div>
            <div class="table-responsive" id="printout">
                <div style="height: 400px; overflow-y: scroll;">
                    <table class="table table-condensed table-custom" id="taskTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Task Title</th>
                                <th>Assigned To</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if($user_role == 1){
                                $sql = "SELECT a.*, b.fullname 
                                        FROM task_info a
                                        INNER JOIN tbl_admin b ON(a.t_user_id = b.user_id)
                                        ORDER BY a.task_id DESC";
                            } else {
                                $sql = "SELECT a.*, b.fullname 
                                        FROM task_info a
                                        INNER JOIN tbl_admin b ON(a.t_user_id = b.user_id)
                                        WHERE a.t_user_id = $user_id
                                        ORDER BY a.task_id DESC";
                            } 
                            $info = $obj_admin->manage_all_info($sql);
                            $serial  = 1;
                            $num_row = $info->rowCount();
                            if($num_row == 0){
                                echo '<tr><td colspan="7">No Data found</td></tr>';
                            }
                            while($row = $info->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <tr>
                                <td><?php echo $serial; ?></td>
                                <td><?php echo $row['t_title']; ?></td>
                                <td><?php echo $row['fullname']; ?></td>
                                <td><?php echo $row['t_start_time']; ?></td>
                                <td><?php echo $row['t_end_time']; ?></td>
                                <td>
                                    <?php  
                                    if($row['status'] == 1){
                                        echo '<small class="label label-warning px-3">In Progress <span class="glyphicon glyphicon-refresh"></small>';
                                    } elseif($row['status'] == 2){
                                        echo '<small class="label label-success px-3">Completed <span class="glyphicon glyphicon-ok"></small>';
                                    } else {
                                        echo '<small class="label label-default border px-3">In Completed <span class="glyphicon glyphicon-remove"></small>';
                                    } 
                                    ?>
                                </td>
                            </tr>
                            <?php 
                            $serial++; // Increment serial number
                            } 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("include/footer.php"); ?>

<noscript>
<div>
    <style>
        body {
            background-image: none !important;
        }
        .mb-0 {
            margin: 0px;
        }
    </style>
    <div style="line-height: 1em">
        <h4 class="mb-0 text-center"><b>Task Management System</b></h4>
        <h4 class="mb-0 text-center"><b>Task Report</b></h4>
    </div>
    <hr>
</div>
</noscript>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script type="text/javascript">
$(function(){
    // Initialize Flatpickr
    $('#dateFilter').flatpickr({
        dateFormat: "Y-m-d"
    });

    function filterTable() {
        var searchText = $('#search').val().toLowerCase();
        var dateFilter = $('#dateFilter').val();
        var statusFilter = $('#statusFilter').val();

        $("#taskTable tbody tr").each(function() {
            var rowText = $(this).text().toLowerCase();
            var startTime = $(this).find('td:nth-child(4)').text();
            var endTime = $(this).find('td:nth-child(5)').text();
            var status = $(this).find('td:nth-child(6) small').text().trim();

            var showRow = true;

            if (searchText && rowText.indexOf(searchText) === -1) {
                showRow = false;
            }

            if (dateFilter) {
                var taskDate = new Date(startTime);
                var filterDate = new Date(dateFilter);
                if (taskDate.toDateString() !== filterDate.toDateString()) {
                    showRow = false;
                }
            }

            if (statusFilter) {
                var statusText = '';
                if (statusFilter == "1") {
                    statusText = 'In Progress';
                } else if (statusFilter == "2") {
                    statusText = 'Completed';
                } else if (statusFilter == "0") {
                    statusText = 'In Completed';
                }
                if (status !== statusText) {
                    showRow = false;
                }
            }

            $(this).toggle(showRow);
        });
    }

    $('#search, #dateFilter, #statusFilter').on('input change', filterTable);

    $('#print').click(function(){
        var h = $('head').clone();
        var ns = $($('noscript').html()).clone();
        var p = $('#printout').clone();
        var base = '<?= $base_url ?>';
        h.find('link').each(function(){
            $(this).attr('href', base + $(this).attr('href'));
        });
        h.find('script').each(function(){
            if($(this).attr('src') != "")
            $(this).attr('src', base + $(this).attr('src'));
        });
        p.find('.table').addClass('table-bordered');
        var nw = window.open("", "_blank","width:"+($(window).width() * .8)+",left:"+($(window).width() * .1)+",height:"+($(window).height() * .8)+",top:"+($(window).height() * .1));
        nw.document.querySelector('head').innerHTML = h.html();
        nw.document.querySelector('body').innerHTML = ns[0].outerHTML;
        nw.document.querySelector('body').innerHTML += p[0].outerHTML;
        nw.document.close();
        setTimeout(() => {
            nw.print();
            setTimeout(() => {  
                nw.close();
            }, 200);
        }, 200);
    });
});
</script>

<style>
/* Sticky header */
.table-responsive {
    position: relative;
}
.table-responsive thead {
    position: sticky;
    top: 0;
    z-index: 1;
    background-color: white; /* To ensure the header is visible */
}
</style>
