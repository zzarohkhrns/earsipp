<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Kontrol Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 20px;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 100px;
            height: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .footer {
            display: flex;
            justify-content: space-between;
        }
        .footer div {
            text-align: center;
            width: 45%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <table>
                <tr>
                    <th style="text-align: center; width: 300px">
                        <img src="data:image/jpeg;base64,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ZjO7bj1+H5fOT8q+mUauo9aPrgp1EpraigviIULMXLkhT5sKAOSBknjtLRK0pkiIldEREBERAREQEREBERAStdTdUDQNTp0bjaKbUqjknvuUqFUchfMXHJIAxyeciyyI1Xp+01W+W6uyxxSqUtnl2sr43ZyM54Hr6fWSUtnGkfr3UN7oWm0a14lNnJVq4UnbTp7lV2U92KmovfGRuPGJjdQ9WXelalXtqS028KnSdFbINQuxXZu7JyO5GOee2ZmfwbYvYNZ3dWrVDUBQDVNjMijdgqdnDebvyThfYTi46NtbkuK9euRUpJRqDKedEzgE7NwJyclSDz6SbcT1PO56kvKX3vaqfkXFGiuc8ioaeSee48Qdu+358eNLq25bWmsSlNtt2aBVSd6oE3+MefgGcHgDPrziSlbpizq3j199QLUenUqUwV2M1PbsJyu4fAuQGAO0Z7nPI6coLZ3VslWqBduzuQVypYBTs8vA2gDnJ/fmNriyHt+rNQu9PubilSpq1uTUKsWyaJpGrSbHBDtwCPTzeoxOanU+o0LG0u7oUVW6K4bDNtU0vEyRnJIIK9+Rg8dpJ1OlbFrivVpM6CvQ8B1QIq458wG34/MeeRz27TtV6at3tLW3SrVX7pjw2GzPC7BuyhB4J7ARtMWRdx1bdWWq07O8SnsqUVYVVzhaj+J4akHB2t4R9jkgfOSd9rde3s7QU1U1bpkQZyFXKl2Y+pAAOBnk45HedbnpOyvLSrb3tSrUFWklJixXPkZ3VwdvDhqhPtwOOJmX2iW15a0aLM6mgytSdSNylRtzyCpyCQQQQc/SNrHUjbnW9Ts9TFhcrSybetWyu7HkbC9zxuDKSPQ5GT3mXZ6zVrdJ0tYdV31aVNlTOBvqY2Jn5syjM6Hpii1yLmrXrs4pVaW5ihJFRizH4O4ONoGFAVRjHfztOkre3p06L169SnSFNVpv4ZTbTDBQQEGfjyT3JVOeI2fkxLLqytf21lSooq1ro1FYNkrSNIHxOByxDDAGR3znjnI1vqC70ZKAuaaEsy+OVJ201Zlphh68s4xn0Vvac2/R1hbVBVt6lVWWu9emwKfllxh1Ubduxh6EH3HPM5u+kLK+tKtC/qVahq00pl32F1C5PlOzgksSe/fjEbT88MLUerLuz16tp1NKbmm9BVQE+JUFX4iv/wCY5PGMd8S3yM03RaVhqVXUFqVHestNX37ceQEAjCjk5OfrJOWHVc+SIiV0REQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERA5iIkUiIgIiICIiAiIgIiICIiAiIgIiICIiAiIgIiICIiAiIgIiIH//2Q==" style="width:250px" alt="Logo">
                    </th>
                    <th style="text-align: center;">
                        <h1>KARTU KONTROL BARANG</h1>
                        <h2>K-NUCARE/KKBI</h2>
                        <h1>NUCARE LAZISNU CILACAP</h1>
                    </th>
                </tr>
            </table>
        </div>
        <div class="details">
            <table id="example3" style="width: 100%; border: none;">
                <tr>
                    <th style="width: 150px; border: none;">
                        <b>Nama barang : </b>
                    </th>
                    <td style="border: none;">
                        <!-- inputan nama barang -->
                    </td>
                    <th style="width: 150px; border: none;">
                        <b>Spesifikasi : </b>
                    </th>
                    <td style="border: none;">
                        <!-- inputan spesifikasi -->
                    </td>
                </tr>
                <tr>
                    <th style="width: 200px; border: none;">
                        <b>Tahun pembelian : </b>
                    </th>
                    <td style="border: none;">
                        <!-- inputan tahun pembelian -->
                    </td>
                    <th style="width: 200px; border: none;">
                        <b>Lokasi penyimpanan : </b>
                    </th>
                    <th style="border: none;">
                        <!-- inputan lokasi penyimpanan -->
                    </th>
                </tr>
            </table>
        </div>
        <table >
            <tr>
                <th style="text-align: center;" rowspan="2">No.</th>
                <th style="text-align: center;" rowspan="2">Tanggal</th>
                <th style="text-align: center;" colspan="2">Berfungsi</th>
                <th style="text-align: center;" colspan="2">Kondisi</th>
                <th style="text-align: center;" rowspan="2">Keterangan</th>
            </tr>
            <tr>
                <th style="text-align: center; width:100px">Ya</th>
                <th style="text-align: center; width:100px">Tidak</th>
                <th style="text-align: center; width:100px">Baik</th>
                <th style="text-align: center; width:100px">Tidak</th>
            </tr>
            <tr>
                <td style="text-align: center;"> {{-- inputan no --}} </td>
                <td style="text-align: center;"> {{-- inputan tanggal --}} </td>

                {{-- inputan berfungsi --}}
                <td style="text-align: center;"> {{-- inputan ya --}} </td>
                <td style="text-align: center;"> {{-- inputan tidak --}} </td>

                {{-- inputan kondisi --}}
                <td style="text-align: center;"> {{-- inputan ya --}} </td>
                <td style="text-align: center;"> {{-- inputan tidak --}} </td>
                
                <td style="text-align: center;"> {{-- inputan keterangan --}} </td>
            </tr>
        </table>
        <div class="footer">
            <table style=" width: 100%;">
                <tr>
                    <th style="text-align: center; width: 50%;">
                        <p>Penanggungjawab barang</p>
                        <p>Div. Logistik</p>
                    </th>
                    <th style="text-align: center; width: 50%;">
                        <p>Mengetahui,</p>
                        <p>Direktur NUCARE LAZISNU Cilacap</p>
                    </th>
                </tr>
                <tr>
                    <th style="text-align: center; width: 50%;">
                        <br><br><br><br><br><br>
                        <b>HALIN FAJAR WASKITHO</b>
                    </th>
                    <th style="text-align: center; width: 50%;">
                        <br><br><br><br><br><br>
                        <b>AHMAD FAUZI</b>
                    </th>
                </tr>
            </table>
        </div>
        <p><i>Form ini diserahkan ke div.administrasi, kartu ini digunakan seminggu sekali</i></p>
    </div>
</body>
</html>
