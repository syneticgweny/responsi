<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pendidikan Kota Yogyakarta</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: hsla(353, 85%, 82%, 0.957);
            /* Warna soft pink */
            font-family: 'Fredoka', Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            background-color: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f8d7da;
            color: black;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        td {
            text-align: center;
        }

        h2 {
            text-align: center;
            color: rgb(16, 15, 15);
            margin-top: 20px;
        }

        .delete-btn {
            background-color: #f8d7da;
            color: black;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }

        .delete-btn:hover {
            background-color: #f8d7da;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-danger-subtle">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fa-solid fa-map-location-dot"></i> Bangunan Pendidikan Kota Yogyakarta</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="homepage.html" target="_blank">
                            <i class="fa-solid fa-house"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html" target="_blank">
                            <i class="fa-solid fa-map"></i> Map</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="info.html" target="_blank">
                            <i class="fa-solid fa-info-circle"></i> Info</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <h2>Data Fasilitas Pendidikan Kota Yogyakarta</h2>

    <?php
    // Konfigurasi koneksi database
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "responsiweb";

    // Membuat koneksi
    $conn = new mysqli($host, $username, $password, $dbname);

    // Cek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Mengecek apakah ada permintaan hapus data
    if (isset($_GET['delete_id'])) {
        $delete_id = intval($_GET['delete_id']);
        $delete_sql = "DELETE FROM pendidikan WHERE id = ?";

        // Menggunakan prepared statement untuk keamanan
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $delete_id);

        if ($stmt->execute()) {
            echo "<p style='text-align:center;color:green;'>Data berhasil dihapus</p>";
        } else {
            echo "<p style='text-align:center;color:red;'>Gagal menghapus data</p>";
        }
        $stmt->close();
    }

    // Query untuk mengambil data dari tabel "pendidikan"
    $sql = "SELECT * FROM pendidikan";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table><tr>
<th>Kecamatan</th>
<th>X</th>
<th>Y</th>
<th>Keterangan</th>
<th>Aksi</th></tr>";

        // Menampilkan data baris
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td align='left'>" . htmlspecialchars($row["kecamatan"]) . "</td><td>" .
                htmlspecialchars($row["x"]) . "</td><td>" .
                htmlspecialchars($row["y"]) . "</td><td>" .
                htmlspecialchars($row["keterangan"]) . "</td>
            <td><a class='delete-btn' href='data.php?delete_id=" . $row["id"] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Delete</a></td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align:center;'>Tidak ada data ditemukan.</p>";
    }

    $conn->close();
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
