<?php
// Ambil semua file CSV dari folder uploads
$files = array_filter(scandir('uploads'), function($file) {
    return pathinfo($file, PATHINFO_EXTENSION) === 'csv';
});
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chatbot Investasi Saham</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .chatbox { background: #f5f5f5; padding: 20px; border-radius: 10px; max-width: 600px; margin: auto; }
        .message { margin-bottom: 10px; }
        .bot { color: #333; }
        .user { font-weight: bold; }
        button { margin-top: 10px; }
        canvas { margin-top: 20px; }
    </style>
    <script>
    function validateForm() {
        const max = parseInt(document.getElementById('jumlah_max').value);
        const checked = document.querySelectorAll("input[name='files[]']:checked").length;
        if (checked !== max) {
            alert("Anda harus memilih tepat " + max + " saham.");
            return false;
        }

        const nominal = document.getElementById("nominal").value;
        const hari = document.getElementById("hari").value;
        if (!nominal || !hari || nominal <= 0 || hari <= 0) {
            alert("Masukkan nominal investasi dan periode hari dengan benar.");
            return false;
        }

        return true;
    }
    </script>
</head>
<body>
<div class="chatbox">

<?php if (!isset($_POST['jumlah'])): ?>
    <div class="message bot">Halo! Berapa banyak saham yang ingin Anda investasikan?</div>
    <form method="POST" action="">
        <input type="number" name="jumlah" min="2" max="<?php echo count($files); ?>" required>
        <button type="submit">Lanjut</button>
    </form>

<?php elseif (!isset($_POST['files'])): ?>
    <?php $jumlah = intval($_POST['jumlah']); ?>
    <div class="message bot">Silakan pilih tepat <?php echo $jumlah; ?> saham dari daftar berikut:</div>
    <form method="POST" action="calculate_simulated.php" onsubmit="return validateForm();">
        <?php
        foreach ($files as $file) {
            echo "<input type='checkbox' name='files[]' value='$file'> $file<br>";
        }
        ?>
        <input type="hidden" name="jumlah_max" id="jumlah_max" value="<?php echo $jumlah; ?>">

        <div class="message bot" style="margin-top: 20px;">Berapa nominal investasi Anda (Rp)?</div>
        <input type="number" name="nominal" id="nominal" required>

        <div class="message bot" style="margin-top: 20px;">Berapa lama periode investasi yang diinginkan (hari)?</div>
        <input type="number" name="hari" id="hari" required>

        <button type="submit" style="margin-top: 20px;">Hitung Portofolio dan VaR</button>
    </form>
<?php endif; ?>

</div>
</body>
</html>
