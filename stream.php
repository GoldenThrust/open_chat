<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Recorder</title>
    <style>
        #streams {
            display: flex;
            justify-content: space-evenly;
            flex-wrap: wrap;
        }
    </style>
</head>

<body>
    <?php var_dump($_SERVER) ?>
    <video id="video" autoplay></video>
    <div id="streams"></div>
    <script>
        let conn = new WebSocket(`ws://${window.location.hostname}:8080`);
        const streams = document.getElementById('streams');
        const streamObj = {};

        function blobToArrayBuffer(blob) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = () => resolve(reader.result);
                reader.onerror = reject;
                reader.readAsArrayBuffer(blob);
            });
        }

        const video = document.getElementById('video');


        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then((stream) => {
                video.srcObject = stream
                // Create a MediaRecorder
                const mediaRecorder = new MediaRecorder(stream);

                // Create an array to store chunks of data
                const chunks = [];

                // Event handler when data is available
                mediaRecorder.ondataavailable = (event) => {
                    if (event.data.size > 0) {
                        chunks.push(event.data);
                    }
                };

                // Event handler when recording stops
                mediaRecorder.onstop = () => {
                    // Combine the chunks into a single Blob
                    const blob = new Blob(chunks, {
                        type: 'video/webm'
                    });

                    // Convert the Blob to a base64-encoded string
                    const reader = new FileReader();
                    reader.onloadend = () => {
                        const base64Data = reader.result.split(',')[1];

                        const data = {
                            type: 'stream',
                            data: base64Data
                        };

                        conn.send(JSON.stringify(data));
                    };
                    reader.readAsDataURL(blob);
                };

                // Start recording
                mediaRecorder.start();

                // Stop recording after 5 seconds (for example)
                setTimeout(() => {
                    mediaRecorder.stop();
                }, 5000);
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

            console.log(data);

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

        function base64ToBlob(base64Data) {
            const byteString = atob(base64Data);
            const buffer = new ArrayBuffer(byteString.length);
            const uint8Array = new Uint8Array(buffer);

            for (let i = 0; i < byteString.length; i++) {
                uint8Array[i] = byteString.charCodeAt(i);
            }

            // Create a Blob using the ArrayBuffer
            return new Blob([buffer], {
                type: 'video/webm'
            }); // Adjust the MIME type accordingly
        }
    </script>
</body>

</html>