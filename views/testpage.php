<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SoundSense</title>
    <link rel="stylesheet" href="/public/css/test.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="header">
    <h1>SoundSense Test</h1>
    <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === 1): ?>
        <a href="/manageusers" class="btn">Manage Users</a>
    <?php endif; ?>
    <a href="/logout" class="btn">Logout</a>

</div>

<div class="input-container">
    <div class="row">
        <label for="ear">Selecteer Oor: </label>
        <select id="ear">
            <option value="links">Links</option>
            <option value="rechts">Rechts</option>
            <option value="both">Both</option>
        </select>
    </div>
    <div class="row">
        <label for="hertz">Hertz: </label>
        <select id="hertz">
            <option value="8000">8000 Hertz</option>
            <option value="6000">6000 Hertz</option>
            <option value="4000">4000 Hertz</option>
            <option value="3000">3000 Hertz</option>
            <option value="2000">2000 Hertz</option>
            <option value="1500">1500 Hertz</option>
            <option value="1000">1000 Hertz</option>
            <option value="750">750 Hertz</option>
            <option value="500">500 Hertz</option>
            <option value="250">250 Hertz</option>
            <option value="125">125 Hertz</option>
        </select>
        <button class="arrow" id="hertz-up">↑</button>
        <button class="arrow" id="hertz-down">↓</button>
    </div>
    <div class="row">
        <label for="decibel">Decibel: </label>
        <select id="decibel">
            <option value="40">40 Db</option>
            <option value="35">35 Db</option>
            <option value="30">30 Db</option>
            <option value="25">25 Db</option>
            <option value="20">20 Db</option>
            <option value="15">15 Db</option>
            <option value="10">10 Db</option>
            <option value="5">5 Db</option>
            <option value="0">0 Db</option>
            <option value="-5">-5 Db</option>
            <option value="-10">-10 Db</option>
        </select>
        <button class="arrow" id="decibel-up">↑</button>
        <button class="arrow" id="decibel-down">↓</button>
    </div>
    <div class="row">
        <button id="play-sound" class="action-btn">Play Sound</button>
        <button id="gehoord" class="action-btn">Sound Heard</button>
        <button id="downloadBtn" class="action-btn">Download</button>
    </div>
</div>

<div class="chart">
    <canvas id="lineChart"></canvas>
</div>

<script src="/SoundSense/public/JS/soundtest.js"></script>
<script src="/SoundSense/public/JS/chartloader.js"></script>
<script src="/SoundSense/public/JS/xmltest.js"></script>
<script>
    // Get references to elements

    const hertzSelect = document.getElementById('hertz');
    const decibelSelect = document.getElementById('decibel');
    const hertzUpButton = document.getElementById('hertz-up');
    const hertzDownButton = document.getElementById('hertz-down');
    const decibelUpButton = document.getElementById('decibel-up');
    const decibelDownButton = document.getElementById('decibel-down');

    function adjustValue(selectElement, increment) {

        const selectedIndex = selectElement.selectedIndex;
        if (selectedIndex !== -1) {
            const options = selectElement.options;
            const newIndex = Math.min(Math.max(selectedIndex + (increment ? -0.5 : 0.5), 0), options.length - 0.5);

            selectElement.selectedIndex = newIndex;
        }
    }


    // Event listeners for hertz and decibel adjustment
    hertzUpButton.addEventListener('click', () => adjustValue(hertzSelect, true));
    hertzDownButton.addEventListener('click', () => adjustValue(hertzSelect, false));
    decibelUpButton.addEventListener('click', () => adjustValue(decibelSelect, true));
    decibelDownButton.addEventListener('click', () => adjustValue(decibelSelect, false));
</script>
</body>
</html>
