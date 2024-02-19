const comment = document.getElementById("comment");
const commentSection = document.getElementById("commentSection");
const mask = document.getElementById("mask");
const audioSection = document.getElementById("audioSection");
const mediaSection = document.getElementById("mediaSection");
const preview = document.getElementById("preview");
const file_pre = document.getElementsByClassName("preview")[0];
const p_comment = document.getElementById("p_comment");
const p_submit = document.getElementById("p_submit");
const sendMessage = document.getElementById("sendMessage");
const imageVid = document.getElementById("imageVidLabel");
const computer = document.querySelectorAll('.computer');
const mobile = document.querySelectorAll('.mobile');
const files = document.querySelectorAll('input[type="file"]');
const nameTags = document.getElementById('nameTag');
const alert = document.getElementById('alert');


// interface
let file = {
    type: '',
    file: '',
    name: '',
    message: '',
};



const conn = new WebSocket(`ws://${window.location.hostname}:8080`);

conn.onopen = function (e) {
    conn.send(JSON.stringify(
        {
            username: nameTags.textContent.trim(),
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

    if (data.type === 'alert') {
        showAlert(data.user.name + ' ' + data.message);
    } else {
        const div = document.createElement('div');
        const commentDiv = document.createElement('div');
        commentDiv.setAttribute('class', 'comment');
        setProfile(div, data.user.name, data.user.picture);
        if (data.type !== 'text') {
            const fileDiv = document.createElement('div');
            fileDiv.setAttribute('class', 'file');
            let elem;
            if (data.type === 'image') {
                elem = new Image();
                elem.src = data.file;
            } else if (data.type === 'video') {
                elem = document.createElement('video');
                elem.src = data.file;
                elem.controls = true;
            } else if (data.type === 'audio') {
                console.log(data.type);
                elem = document.createElement('audio');
                elem.src = data.file;
                elem.controls = true;
            } else {
                const span = document.createElement('span');
                const image = new Image();
                span.textContent = data.name;
                image.src = 'public/docs.jpg'
                elem = document.createElement('a');
                elem.href = data.file;
                elem.download = data.name;
                elem.appendChild(image);
                elem.appendChild(span);
            }
            fileDiv.appendChild(elem);
            commentDiv.appendChild(fileDiv);
        }

        if (data.message) {
            const textDiv = document.createElement('div');
            textDiv.setAttribute('class', 'text');
            textDiv.textContent = data.message
            commentDiv.appendChild(textDiv);
        }
        div.appendChild(commentDiv);
        commentSection.appendChild(div);
        scrollToBottom();
    }
});

function scrollToBottom() {
    commentSection.scrollTo({
        top: commentSection.scrollHeight,
        behavior: 'smooth'
    });
}

function setProfile(elem, name, picture) {
    const div = document.createElement('div');
    div.setAttribute('class', 'profile');
    const img = document.createElement('img');
    img.src = picture;
    img.alt = name;
    img.title = name;

    const p = document.createElement('p');
    p.textContent = name;

    div.appendChild(img);
    div.appendChild(p);
    elem.appendChild(div);

}
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

function CaptureAudio() {
    // Add functionality for capturing audio
}

function CaptureVideo() {
    // Add functionality for capturing video
}

navigator.mediaDevices.getUserMedia({ video: true })
.then((stream) => {
  const video = document.getElementById('video');
  video.srcObject = stream;
})
.catch((error) => {
  console.error('Error accessing camera:', error);
});

function CapturePics() {

    const video = document.crea('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');

    // Set canvas dimensions to match video
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    // Draw current frame from video onto the canvas
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    // Convert the canvas content to a data URL and display it
    const imageDataURL = canvas.toDataURL('image/png');
    showPhoto(imageDataURL);
}

function VideoOrPics() {
    // Add functionality for selecting video or pictures
}

function sendDocs() {
    // Add functionality for sending documents
}



async function showPreview(data, type) {
    let element;
    url = URL.createObjectURL(data);
    mask.addEventListener('click', remove_file_pre)
    if (type == 'video') {
        element = document.createElement('video');
        element.src = url;
        element.controls = true;

        file_pre.appendChild(element);
        file = { type: 'video', file: await getBlob(data), name: data.name }
    } else if (type == 'image') {
        element = document.createElement('img');
        element.src = url;
        file_pre.appendChild(element);
        file = { type: 'image', file: await getBlob(data), name: data.name }
    } else if (type == 'audio') {
        element = document.createElement('audio');
        element.src = url;
        element.controls = true;
        file_pre.appendChild(element);
        file = { type: 'audio', file: await getBlob(data), name: data.name }
    } else {
        element = document.createElement('img');
        element.src = 'public/docs.jpg';
        file_pre.appendChild(element);
        file = { type: 'file', file: await getBlob(data), name: data.name }
    }
    mask.style.display = 'block';
    preview.style.display = 'flex';
    audioSection.style.display = "none";
    mediaSection.style.display = "none";

    function remove_file_pre() {
        URL.revokeObjectURL(url);
        file_pre.removeChild(element)
        mask.removeEventListener('click', remove_file_pre)
    }
}

function getBlob(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();

        reader.onload = (e) => {
            const result = e.target.result;
            resolve(result);
        };

        reader.onerror = (error) => {
            reject(error);
        };

        reader.readAsDataURL(file);
    });
}


mask.addEventListener('click', () => {
    mask.style.display = 'none';
    mediaSection.style.display = 'none';
    audioSection.style.display = "none";
    preview.style.display = "none";

})

function DisplayCaptureSection() {
    mask.style.display = "block";
    mediaSection.style.display = "flex";
}

function DisplayAudio() {
    mask.style.display = "block";
    audioSection.style.display = "flex";
}


files.forEach((elem) => {
    elem.addEventListener('change', (e) => {
        const data = e.target.files[0];

        if (data) {
            if (data.type.includes('video')) {
                showPreview(data, 'video');
            }
            else if (data.type.includes('image')) {
                showPreview(data, 'image');
            }
            else if (data.type.includes('audio')) {
                showPreview(data, 'audio');
            }
            else {
                showPreview(data, 'file');
            }
        }
    })
})

// send FIles
p_submit.addEventListener('click', () => {
    file['message'] = p_comment.value;
    conn.send(JSON.stringify(file));
    preview.style.display = 'none';
    mask.style.display = 'none';

    p_comment.value = '';

    file_pre.removeChild(file_pre.children[0]);
})

p_comment.addEventListener('keypress', (event) => {
    if (event.key === 'Enter') {
        file['message'] = p_comment.value;
        conn.send(JSON.stringify(file));
        preview.style.display = 'none';
        mask.style.display = 'none';

        p_comment.value = '';
        file_pre.removeChild(file_pre.children[0]);
    }
})

sendMessage.addEventListener('click', (event) => {
    if (comment.value.trim() != "") {
        conn.send(JSON.stringify(
            {
                type: 'text',
                message: comment.value,
            }
        ));
        comment.value = "";
    }
});

comment.addEventListener('keypress', (event) => {
    if (event.key === 'Enter' && comment.value.trim() != "") {
        conn.send(JSON.stringify(
            {
                type: 'text',
                message: comment.value,
            }
        ));
        comment.value = "";
    }
})


if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
    computer.forEach((elem) => {
        elem.style.display = 'none';
    })
    mobile.forEach((elem) => {
        elem.style.display = 'inline';
    })
} else {
    computer.forEach((elem) => {
        elem.style.display = 'inline';
    })
    mobile.forEach((elem) => {
        elem.style.display = 'none';
    })
}