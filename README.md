# website_telkom
<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'har16';

$koneksi = new mysqli($host, $username, $password, $database);
if ($koneksi->connect_error) {
    die("❌ Koneksi gagal: " . $koneksi->connect_error);
}

function query($koneksi, $query, $types = '', ...$params) {
    $stmt = $koneksi->prepare($query);
    if (!$stmt) die("❌ Query error: " . $koneksi->error);
    if ($types && $params) $stmt->bind_param($types, ...$params);
    $stmt->execute();
    return $stmt;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nama_barang = $_POST['nama_barang'];
    $jumlah = (int)$_POST['jumlah'];
    $jenis = $_POST['jenis'];
    $nama_pengambil = $_POST['nama_pengambil'];

    if ($id) {
        query($koneksi, "UPDATE pea SET nama_barang=?, jumlah=?, jenis=?, nama_pengambil=? WHERE id=?", "sissi", $nama_barang, $jumlah, $jenis, $nama_pengambil, $id);
    } else {
        query($koneksi, "INSERT INTO pea (nama_barang, jumlah, jenis, nama_pengambil) VALUES (?, ?, ?, ?)", "siss", $nama_barang, $jumlah, $jenis, $nama_pengambil);
    }
    header("Location: index.php");
    exit;
}

if (isset($_GET['hapus'])) {
    query($koneksi, "DELETE FROM pea WHERE id=?", "i", $_GET['hapus']);
    header("Location: index.php");
    exit;
}

$edit_data = null;
if (isset($_GET['edit'])) {
    $result = query($koneksi, "SELECT * FROM pea WHERE id=?", "i", $_GET['edit'])->get_result();
    $edit_data = $result->fetch_assoc();
}

$result = query($koneksi, "SELECT * FROM pea")->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC);

$stok_awal = [
    "MeiG CAT4 SLT728-ID" => 1,
    "ONT_FIBERHOME_HG6145D2" => 42,
    "ONT_FIBERHOME_HG6145F" => 7,
    "ONT_FIBERHOME_HG6245N" => 8,
    "ONT_HUAWEI HG8245W5-6T" => 34,
    "ONT_ZTE_F609_V5.3" => 6,
    "ONT_ZTE_F670 V2.0" => 14,
    "ONT_ZTE_F672Y" => 11,
    "ORBIT_SS ex ROUTER_HKM0128a" => 3,
    "ORBIT_SS_ZTE_K10_STAR_Z2" => 12,
    "SetTopBox_ZTE_ZX10_B866F_V1.1" => 33,
    "SIM_CARD_TELKOMSEL" => 4,
    "Clamp-Hook" => 272,
    "OTP FTTH 1 Port With Adaptor" => 717,
    "Precon KSO Indoor Trans 15 mtr dgn Roset" => 359,
    "S-Clamp-Springer" => 915,
    "Splice on Connector Ilsintech" => 78,
    "Precon 1 core 40 M Tanpa Accessories" => 20,
    "Precon 1 core 50 M Tanpa Accessories" => 17,
    "Precon 1 core 60 M Tanpa Accessories" => 22,
    "Precon 1 core 70 M Tanpa Accessories" => 15,
    "Precon 1 core 80 M Tanpa Accessories" => 0,
    "Precon 1 core 100 Mtr Tanpa Accessories" => 13,
    "Precon 1 core 150 Mtr Tanpa Accessories" => 28,
    "AC-OF-SM-1B  DC FO aerial 1 Core Single mode G657  M"=>   8820,
];

$stok_akhir = $stok_awal;
foreach ($data as $row) {
    $nama = $row['nama_barang'];
    $jumlah = (int)$row['jumlah'];
    $jenis = $row['jenis'];
    if (!isset($stok_akhir[$nama])) $stok_akhir[$nama] = 0;
    $stok_akhir[$nama] += ($jenis === 'masuk') ? $jumlah : -$jumlah;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>STOCK GUDANG by ARLANGSS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0; padding: 0; box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #11131a, #2c2e3a);
            color: #fff; padding: 40px 20px;
        }
        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            text-align: center;
            background: linear-gradient(90deg, #FFD700, #FF8C00, #FFD700);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 10px rgba(255,215,0,0.5), 0 0 20px rgba(255,140,0,0.5);
            margin-bottom: 30px;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            padding: 30px;
            box-shadow: 0 0 20px rgba(255,215,0,0.1);
        }
        form input, form select, form button {
            width: 100%; padding: 14px; margin: 8px 0; border-radius: 12px;
            font-size: 1rem; border: none;
        }
        form button {
            background: linear-gradient(45deg, #f7971e, #ffd700);
            color: #000; font-weight: bold; cursor: pointer;
            box-shadow: 0 4px 10px rgba(255, 215, 0, 0.4);
        }
        table {
            width: 100%; border-collapse: collapse; margin-top: 30px;
            background: rgba(0,0,0,0.3); border-radius: 10px; overflow: hidden;
        }
        table th, table td {
            padding: 12px 10px; text-align: center;
            border: 1px solid #444;
        }
        table th {
            background-color: #222; color: #ffd700;
        }
        .grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px; margin-top: 40px;
        }
        .grid-item {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255,255,255,0.1);
            padding: 20px; border-radius: 16px; text-align: center;
            box-shadow: inset 0 0 10px rgba(255,255,255,0.05);
        }
        .grid-item h3 {
            margin-bottom: 10px;
            font-size: 1.1rem;
            color: #ffd700;
        }
        .grid-item p {
            font-size: 1.2rem;
            font-weight: bold;
        }
        a {
            color: #ffd700; text-decoration: none; font-weight: bold;
        }
        a:hover {
            text-decoration: underline; color: #fff;
        }
    </style>
</head>
<body>
    <h1>STOCK GUDANG by ARLANGSS</h1>
    <div class="container">
        <form method="post">
            <input type="hidden" name="id" value="<?= $edit_data['id'] ?? '' ?>">
            <select name="nama_barang" required>
                <option value="">-- Pilih Barang --</option>
                <?php foreach ($stok_awal as $nama => $stok): ?>
                    <option value="<?= htmlspecialchars($nama) ?>" <?= (isset($edit_data) && $edit_data['nama_barang'] === $nama) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($nama) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="number" name="jumlah" placeholder="Jumlah" min="1" required value="<?= $edit_data['jumlah'] ?? '' ?>">
            <select name="jenis" required>
                <option value="masuk" <?= (isset($edit_data) && $edit_data['jenis'] === 'masuk') ? 'selected' : '' ?>>Masuk</option>
                <option value="keluar" <?= (isset($edit_data) && $edit_data['jenis'] === 'keluar') ? 'selected' : '' ?>>Keluar</option>
            </select>
            <input type="text" name="nama_pengambil" placeholder="Nama Pengambil" required value="<?= $edit_data['nama_pengambil'] ?? '' ?>">
            <button type="submit"><?= $edit_data ? 'Update' : 'Simpan' ?></button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>No</th><th>Nama Barang</th><th>Jumlah</th><th>Jenis</th><th>Nama Pengambil</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($data as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                        <td><?= $row['jumlah'] ?></td>
                        <td><?= htmlspecialchars($row['jenis']) ?></td>
                        <td><?= htmlspecialchars($row['nama_pengambil']) ?></td>
                        <td>
                            <a href="?edit=<?= $row['id'] ?>">Edit</a> |
                            <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="grid">
            <?php foreach ($stok_akhir as $barang => $stok): ?>
                <div class="grid-item">
                    <h3><?= htmlspecialchars($barang) ?></h3>
                    <p><?= $stok ?> unit</p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>

