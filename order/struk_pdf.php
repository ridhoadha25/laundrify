<?php
require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;

include '../config/koneksi.php';

$id = $_GET['id'];

// ambil data order + pelanggan
$data = mysqli_query($conn, "
    SELECT orders.*, pelanggan.nama, pelanggan.no_hp
    FROM orders
    JOIN pelanggan ON orders.pelanggan_id = pelanggan.id
    WHERE orders.id='$id'
");

$row = mysqli_fetch_assoc($data);

// isi HTML
$html = "
<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
    }
    .container {
        width: 100%;
        padding: 10px;
    }
    .header {
        text-align: center;
    }
    .header h2 {
        margin: 0;
    }
    .line {
        border-bottom: 1px dashed #000;
        margin: 10px 0;
    }
    .table {
        width: 100%;
    }
    .table td {
        padding: 5px 0;
    }
    .right {
        text-align: right;
    }
    .center {
        text-align: center;
    }
</style>

<div class='container'>

    <div class='header'>
        <h2>LAUNDRY APP</h2>
        <small>Struk Order</small>
    </div>

    <div class='line'></div>

    <table class='table'>
        <tr>
            <td>Nama</td>
            <td class='right'>{$row['nama']}</td>
        </tr>
        <tr>
            <td>Berat</td>
            <td class='right'>{$row['berat']} Kg</td>
        </tr>
        <tr>
            <td>Status</td>
            <td class='right'>{$row['status']}</td>
        </tr>
        <tr>
            <td>Pembayaran</td>
            <td class='right'>{$row['status_bayar']}</td>
        </tr>
    </table>

    <div class='line'></div>

    <table class='table'>
        <tr>
            <td><b>Total</b></td>
            <td class='right'><b>Rp " . number_format($row['total']) . "</b></td>
        </tr>
    </table>

    <div class='line'></div>

    <p class='center'>Terima kasih</p>

</div>
";

// inisialisasi dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// ukuran kertas
$dompdf->setPaper('A6', 'portrait');

// render
$dompdf->render();

// tampilkan PDF
$dompdf->stream("struk_laundry.pdf", array("Attachment" => false));
?>