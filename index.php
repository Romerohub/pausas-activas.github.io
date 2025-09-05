<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Pausa Activa — Departamento Creativo</title>
    <style>
        :root {
            --bg: #0f1724;
            --card: #0b1220;
            --accent: #06b6d4;
            --muted: #94a3b8;
            --glass: rgba(255, 255, 255, 0.04)
        }

        * {
            box-sizing: border-box
        }

        body {
            margin: 0;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, 'Helvetica Neue', Arial;
            color: #e6eef6;
            background: linear-gradient(180deg, #071027 0%, #071627 100%);
            padding: 24px;
        }

        .container {
            max-width: 980px;
            margin: 0 auto
        }

        header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 18px
        }

        header h1 {
            font-size: 20px;
            margin: 0
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 18px
        }

        @media(max-width:900px) {
            .grid {
                grid-template-columns: 1fr
            }
        }

        .card {
            background: var(--card);
            padding: 16px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(2, 6, 23, 0.6);
        }

        .controls {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 12px
        }

        button {
            background: var(--accent);
            border: none;
            padding: 10px 14px;
            border-radius: 10px;
            color: #042;
            cursor: pointer;
            font-weight: 600
        }

        button.ghost {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.06);
            color: var(--muted)
        }

        .exercise-title {
            font-size: 22px;
            margin: 8px 0
        }

        .timer {
            font-size: 44px;
            font-weight: 700
        }

        .muted {
            color: var(--muted);
            font-size: 13px
        }

        .demo {
            height: 220px;
            border-radius: 10px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0.01));
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 12px 0;
            overflow: hidden;
            /* evita que sobresalga */
        }

        .demo video {
            max-height: 100%;
            max-width: 100%;
            border-radius: 12px;
            object-fit: contain;
            /* usa cover si quieres que llene */
        }


        .progress {
            height: 8px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 6px;
            overflow: hidden
        }

        .progress>i {
            display: block;
            height: 100%;
            background: linear-gradient(90deg, var(--accent), #60a5fa)
        }

        .settings {
            display: flex;
            gap: 8px;
            align-items: center;
            margin-bottom: 8px
        }

        label {
            font-size: 13px;
            color: var(--muted)
        }

        select,
        input[type=number] {
            padding: 8px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.04);
            background: transparent;
            color: #e6eef6
        }

        .history-list {
            max-height: 360px;
            overflow: auto;
            margin-top: 8px
        }

        .history-item {
            padding: 8px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.02);
            margin-bottom: 8px;
            font-size: 13px
        }

        .small {
            font-size: 12px
        }

        .export {
            margin-top: 8px
        }

        footer {
            margin-top: 18px;
            color: var(--muted);
            font-size: 13px;
            text-align: center
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <img src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='40' height='40'><rect rx='8' width='40' height='40' fill='%2306b6d4'/><text x='50%' y='55%' font-size='18' font-family='Arial' text-anchor='middle' fill='white'>PA</text></svg>" alt="logo" style="width:48px;height:48px;border-radius:10px;">
            <div>
                <h1>Pausa Activa — Departamento Creativo</h1>
                <div class="muted">Guía automática con voz, 8 ejercicios aleatorios por sesión.</div>
            </div>
        </header>

        <div class="grid">
            <main class="card">
                <div class="settings">
                    <label>Duración por ejercicio (seg): <input id="duration" type="number" min="10" max="300" value="30"></label>
                    <label>Voz: <select id="voiceSelect"></select></label>
                </div>

                <div class="controls">
                    <button id="startSession">Iniciar sesión</button>
                    <button id="pauseResume" class="ghost">Pausar</button>
                    <button id="skip" class="ghost">Saltar ejercicio</button>
                    <button id="end" class="ghost">Finalizar</button>
                </div>

                <div>
                    <div class="exercise-title" id="exTitle">Presiona "Iniciar sesión" para comenzar</div>
                    <div class="muted small">Ejercicio <span id="currentIndex">0</span> / 8</div>
                    <div class="timer" id="timer">00:00</div>
                    <div class="demo" id="demoArea">
                        <video id="demoVideo" autoplay muted loop playsinline></video>
                    </div>
                    <div class="muted" id="instruction">Aquí aparecerán las instrucciones del ejercicio.</div>

                    <div style="margin-top:12px">
                        <div class="progress"><i id="progressBar" style="width:0%"></i></div>
                    </div>
                </div>

                <div style="margin-top:14px">
                    <strong>Registro de sesión</strong>
                    <div class="muted">Hora de inicio: <span id="startTime">--</span></div>
                    <div class="muted">Hora de fin: <span id="endTime">--</span></div>
                    <div class="muted">Duración total: <span id="totalDuration">--</span></div>
                </div>
            </main>

            <aside class="card">
                <strong>Ejercicios (8 aleatorios)</strong>
                <ol id="exerciseList"></ol>

                <div style="margin-top:12px">
                    <strong>Historial</strong>
                    <div class="history-list" id="history"></div>
                    <div class="export">
                        <button id="exportCSV" class="ghost">Exportar CSV</button>
                    </div>
                </div>
            </aside>
        </div>

        <footer class="card" style="margin-top:18px">Este prototipo guarda el historial en tu navegador (localStorage). Puedo adaptar para servidor, autenticación o integrarlo a WordPress si quieres.</footer>
    </div>

    <script>
        // Base de datos de ejercicios
        const allExercises = [{
                name: 'Estiramiento de Cuello',
                instr: 'gira lentamente la cabeza en círculos hacia un lado y luego al otro.',
                video: 'Ejercicios/rotacion-cuello.mp4'
            },
            {
                name: 'Estiramiento lateral de cuello',
                instr: 'inclina la cabeza hacia un hombro, mantenla 15 segundos y cambia de lado.',
                video: 'Ejercicios/lateral-cuello.mp4'
            },
            {
                name: 'Estiramiento de muñecas',
                instr: 'con un brazo extendido, empuja suavemente los dedos hacia atrás y hacia abajo, mantén 15 segundos por lado.',
                video: 'Ejercicios/muneca.mp4'
            },
            {
                name: 'Círculos con muñecas',
                instr: 'Gira ambas muñecas, gira por ambos lados 15 segundos.',
                video: 'Ejercicios/rotacion-munecas.mp4'
            },
            {
                name: 'Giro de torso',
                instr: 'sentado o de pie, gira el torso suavemente hacia la derecha y luego a la izquierda, por 30 segundos.',
                video: 'Ejercicios/giro-torso.mp4'
            },
            {
                name: 'Inclinación lateral',
                instr: 'de pie, inclina el tronco hacia un lado manteniendo el brazo junto a la pierna, mantén 5 segundos y cambia de lado.',
                video: 'Ejercicios/inclinacion.mp4'
            },
            {
                name: 'Elevación de talones',
                instr: 'Ponte de puntillas y baja lentamente, repite a ritmo cómodo.',
                video: 'video1.mp4'
            },
            {
                name: 'Respiración profunda',
                instr: 'inhala por la nariz inflando el abdomen y exhala lentamente por la boca, repite 5 veces por 30 segundos.',
                video: 'Ejercicios/respirar.mp4'
            }
        ];

        let exercises = [];

        // elegir 8 ejercicios aleatorios
        function chooseRandomExercises() {
            const shuffled = [...allExercises].sort(() => Math.random() - 0.5);
            exercises = shuffled.slice(0, 8);
        }

        // DOM
        const exerciseListEl = document.getElementById('exerciseList');
        const exTitle = document.getElementById('exTitle');
        const instructionEl = document.getElementById('instruction');
        const demoImage = document.getElementById('demoImage');
        const currentIndexEl = document.getElementById('currentIndex');
        const timerEl = document.getElementById('timer');
        const progressBar = document.getElementById('progressBar');
        const startBtn = document.getElementById('startSession');
        const pauseBtn = document.getElementById('pauseResume');
        const skipBtn = document.getElementById('skip');
        const endBtn = document.getElementById('end');
        const startTimeEl = document.getElementById('startTime');
        const endTimeEl = document.getElementById('endTime');
        const totalDurationEl = document.getElementById('totalDuration');
        const historyEl = document.getElementById('history');
        const exportCSVBtn = document.getElementById('exportCSV');
        const durationInput = document.getElementById('duration');
        const voiceSelect = document.getElementById('voiceSelect');

        // state
        let current = -1;
        let timer = null;
        let remaining = 0;
        let startSessionTime = null;
        let paused = false;
        let history = JSON.parse(localStorage.getItem('pausas_history') || '[]');

        function renderExerciseList() {
            exerciseListEl.innerHTML = '';
            exercises.forEach((ex, i) => {
                const li = document.createElement('li');
                li.textContent = (i + 1) + '. ' + ex.name;
                exerciseListEl.appendChild(li);
            });
        }

        function renderHistory() {
            historyEl.innerHTML = '';
            if (history.length === 0) historyEl.innerHTML = '<div class="muted">Sin sesiones registradas aún.</div>';
            history.slice().reverse().forEach(h => {
                const d = document.createElement('div');
                d.className = 'history-item';
                d.innerHTML = `<div><strong>${h.startStr} — ${h.endStr}</strong></div>
                       <div class="muted small">Duración: ${h.durationStr} — ${h.count} ejercicios</div>`;
                historyEl.appendChild(d);
            });
        }
        renderHistory();

        // voices
        let voices = [];

        function loadVoices() {
            voices = speechSynthesis.getVoices();
            voiceSelect.innerHTML = '';
            voices.forEach((v, i) => {
                const opt = document.createElement('option');
                opt.value = i;
                opt.textContent = v.name + (v.lang ? ' (' + v.lang + ')' : '');
                voiceSelect.appendChild(opt);
            });
        }
        loadVoices();
        if (speechSynthesis.onvoiceschanged !== undefined) speechSynthesis.onvoiceschanged = loadVoices;

        function speak(text) {
            if (!('speechSynthesis' in window)) return;
            const u = new SpeechSynthesisUtterance(text);
            const sel = voiceSelect.value;
            if (voices[sel]) u.voice = voices[sel];
            u.rate = 0.95;
            window.speechSynthesis.cancel();
            window.speechSynthesis.speak(u);
        }

        function formatTimeSec(s) {
            const mm = Math.floor(s / 60).toString().padStart(2, '0');
            const ss = Math.floor(s % 60).toString().padStart(2, '0');
            return mm + ':' + ss;
        }

        function startTimer(sec) {
            remaining = sec;
            updateTimerDisplay();
            progressBar.style.width = '0%';
            const total = sec;
            timer = setInterval(() => {
                if (!paused) {
                    remaining--;
                    if (remaining < 0) {
                        clearInterval(timer);
                        timer = null;
                        nextExercise();
                        return;
                    }
                    updateTimerDisplay();
                    const pct = Math.round(((total - remaining) / total) * 100);
                    progressBar.style.width = pct + '%';
                }
            }, 1000);
        }

        function updateTimerDisplay() {
            timerEl.textContent = formatTimeSec(remaining);
        }

        function updateExerciseUI() {
            if (current < 0) {
                exTitle.textContent = 'Presiona "Iniciar sesión" para comenzar';
                instructionEl.textContent = '';
                demoVideo.src = '';
                currentIndexEl.textContent = '0';
            } else {
                const ex = exercises[current];
                exTitle.textContent = ex.name;
                instructionEl.textContent = ex.instr;
                demoVideo.src = ex.video;
                demoVideo.play();
                currentIndexEl.textContent = (current + 1) + '/8';
            }
        }


        function startSession() {
            if (startSessionTime) return;
            chooseRandomExercises();
            renderExerciseList();
            startSessionTime = new Date();
            startTimeEl.textContent = startSessionTime.toLocaleString();
            speak('Comenzamos la pausa activa. ' + exercises[0].name + '. ' + exercises[0].instr);
            current = 0;
            updateExerciseUI();
            startTimer(parseInt(durationInput.value, 10) || 30);
        }

        function pauseResume() {
            if (!startSessionTime) return;
            paused = !paused;
            pauseBtn.textContent = paused ? 'Reanudar' : 'Pausar';
            pauseBtn.classList.toggle('ghost');
            if (paused) speak('Pausa');
            else speak('Continuamos');
        }

        function nextExercise() {
            if (current < 0) return;
            speak('Ejercicio finalizado. Preparando siguiente.');
            current++;
            if (current >= exercises.length) {
                finishSession();
                return;
            }
            updateExerciseUI();
            startTimer(parseInt(durationInput.value, 10) || 30);
            speak('Siguiente: ' + exercises[current].name + '. ' + exercises[current].instr);
        }

        function skipExercise() {
            if (!startSessionTime) return;
            clearInterval(timer);
            timer = null;
            nextExercise();
        }

        function finishSession() {
            clearInterval(timer);
            timer = null;
            const end = new Date();
            endTimeEl.textContent = end.toLocaleString();
            const totalMs = end - startSessionTime;
            const secs = Math.round(totalMs / 1000);
            totalDurationEl.textContent = formatDuration(secs);
            speak('Has finalizado la pausa activa. Excelente trabajo.');
            const entry = {
                start: startSessionTime.getTime(),
                end: end.getTime(),
                durationSecs: secs,
                count: exercises.length,
                startStr: startSessionTime.toLocaleString(),
                endStr: end.toLocaleString(),
                durationStr: formatDuration(secs)
            };
            history.push(entry);
            localStorage.setItem('pausas_history', JSON.stringify(history));
            renderHistory();
            startSessionTime = null;
            current = -1;
            paused = false;
            pauseBtn.textContent = 'Pausar';
            updateExerciseUI();
        }

        function formatDuration(s) {
            const h = Math.floor(s / 3600);
            const m = Math.floor((s % 3600) / 60);
            const sec = s % 60;
            let out = '';
            if (h) out += h + 'h ';
            if (m) out += m + 'm ';
            out += sec + 's';
            return out;
        }

        // eventos
        startBtn.addEventListener('click', () => {
            if (!startSessionTime) startSession();
        });
        pauseBtn.addEventListener('click', pauseResume);
        skipBtn.addEventListener('click', skipExercise);
        endBtn.addEventListener('click', finishSession);
        exportCSVBtn.addEventListener('click', () => {
            if (history.length === 0) {
                alert('No hay datos para exportar.');
                return;
            }
            let csv = 'Inicio,Fin,Duración (s),Número de ejercicios\n';
            history.forEach(h => {
                csv += `"${h.startStr}","${h.endStr}",${h.durationSecs},${h.count}\n`;
            });
            const blob = new Blob([csv], {
                type: 'text/csv'
            });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'pausas_activas_historial.csv';
            document.body.appendChild(a);
            a.click();
            setTimeout(() => {
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }, 0);
        });
    </script>
</body>

</html>