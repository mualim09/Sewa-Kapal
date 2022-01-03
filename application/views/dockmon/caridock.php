<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Hasil Pencarian</h1>
    <br>
    <br><br>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col" width="5%">No</th>
                <th scope="col">Nama Galangan</th>
                <th scope="col" width="15%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM perusahaan INNER JOIN galangan ON perusahaan.id_perusahaan = galangan.perusahaan WHERE ";

            if ($this->input->post('kota') != NULL) {
                $query .= "perusahaan.kota LIKE '" . $this->input->post('kota') . "%'";
            }
            if ($this->input->post('panjang') != NULL) {
                $query .= "AND galangan.panjang >= " . $this->input->post('panjang');
            }

            $Tampil = $this->db->query($query)->result_array();
            $cek = $this->db->query($query)->row_array();
            $no = 1;
            if ($cek == 0) {
                echo '
                        <tr>
                            <td colspan="6"><center>Data Kosong</center></td>
                        </tr>
                    ';
            } else {
                foreach ($Tampil as $t) {
            ?>
                    <tr>

                        <td><?= $no; ?></td>
                        <td><?= $t['nama_galangan']; ?></td>
                        <td>
                            <a class="btn btn-warning rounded-pill pl-3 pr-3" href="<?= base_url('dockmon/requestbooking/' . $t['id_galangan']); ?>">Booking</a>
                        </td>
                    </tr>
            <?php
                    $no++;
                }
            }
            ?>
        </tbody>
    </table>

</div>
<!-- /.container-fluid -->