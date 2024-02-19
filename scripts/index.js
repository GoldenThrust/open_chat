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


let file = {
    type: '',
    file: '',
    name: '',
    message: '',
};



var conn = new WebSocket(`ws://${window.location.hostname}:8080`);

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
        if (data.type == 'file') {
            const fileDiv = document.createElement('div');
            fileDiv.setAttribute('class', 'file');
            const a = document.createElement('a');
            const span = document.createElement('span');
            const image = new Image();
            span.textContent = data.name;
            image.src = 'public/docs.jpg'
            a.href = data.file;
            a.download = data.name;
            a.appendChild(image);
            a.appendChild(span);
            fileDiv.appendChild(a);
            commentDiv.appendChild(fileDiv);
        }

        const textDiv = document.createElement('div');
        textDiv.setAttribute('class', 'text');
        textDiv.textContent = data.message
        commentDiv.appendChild(textDiv);
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

function CapturePics() {
    // Add functionality for capturing pictures
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

p_comment.addEventListener('keypress', (event) => {
    if (event.key === 'Enter') {
        file['message'] = p_comment.value;
        conn.send(JSON.stringify(file));
        preview.style.display = 'none';
        mask.style.display = 'none';

        p_comment.value = '';
        console.log(file_pre.firstChild)
        file_pre.removeChild(file_pre.children[0]);
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