<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        canvas {
            display: block;
            position: relative;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
    <canvas></canvas>
    <script>
        const conn = new WebSocket(`ws://${window.location.hostname}:8081`);
        const canvas = document.querySelector('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;


        function mouseMove(event) {
            const data = {x: event.clientX, y: event.clientY};
            conn.send(JSON.stringify(data));
        }

        function touchmove(event) {
            const data = {x: event.changedTouches[0].clientX, y: event.changedTouches[0].clientY};
            conn.send(JSON.stringify(data));
        }

        conn.addEventListener('message', (event) => {
            const data = JSON.parse(event.data);
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            for (const key in data) {
                ctx.fillStyle = data[key].color;
                ctx.beginPath();
                ctx.arc(data[key].x, data[key].y, 10, 0, Math.PI * 2);
                ctx.fill();
            }
        });

        window.addEventListener('mousemove', mouseMove);
        window.addEventListener('touchmove', touchmove);
    </script>
</body>
</html>