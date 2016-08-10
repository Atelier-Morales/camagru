/**
 * Created by Fernan on 06/06/2016.
 */

// Get the modal


// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

function sendAjaxToOpenModal(id) {
    var xmlhttp = new XMLHttpRequest();   // new HttpRequest instance
    xmlhttp.open("POST", "../camagru/ajax.php");
    xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xmlhttp.send(JSON.stringify({modal_id: id}));
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var resp = JSON.parse(xmlhttp.responseText);
            openModal(resp[0], resp[1], resp[2], resp[3], resp[4], resp[5], resp[6]);
        }
    };
}

if (window.location.href.split("#").length > 1) {
    var viewValue = window.location.href.split("#")[1];
    if (viewValue.split("=")[1].length > 0) {
        sendAjaxToOpenModal(viewValue.split("=")[1]);
    }
}

function escapeHtml(text) {
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };

    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

function getCurrentDate() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    var HH = today.getHours();
    var MM = today.getMinutes();
    var SS = today.getSeconds();

    if(dd<10) {
        dd='0'+dd
    }

    if(mm<10) {
        mm='0'+mm
    }

    if(HH<10) {
        HH='0'+HH
    }

    if(MM<10) {
        MM='0'+MM
    }

    if(SS<10) {
        SS='0'+SS
    }

    today = yyyy + '-' + mm + '-' + dd + ' ' + HH + ':' + MM + ':' + SS;

    return (today);
}

function mouseEnter(index) {
    var imageTitle = document.getElementById("image-title"+index);
    imageTitle.style.opacity = 0;
}

function mouseLeave(index) {
    var imageTitle = document.getElementById("image-title"+index);
    imageTitle.style.opacity = 1;
}

function sendRequest(body, id) {
    var xmlhttp = new XMLHttpRequest();   // new HttpRequest instance
    xmlhttp.open("POST", "../camagru/ajax.php");
    xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xmlhttp.send(JSON.stringify(body));
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            window.location = window.location.href.split("#")[0] + "#view=" + id;
            window.location.reload();
        }
    };
}

function unlike(user, id) {
    var body = {};
    body.username = user;
    body.picture_to_unlike = id;
    sendRequest(body, id);
}

function like(user, id) {
    var body = {};
    body.username = user;
    body.picture_to_like = id;
    sendRequest(body, id);
}

function publishComment(user, id, owner, commentText, title, date) {
    var body = {};
    body.user = user;
    body.picture_id = id;
    body.comment = commentText;
    body.owner = owner;
    body.title = title;
    body.date = date;
    sendRequest(body, id)
}

function openModal(user, title, date, owner, id, likes, comments) {
    window.location = window.location.href.split("#")[0] + "#view=" + id;

    var imageView = document.getElementById("imageView");
    imageView.src = document.getElementById(id).src;
    var likesList = document.getElementById('likes');
    var likeButton = document.getElementById('like-button');

    if (likes.length < 1) {
        likesList.innerHTML = "No likes";
        while (likeButton .hasChildNodes()) {
            likeButton.removeChild(likeButton .lastChild);
        }
        var link = document.createElement('button');
        link.innerHTML = 'like';
        link.onclick = function(event) {
            like(user, id);
        };
        likeButton.appendChild(link);
    }
    else {
        var text = "Liked by ";
        var found = false;
        for (var i = 0; i < likes.length; i++) {
            if (likes[i] === user)
                found = true;
            text += escapeHtml(likes[i]);
            if (i + 1 !== likes.length)
                text += ', ';
        }
        likesList.innerHTML = text;
        while (likeButton .hasChildNodes()) {
            likeButton.removeChild(likeButton .lastChild);
        }
        var link = document.createElement('button');
        if (found === true) {
            link.innerHTML = 'unlike';
            link.onclick = function(event) {
                unlike(user, id);
            };
        }
        else {
            link.innerHTML = 'like';
            link.onclick = function(event) {
                like(user, id);
            };
        }
        likeButton.appendChild(link);
    }
    var publishButton = document.getElementById('publish-button');
    while (publishButton.hasChildNodes()) {
        publishButton.removeChild(publishButton .lastChild);
    }
    var pub = document.createElement('button');
    pub.innerHTML = 'Publish';
    pub.onclick = function(event) {
        publishComment(user, id, owner, document.getElementById('comment').value, title, getCurrentDate());
    };
    publishButton.appendChild(pub);
    var commentSection = document.getElementById('comment-section');
    while (commentSection.hasChildNodes()) {
        commentSection.removeChild(commentSection .lastChild);
    }
    for (var i = 0; i < comments.length; i++) {
        var texto = document.createElement('p');
        var name = document.createElement('h4');
        name.innerHTML = escapeHtml(comments[i][0]);
        var date = document.createElement('small');
        date.innerHTML = ' - ' + comments[i][2];
        name.appendChild(date);
        texto.appendChild(name);
        var content = document.createElement('blockquote');
        content.innerHTML = escapeHtml(comments[i][1]);
        commentSection.appendChild(texto);
        commentSection.appendChild(content);
    }
    var modal = document.getElementById('myModal');
    modal.style.display = "block";
    var modalTitle = document.getElementById('modal-title');
    modalTitle.innerHTML = escapeHtml(title);
}

function closeModal() {
    window.location = window.location.href.split("#")[0] + "#view=";
    var modal = document.getElementById('myModal');
    imageView.src = "";
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    var modal = document.getElementById('myModal');
    if (event.target == modal) {
        window.location = window.location.href.split("#")[0] + "#view=";
        modal.style.display = "none";
    }
};