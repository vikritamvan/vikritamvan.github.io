<?php
// Pastikan input tersedia
if (!isset($_POST['files'], $_POST['nominal'], $_POST['hari'])) {
    echo "Input tidak lengkap.";
    exit;
}

$files = $_POST['files'];
$nominal = floatval($_POST['nominal']);
$hari = intval($_POST['hari']);
$risk_free = 0.0575 / 252; // Risk-free rate harian

$return_data = [];
foreach ($files as $file) {
    $path = "uploads/" . basename($file);
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $lines = array_map('floatval', array_slice($lines, 1)); // Lewati header jika ada
    $return_data[] = $lines;
}

// Sinkronisasi panjang data (minimum)
$min_len = min(array_map('count', $return_data));
$return_data = array_map(fn($arr) => array_slice($arr, 0, $min_len), $return_data);

// Transpose: per hari
$returns_transposed = [];
for ($i = 0; $i < $min_len; $i++) {
    $row = [];
    foreach ($return_data as $col) {
        $row[] = $col[$i];
    }
    $returns_transposed[] = $row;
}

// Hitung return rata-rata dan std dev
$means = [];
$stds = [];
foreach ($return_data as $col) {
    $mean = array_sum($col) / count($col);
    $means[] = $mean;
    $variance = array_sum(array_map(fn($x) => pow($x - $mean, 2), $col)) / (count($col) - 1);
    $stds[] = sqrt($variance);
}

// Hitung Sharpe Ratio dan bobot optimal
$sharpe_ratios = [];
foreach ($means as $i => $mean) {
    $sharpe = ($mean - $risk_free) / ($stds[$i] ?: 1e-6); // Hindari div 0
    $sharpe_ratios[] = max(0, $sharpe); // Tidak boleh negatif (optional, bisa kamu ubah sesuai strategi)
}
$total_sharpe = array_sum($sharpe_ratios);

// Jika semua Sharpe = 0, beri bobot merata
if ($total_sharpe == 0) {
    $num_assets = count($sharpe_ratios);
    $weights = array_fill(0, $num_assets, 1 / $num_assets);
} else {
    $weights = array_map(fn($s) => $s / $total_sharpe, $sharpe_ratios);
}

// Hitung return portofolio harian
$port_returns = [];
foreach ($returns_transposed as $daily) {
    $r = 0;
    foreach ($daily as $j => $val) {
        $r += $val * $weights[$j];
    }
    $port_returns[] = $r;
}

// Hitung statistik portofolio
$mean_port = array_sum($port_returns) / count($port_returns);
$var_port = array_sum(array_map(fn($x) => pow($x - $mean_port, 2), $port_returns)) / (count($port_returns) - 1);
$std_port = sqrt($var_port);

// Hitung VaR 99%
$z = 2.326; // 99%
$VaR = $z * $std_port * $nominal * sqrt($hari);
$VaR = round($VaR, 2);

// Format hasil
$formatted = number_format($VaR, 2, ',', '.');
?>

<div class="message bot">
    Dengan investasi sesuai proporsi pada saham yang dipilih, maka kemungkinan kerugian maksimal dalam 
    <strong><?php echo $hari; ?> hari</strong> investasi dengan 
    <strong>Rp <?php echo number_format($nominal, 0, ',', '.'); ?></strong> adalah 
    <strong>Rp <?php echo $formatted; ?></strong> dengan tingkat keyakinan <strong>99%</strong>.
</div>

<div class="message bot">
    <h4>📊 Rincian Proporsi dan Alokasi Dana:</h4>
    <ul>
        <?php
        $total_percent = 0;
        foreach ($files as $i => $file) {
            $w = $weights[$i];
            $uang = round($w * $nominal, 2);
            $persen = round($w * 100, 2);
            $total_percent += $persen;
            echo "<li><strong>" . htmlspecialchars($file) . "</strong>: $persen% (Rp " . number_format($uang, 2, ',', '.') . ")</li>";
        }
        echo "<li><em>Total: " . round($total_percent, 2) . "%</em></li>";
        ?>
    </ul>
</div>

<canvas id="chart" width="600" height="300"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [...Array(<?php echo count($port_returns); ?>).keys()],
        datasets: [{
            label: 'Return Harian Portofolio',
            data: <?php echo json_encode($port_returns); ?>,
            fill: false,
            borderColor: 'blue',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        scales: {
            x: { display: true, title: { display: true, text: 'Hari ke-' }},
            y: { display: true, title: { display: true, text: 'Return' }}
        }
    }
});
</script>
