<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="index.php">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <!-- Customer Sidebar = 0  -->
        <?php
if ($_SESSION['role'] == 0) {
?>
<li class="nav-item nav-category">Workplaces</li>
        <li class="nav-item">
            <a class="nav-link" href="meet.php">
                <i class="bi bi-cloud-arrow-up fs-5"></i> &nbsp; &nbsp;
                <span class="menu-title">Create Meeting</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="collaborations.php">
                <i class="bi bi-cloud-arrow-up fs-5"></i> &nbsp; &nbsp;
                <span class="menu-title">Collaborations</span>
            </a>
        </li>
        <li class="nav-item nav-category">Documents</li>
        <li class="nav-item">
            <a class="nav-link" href="new_document.php">
                <i class="bi bi-cloud-arrow-up fs-5"></i> &nbsp; &nbsp;
                <span class="menu-title">Upload Documents</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="documents_lists.php">
                <i class="bi bi-file-pdf fs-5"></i> &nbsp; &nbsp;
                <span class="menu-title">Documents List</span>
            </a>
        </li>

        <li class="nav-item nav-category">Folders</li->
        <li class="nav-item">
            <a class="nav-link" href="new_folder.php">
                <i class="bi bi-folder fs-5"></i> &nbsp; &nbsp;
                <span class="menu-title">Folders </span>
            </a>
        </li>
        <li class="nav-item nav-category">Group</li->
        <li class="nav-item">
            <a class="nav-link" href="shared_folder.php">
                <i class="bi bi-collection fs-5"></i> &nbsp; &nbsp;
                <span class="menu-title">Shared Folders </span>
            </a>
        </li>
        <li class="nav-item nav-category">Friends</li>
        <li class="nav-item">
            <a class="nav-link" href="new_friend.php">
                <i class="bi bi-person-plus-fill fs-5"></i> &nbsp; &nbsp;
                <span class="menu-title"> New Connection </span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="friends_list.php">
                <i class="bi bi-people-fill fs-5"></i> &nbsp; &nbsp;
                <span class="menu-title"> Connections </span>
            </a>
        </li>

        <li class="nav-item nav-category">Settings</li>
        <li class="nav-item">
            <a class="nav-link" href="user_pin_setup.php">
                <i class="bi bi-key-fill fs-5"></i> &nbsp; &nbsp;
                <span class="menu-title">PIN Setup </span>
            </a>
        </li>
        <?php
}else {
  ?>
        <li class="nav-item nav-category">Forms and Datas</li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false"
                aria-controls="form-elements">
                <i class="menu-icon mdi mdi-card-text-outline"></i>
                <span class="menu-title">Form elements</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="pages/forms/basic_elements.html">Basic Elements</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                <i class="menu-icon mdi mdi-chart-line"></i>
                <span class="menu-title">Charts</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/charts/chartjs.html">ChartJs</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                <i class="menu-icon mdi mdi-table"></i>
                <span class="menu-title">Tables</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/tables/basic-table.html">Basic table</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
                <i class="menu-icon mdi mdi-layers-outline"></i>
                <span class="menu-title">Icons</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="icons">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/icons/mdi.html">Mdi icons</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item nav-category">pages</li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <i class="menu-icon mdi mdi-account-circle-outline"></i>
                <span class="menu-title">User Pages</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item nav-category">help</li>
        <li class="nav-item">
            <a class="nav-link" href="http://bootstrapdash.com/demo/star-admin2-free/docs/documentation.html">
                <i class="menu-icon mdi mdi-file-document"></i>
                <span class="menu-title">Documentation</span>
            </a>
        </li>
        <?php
}

?>



    </ul>
</nav>