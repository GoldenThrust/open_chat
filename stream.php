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
    <?php var_dump($_SERVER) ?>
    <video id="video" autoplay></video>
    <div id="streams"></div>
    <script>
        const video = document.getElementById('video');
        const 

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
                conn.send(stream);
            })
            .catch((error) => {
                console.error('Error accessing webcam:', error);
            });

        // navigator.mediaDevices.getUserMedia({
        //         video: true,
        //         audio: true
        //     })
        //     .then((stream) => {
        //         video.srcObject = stream;
        //         console.log(stream)

        //         const data = {
        //             type: 'stream',
        //             data: res
        //         };

        //         conn.send(JSON.stringify(data));
        //     })
        //     .catch((error) => {
        //         console.error('Error accessing camera:', error);
        //     });

        conn.onopen = function(e) {
            conn.send(JSON.stringify({
                type: 'opened',
                data: 'Connected successfully',
            }));
        };

        conn.onclose = function(event) {
            console.log('WebSocket closed:', event.reason);
        };

        conn.onerror = function(error) {
            console.error('WebSocket Error:', error);
        };

        conn.addEventListener('message', (event) => {
            const data = JSON.parse(event.data);

            for (const key in data) {
                if (data[key].type === 'opened') {
                    streamObj[data[key].id] = document.createElement('video');
                    streamObj[data[key].id].setAttribute('data-id', data[key].id);
                    streamObj[data[key].id].setAttribute('autoplay', true);
                    streamObj[data[key].id].setAttribute('controls', true);
                    streams.appendChild(streamObj[data[key].id]);
                    console.log(data[key].data);
                } else if (data[key].type === 'closed') {
                    streams.removeChild(streamObj[data[key].id]);
                } else if (data[key].type === 'stream') {
                    const blobUrl = URL.createObjectURL(data[key].data);
                    streamObj[data[key].id].src = base64ToBlob(blobUrl);
                    console.log(streamObj)
                }
            }
        });




        let conn = new WebSocket(`ws://${window.location.hostname}:8080`);
    </script>
</body>

</html>