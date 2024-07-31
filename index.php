<?php
// aseta oma webhookkisi URL osoite tähän
// Sivuston on koodannut Thearex12 (https://thearex12.com)
$webhookUrl = "Sinun oma webhook URL";
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Porttikiellon poistopyyntö -lomake</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffe0;
            color: #0000ff;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        h1 {
            color: #ff0000;
            text-shadow: 2px 2px 2px #aaa;
        }
        form {
            background-color: #ffcc99;
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            border: 5px solid #000;
            box-shadow: 10px 10px 5px #888;
            position: relative;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #0000ff;
        }
        input[type="text"],
        textarea {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 2px solid #000;
            border-radius: 5px;
            background-color: #ff9999;
            color: #0000ff;
        }
        input[type="submit"] {
            background-color: #ff0000;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #ff6666;
        }
        .loader-container,
        .error-container,
        .success-container {
            display: none;
            text-align: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 1000;
        }
        .loader-bar-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
            position: relative;
        }
        .loader-bar {
            width: 50%;
            background-color: #ddd;
            height: 30px;
            border: 2px solid #000;
            margin-top: 20px;
        }
        .loader-fill {
            height: 100%;
            background-color: #3498db;
            transition: width 0.5s linear;
        }
        .loading-text {
            font-size: 16px;
            color: #ff0000;
            margin-top: 10px;
        }
        .roast-text {
            font-size: 18px;
            color: #0000ff;
            margin-top: 20px;
        }
        .error-message,
        .success-message {
            font-size: 20px;
            color: #ff0000;
            margin-top: 20%;
            padding: 0 10%;
        }
        .error-buttons a {
            text-decoration: none;
            color: white;
            background-color: #ff0000;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            margin: 0 10px;
            display: inline-block;
        }
        .error-buttons a:hover {
            background-color: #ff6666;
        }
    </style>
    <script>
        const roastTexts = [
            "Hakkerointi? Vau, kuinka luovaa – sanoo kukaan koskaan. Älä vaivautuisi enää.",
            "Reilusti pelaaminen on aivan liian vaikeaa sinulle, vai mitä?",
            "Ehkä tämä ban on juuri se oppitunti, jota tarvitsit – toivottavasti opit jotain.",
            "Tämä banni kestää kauemmin kuin ikinä luulet oppivasi pelin säännöistä.",
            "Voisiko tämä olla se hetki, kun alat vihdoin käyttäytyä? Toivottavasti et yritä tätä uudelleen.",
            "Miksi ihmeessä palikkapelissä saat bannit?"
        ];

        function startLoading(callback) {
            document.querySelector(".loader-container").style.display = "block";
            const loaderFill = document.querySelector(".loader-fill");
            const roastTextElement = document.querySelector(".roast-text");
            let width = 0;
            let textIndex = 0;

            const progressInterval = setInterval(() => {
                width += 100 / 30; 
                loaderFill.style.width = width + "%";
                if (width >= 100) {
                    clearInterval(progressInterval);
                    document.querySelector(".loader-container").style.display = "none";
                    callback();
                }
            }, 1000); 

            const textInterval = setInterval(() => {
                roastTextElement.innerHTML = roastTexts[textIndex];
                textIndex = (textIndex + 1) % roastTexts.length;
            }, 3000);

            setTimeout(() => {
                clearInterval(textInterval);
            }, 30000);
        }

        function showError() {
            document.querySelector(".error-container").style.display = "block";
        }

        function handleRetry() {
            document.querySelector('.error-container').style.display = 'none';
            startLoading(() => {
                document.querySelector('form').submit();
            });
        }

        function handleStayBanned() {
            document.querySelector('.error-container').style.display = 'none';
            location.reload();
        }

        function simulateSlowSubmission(event) {
            event.preventDefault();
            startLoading(showError);
        }

    </script>
</head>
<body>
    <h1>Hae Porttikiellon poistoa</h1>
    <form action="" method="post" onsubmit="simulateSlowSubmission(event)">
        <label for="playerName">Pelaajan nimi:</label>
        <input type="text" id="playerName" name="playerName" required><br>

        <label for="banIssuer">Porttikiellon antaja:</label>
        <input type="text" id="banIssuer" name="banIssuer" required><br>

        <label for="banDuration">Porttikiellon pituus:</label>
        <input type="text" id="banDuration" name="banDuration" required><br>

        <label for="unbanReason">Miksi sinun porttikieltosi pitäisi poistaa?</label>
        <textarea id="unbanReason" name="unbanReason" required></textarea><br>

        <label for="ethicsQuestion">Miksi totuus on tärkeä peliympäristössä?</label>
        <input type="text" id="ethicsQuestion" name="ethicsQuestion" required><br>

        <label for="roastQuestion">Miten aiot välttää saman virheen, jonka teit ennen porttikieltoa?</label>
        <input type="text" id="roastQuestion" name="roastQuestion" required><br>

        <label for="selfReflectionQuestion">Mitä olet oppinut porttikiellostasi?</label>
        <input type="text" id="selfReflectionQuestion" name="selfReflectionQuestion" required><br>

        <input type="submit" value="Lähetä">
    </form>


