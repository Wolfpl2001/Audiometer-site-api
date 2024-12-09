document.addEventListener('DOMContentLoaded', function () {
    const customLabels = ['125 Hz', '250 Hz', '500 Hz', '750 Hz', '1000 Hz', '1500 Hz', '2000 Hz', '3000 Hz', '4000 Hz', '6000 Hz', '8000 Hz'];

    function playAndUpdateChart(ear, frequency, decibel) {
        try {
            validateInputs(ear, frequency, decibel);
            if (ear === 'both') {
                playBeep(frequency, decibel, 'links');
                playBeep(frequency, decibel, 'rechts');
            } else {
                playBeep(frequency, decibel, ear);
            }
        } catch (error) {
            alert(error.message);
        }
    }

    function validateInputs(ear, frequency, decibel) {
        const validEars = ['links', 'rechts', 'both'];
        if (!validEars.includes(ear)) {
            throw new Error('Invalid ear selection. Choose "links", "rechts", or "both".');
        }
        if (isNaN(frequency) || frequency <= 0) {
            throw new Error('Invalid frequency value.');
        }
        if (isNaN(decibel) || decibel < 0) {
            throw new Error('Invalid decibel value.');
        }
    }

    function playBeep(frequency, decibels, ear) {
        const standardDecibels = -35;
        const totalDecibels = standardDecibels + parseFloat(decibels);
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        oscillator.type = 'sine';
        oscillator.frequency.setValueAtTime(frequency, audioContext.currentTime);
        const gainValue = Math.pow(10, totalDecibels / 20);
        const gainNode = audioContext.createGain();
        gainNode.gain.value = gainValue / 1000;
        const panner = audioContext.createStereoPanner();
        panner.pan.setValueAtTime(ear === 'links' ? -1 : ear === 'rechts' ? 1 : 0, audioContext.currentTime);
        oscillator.connect(gainNode);
        gainNode.connect(panner);
        panner.connect(audioContext.destination);
        oscillator.start();
        setTimeout(() => {
            oscillator.stop();
        }, 3000);
    }

    const playBtn = document.getElementById("play-sound");
    playBtn.addEventListener("click", function () {
        const ear = document.getElementById('ear').value;
        const frequency = parseFloat(document.getElementById('hertz').value);
        const decibel = parseFloat(document.getElementById('decibel').value);
        playAndUpdateChart(ear, frequency, decibel);
    });


    function adjustValue(selectElement, increment) {
        const selectedIndex = selectElement.selectedIndex;
        if (selectedIndex !== -1) {
            const options = selectElement.options;
            const newIndex = Math.min(Math.max(selectedIndex + (increment ? -1 : 1), 0), options.length - 1);
            selectElement.selectedIndex = newIndex;
        }
    }

    const hertzSelect = document.getElementById('hertz');
    const decibelSelect = document.getElementById('decibel');
    const hertzUpButton = document.getElementById('hertz-up');
    const hertzDownButton = document.getElementById('hertz-down');
    const decibelUpButton = document.getElementById('decibel-up');
    const decibelDownButton = document.getElementById('decibel-down');

    hertzUpButton.addEventListener('click', () => adjustValue(hertzSelect, true));
    hertzDownButton.addEventListener('click', () => adjustValue(hertzSelect, false));
    decibelUpButton.addEventListener('click', () => adjustValue(decibelSelect, true));
    decibelDownButton.addEventListener('click', () => adjustValue(decibelSelect, false));
});
