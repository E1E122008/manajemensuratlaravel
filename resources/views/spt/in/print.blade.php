<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Print SPT Dalam Daerah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 2cm;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            margin-bottom: 20px;
        }
        .footer {
            margin-top: 50px;
        }
        table {
            width: 100%;
        }
        .signature {
            float: right;
            width: 200px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h4 style="margin:0;">PEMERINTAH KABUPATEN BALANGAN</h4>
        <h3 style="margin:0;">BADAN HUKUM</h3>
        <p style="margin:0;">Alamat: Jl. A. Yani Km. 4,5 Telp/Fax. (0526) 2028502</p>
        <p style="margin:0;">PARINGIN - BALANGAN</p>
        <hr style="border-top: 3px double #000;">
    </div>

    <div class="content">
        <div style="text-align: center; margin-bottom: 20px;">
            <h4 style="margin:0;">SURAT PERINTAH TUGAS</h4>
            <p style="margin:0;">Nomor: {{ $spt->nomor_spt }}</p>
        </div>

        <div style="margin-bottom: 20px;">
            <p>Yang bertanda tangan di bawah ini:</p>
            <table>
                <tr>
                    <td width="120">Nama</td>
                    <td>: [Nama Kepala Badan]</td>
                </tr>
                <tr>
                    <td>NIP</td>
                    <td>: [NIP Kepala Badan]</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>: Kepala Badan Hukum</td>
                </tr>
            </table>
        </div>

        <div style="margin-bottom: 20px;">
            <p>Memerintahkan kepada:</p>
            <table>
                <tr>
                    <td width="120">Nama</td>
                    <td>: {{ $spt->employee->nama }}</td>
                </tr>
                <tr>
                    <td>NIP</td>
                    <td>: {{ $spt->employee->nip }}</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>: {{ $spt->employee->jabatan }}</td>
                </tr>
            </table>
        </div>

        <div style="margin-bottom: 20px;">
            <p>Untuk:</p>
            <p>{{ $spt->perihal }}</p>
        </div>
    </div>

    <div class="footer">
        <div class="signature">
            <p>Paringin, {{ $spt->tanggal->isoFormat('D MMMM Y') }}</p>
            <p>Kepala Badan Hukum</p>
            <br><br><br>
            <p>[Nama Kepala Badan]</p>
            <p>NIP. [NIP Kepala Badan]</p>
        </div>
    </div>
</body>
</html> 