<p>Eikö olekkin hieno sivusto? Sivuston teema on 2000-luku :D</p>
<p><a href="https://github.com/Thearex/unban-lomake">GitHub</a></p>

    <div class="loader-container">
        <div class="loader-bar-container">
            <div class="loader-bar">
                <div class="loader-fill"></div>
            </div>
            <div class="roast-text">Odota...</div>
        </div>
    </div>

    <div class="error-container">
        <div class="error-message">
            <p>Tapahtui odottamaton virhe lähettäessä!</p>
            <div class="error-buttons">
                <a href="#" onclick="handleRetry()">Yritä uudelleen</a>
                <a href="#" onclick="handleStayBanned()">Kärsi porttikielto</a>
            </div>
        </div>
    </div>

    <div class="success-container">
        <div class="success-message">
            <p>Hakemus on lähetetty onnistuneesti!</p>
	    <p>Et kai katsonut tiktokkia odotellessasi?</p>
        </div>
    </div>

<audio id="musa"></audio> 
<script>
        document.addEventListener('DOMContentLoaded', function() {
            const audioElement = document.getElementById('musa');
            const musa = ['xd.mp3'];
            let currentMusiikkiIndex = 0;

            audioElement.addEventListener('ended', function() {
                currentMusiikkiIndex = (currentMusiikkiIndex + 1) % musa.length;
                audioElement.src = musa[currentMusiikkiIndex];
                audioElement.play();
            });

            audioElement.src = musa[currentMusiikkiIndex];
            audioElement.play().catch(error => {
                console.error('Äänen toisto epäonnistui:', error);
            });
        });
</script>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errors = [];

        $playerName = !empty($_POST['playerName']) ? $_POST['playerName'] : $errors[] = 'Pelaajan nimi on pakollinen';
        $banIssuer = !empty($_POST['banIssuer']) ? $_POST['banIssuer'] : $errors[] = 'Porttikiellon antaja on pakollinen';
        $banDuration = !empty($_POST['banDuration']) ? $_POST['banDuration'] : $errors[] = 'Porttikiellon pituus on pakollinen';
        $unbanReason = !empty($_POST['unbanReason']) ? $_POST['unbanReason'] : $errors[] = 'Porttikiellon poistopyynnön syy on pakollinen';
        $ethicsQuestion = !empty($_POST['ethicsQuestion']) ? $_POST['ethicsQuestion'] : $errors[] = 'Eettinen kysymys on pakollinen';
        $roastQuestion = !empty($_POST['roastQuestion']) ? $_POST['roastQuestion'] : $errors[] = 'Roast-kysymys on pakollinen';
        $selfReflectionQuestion = !empty($_POST['selfReflectionQuestion']) ? $_POST['selfReflectionQuestion'] : $errors[] = 'Itsereflektio on pakollinen';

        if (empty($errors)) {
            
            $message = [
                "embeds" => [
                    [
                        "title" => "Uusi Porttikiellon poistopyyntö",
                        "fields" => [
                            ["name" => "Pelaajan nimi", "value" => $playerName, "inline" => true],
                            ["name" => "Porttikiellon antaja", "value" => $banIssuer, "inline" => true],
                            ["name" => "Porttikiellon pituus", "value" => $banDuration, "inline" => true],
                            ["name" => "Miksi sinun porttikieltosi pitäisi poistaa?", "value" => $unbanReason, "inline" => false],
                            ["name" => "Miksi totuus on tärkeä peliympäristössä?", "value" => $ethicsQuestion, "inline" => false],
                            ["name" => "Miten aiot välttää saman virheen, jonka teit ennen porttikieltoa?", "value" => $roastQuestion, "inline" => false],
                            ["name" => "Mitä olet oppinut porttikiellostasi?", "value" => $selfReflectionQuestion, "inline" => false],
                        ]
                    ]
                ]
            ];

            $ch = curl_init($webhookUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode == 204) {
                echo "<script>document.querySelector('.success-container').style.display = 'block';</script>";
            } else {
                echo "<script>document.querySelector('.error-container').style.display = 'block';</script>";
                echo "<script>document.querySelector('.error-message').innerHTML = '<p>Oho! Näyttää siltä, että hakemuksesi lähettäminen epäonnistui.</p><p>Yritä uudelleen tai ota yhteyttä ylläpitoon.</p>';</script>";
            }
        } else {
            echo "<script>document.querySelector('.error-container').style.display = 'block';</script>";
            echo "<script>document.querySelector('.error-message').innerHTML = '<p>Seuraavat virheet tapahtuivat:</p><ul>";
            foreach ($errors as $error) {
                echo "<li>$error</li>";
            }
            echo "</ul><p>Täytä kaikki kentät.</p>';</script>";
        }
    }
    ?>
</body>
</html>

