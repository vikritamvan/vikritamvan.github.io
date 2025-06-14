<!DOCTYPE html>
<html>
<head>
    <title>Selamat Datang - Chatbot Investasi Saham</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #e0f7fa, #ffffff);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .intro-box {
            background: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 600px;
        }

        h1 {
            color: #00796b;
        }

        p {
            font-size: 18px;
            color: #555;
            margin-top: 20px;
        }

        .btn-start {
            margin-top: 30px;
            padding: 12px 25px;
            font-size: 16px;
            border: none;
            background-color: #00796b;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-start:hover {
            background-color: #004d40;
        }
    </style>
</head>
<body>

<div class="intro-box">
    <h1>Selamat Datang di Chatbot Investasi Portofolio Saham</h1>
    <p>
        “Investasi bukan tentang seberapa banyak uang yang kamu hasilkan hari ini,<br>
        tapi seberapa bijak kamu mempersiapkan masa depanmu.”
    </p>
    <p>
        Gunakan alat ini untuk membantu memilih portofolio saham terbaik berdasarkan rasio Sharpe.<br>
        Yuk, mulai perjalanan investasimu sekarang!
    </p>

    <form action="index.php" method="get">
        <button type="submit" class="btn-start">Mulai</button>
    </form>
</div>

</body>
</html>
