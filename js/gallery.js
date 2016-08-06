/**
 * Created by Fernan on 06/06/2016.
 */

// Get the modal


// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];


if (window.location.href.split("#").length > 1) {
    var viewValue = window.location.href.split("#")[1];
    if (viewValue.split("=")[1].length > 0) {
        var xmlhttp = new XMLHttpRequest();   // new HttpRequest instance
        xmlhttp.open("POST", "../ajax.php");
        xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xmlhttp.send(JSON.stringify({modal_id: viewValue.split("=")[1]}));
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var resp = xmlhttp.responseText.split(",");
                var likesModal = [];
                if (resp[5] !== '') {
                    resp[5].split(";").forEach(function(element) {
                        likesModal.push(element);
                    });
                }
                openModal(resp[0], resp[1], resp[2], resp[3], resp[4], likesModal);
            }
        };
    }
}

function mouseEnter(index) {
    var imageTitle = document.getElementById("image-title"+index);
    imageTitle.style.opacity = 0;
}

function mouseLeave(index) {
    var imageTitle = document.getElementById("image-title"+index);
    imageTitle.style.opacity = 1;
}

function unlike(user, id) {
    var xmlhttp = new XMLHttpRequest();   // new HttpRequest instance
    xmlhttp.open("POST", "../ajax.php");
    xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xmlhttp.send(JSON.stringify({username: user, picture_to_unlike : id}));
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            window.location = window.location.href.split("#")[0] + "#view=" + id;
            window.location.reload();
        }
    };
}

function like(user, id) {
    var xmlhttp = new XMLHttpRequest();   // new HttpRequest instance
    xmlhttp.open("POST", "../ajax.php");
    xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xmlhttp.send(JSON.stringify({username: user, picture_to_like : id}));
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            window.location = window.location.href.split("#")[0] + "#view=" + id;
            window.location.reload();
        }
    };
}

function openModal(user, title, date, owner, id, likes) {
    // console.log(user + ' ' + title + ' ' + date + ' ' + owner + ' ' + id);
    window.location = window.location.href.split("#")[0] + "#view=" + id;
    var modal = document.getElementById('myModal');
    modal.style.display = "block";
    var modalTitle = document.getElementById('modal-title');
    modalTitle.innerHTML = title;
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
            text += likes[i];
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
}