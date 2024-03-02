<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Recorder</title>
    <style>
        video {
            width: 100%;
            max-width: 640px;
        }
        
        canvas {
            display: none;
        }
        </style>
</head>

<body>
    <video id="video" autoplay></video>
    <script>
        let conn = new WebSocket(`ws://${window.location.hostname}:8080`);
        const video = document.getElementById('video');
        let cur_stream = 0;

        function showAlert(msg) {
            const div = document.createElement('div');
            div.textContent = msg;
            alert.appendChild(div);

            div.style.right = '0px';

            setTimeout(() => {
                div.style.right = '-500px';
            }, 3000);

            setTimeout(() => {
                alert.removeChild(div);
            }, 4000);
        }


        navigator.mediaDevices.getUserMedia({ video: true, audio: true })
            .then((stream) => {
                video.srcObject = stream
                conn.send(stream);
            })
            .catch((error) => {
                console.error('Error accessing camera:', error);
            });



        conn.onopen = function (e) {
            conn.send(JSON.stringify(
                {
                    type: 'alert',
                    message: 'Connected successfully',
                }
            ));
        };

        conn.onclose = function () {
            conn.send(JSON.stringify(
                {
                    type: 'alert',
                    message: 'Disconnected',
                }
            ));
        };

        conn.addEventListener('message', (event) => {
            const data = JSON.parse(event.data);
            if (data.length > cur_stream) {
                
            } else if (data.length < cur_stream) {

            }

            for (const key in data) {
                if (data.type === 'alert') {
                    console.log(data.message);
                } else {
                    data.data
                }
            }
        });




    </script>
</body>

</html>