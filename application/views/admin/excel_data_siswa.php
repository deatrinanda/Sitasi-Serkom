<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=" . $filename . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Verdana';
    }

    .table-data {
        width: 96%;
        border-collapse: collapse;
    }

    .table-data tr th,
    .table-data tr td {
        border: 1px solid black;
        font-size: 11pt;
        font-family: Verdana;
        text-align: center;
        padding: 10px 10px 10px 10px;
    }

    h3 {
        font-family: Verdana;
    }
</style>
<h3>
    <center>Laporan Data Siswa</center>
</h3>
<br />
<table class="table-data">
    <thead>
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Jenis Kelamin</th>
            <th>No telepon</th>
            <th>Tahun Masuk</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($siswa as $s) {
        ?>
            <tr>
                <th scope="row"><?= $no++; ?></th>
                <td><?= $s['nis']; ?></td>
                <td><?= $s['nama']; ?></td>
                <td><?= $s['kelas']; ?></td>
                <td><?= $s['jenis_kelamin']; ?></td>
                <td><?= $s['no_telepon']; ?></td>
                <td><?= $s['tahun_masuk']; ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>