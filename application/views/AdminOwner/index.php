<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

    <!-- Content -->
    <div class="row text-white pt-3 pb-5 justify-content-center">
        <div class="card bg-secondary" style="width: 19rem;">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h5 class="card-title">Jumlah User</h5>
                <div class="display-4">
                    <?php
                    $query = 'SELECT* FROM user WHERE perusahaan =' . $user['perusahaan'];
                    $cek = $this->db->query($query)->num_rows();
                    echo --$cek;
                    ?>
                </div>
                <a href="<?= base_url('AdminOwner/user'); ?>">
                    <p class="card-text text-white">Lihat Detail <i class="fas fa-angle-double-right ml-2"></i></p>
                </a>
            </div>
        </div>

        <div class="card bg-info ml-5" style="width: 19rem;">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fas fa-ship"></i>
                </div>
                <h5 class="card-title">Jumlah Kapal</h5>
                <div class="display-4">
                    <?php
                    $query = 'SELECT* FROM kapal WHERE perusahaan =' . $user['perusahaan'];
                    $cek = $this->db->query($query)->num_rows();
                    echo $cek;
                    ?>
                </div>
            </div>
        </div>

        <div class="card bg-success ml-5" style="width: 19rem;">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h5 class="card-title">Survey Terdekat</h5>
                <div class="display-4">
                    <?php
                    $query = "SELECT datediff(tanggal, current_date()) as selisih FROM survey JOIN kapal ON survey.kapal = kapal.id_kapal where kapal.perusahaan =" . $user['perusahaan'] . " ORDER BY selisih ASC LIMIT 1";
                    $Tampil = $this->db->query($query)->result_array();
                    foreach ($Tampil as $t) {
                        echo $t['selisih'] . " <span class='fs-4'>Hari</span>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- End Of Content -->


</div>
<!-- /.container-fluid -->