
function deleteLink(id, user_id) {
    console.log(id + ' ' + user_id);

    var xmlhttp = new XMLHttpRequest();   // new HttpRequest instance
    xmlhttp.open("POST", "../ajax.php");
    xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xmlhttp.send(JSON.stringify({user_id: user_id, id_delete : id}));
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            console.log(xmlhttp.responseText );
            window.location.reload();
        }
    };
}

var faceChosen = false;

function activateStartButton() {
    document.getElementById('startbutton').disabled = false;
    document.getElementById('submitFile').disabled = false;
    faceChosen = true;
}

(function() {
    // The width and height of the captured photo. We will set the
    // width to the value defined here, but the height will be
    // calculated based on the aspect ratio of the input stream.

    var width = 320;    // We will scale the photo width to this
    var height = 0;     // This will be computed based on the input stream

    // |streaming| indicates whether or not we're currently streaming
    // video from the camera. Obviously, we start at false.

    var streaming = false;

    // The various HTML elements we need to configure or control. These
    // will be set by the startup() function.

    var video = null;
    var canvas = null;
    var photo = null;
    var photo2 = null;
    var startbutton = null;
    var face = null;
    var deleteButton = null;
    var submitFile = null;
    var photoTitle = null;

    function startup() {
        video = document.getElementById('video');
        canvas = document.getElementById('canvas');
        photo = document.getElementById('photo');
        photo2 = document.getElementById('photo2');
        startbutton = document.getElementById('startbutton');
        startbutton.disabled = true;
        savebutton = document.getElementById('savebutton');
        savebutton.disabled = true;
        deleteButton = document.getElementById('delete');
        submitFile = document.getElementById('submitFile');
        submitFile.disabled = true;
        photoTitle = document.getElementById('photoTitle');


        navigator.getMedia = ( navigator.getUserMedia ||
                              navigator.webkitGetUserMedia ||
                              navigator.mozGetUserMedia ||
                              navigator.msGetUserMedia);

        navigator.getMedia(
            {
                video: true,
                audio: false
            },
            function(stream) {
                if (navigator.mozGetUserMedia) {
                    video.mozSrcObject = stream;
                } else {
                    var vendorURL = window.URL || window.webkitURL;
                    video.src = vendorURL.createObjectURL(stream);
                }
                video.play();
            },
            function(err) {
                console.log("An error occured! " + err);
            }
        );

        photoTitle.addEventListener("input", function(e) {
            if (photoTitle.value.length > 0 && faceChosen && photo2.src != "http://localhost:8080/") {
                savebutton.disabled = false;
                console.log('test2 =' + photo2.src);
            }
            else
                savebutton.disabled = true;
        }, false);

        video.addEventListener('canplay', function(ev){
            if (!streaming) {
                height = video.videoHeight / (video.videoWidth/width);

                // Firefox currently has a bug where the height can't be read from
                // the video, so we will make assumptions if this happens.

                if (isNaN(height)) {
                    height = width / (4/3);
                }

                video.setAttribute('width', width);
                video.setAttribute('height', height);
                canvas.setAttribute('width', width);
                canvas.setAttribute('height', height);
                streaming = true;
            }
        }, false);

        startbutton.addEventListener('click', function(ev){
            for (var i = 1; i <= 6; i++) {
                if (document.getElementById('markStudent' + i).checked === true) {
                    face = i;
                    takepicture();
                    ev.preventDefault();
                    break ;
                }
            }
            if (i === 7)
                alert('please choose a face');
        }, false);

        savebutton.addEventListener('click', function(ev){
            if (document.getElementById('photoTitle').value.length < 1)
                alert('please choose a title');
            else {
                if (photo2.src == "http://localhost:8080/index.php")
                    alert('please take a picture or upload an image');
                else {
                    savepicture();
                }

            }

        }, false);

        submitFile.addEventListener('click', function(ev){
            for (var i = 1; i <= 6; i++) {
                if (document.getElementById('markStudent' + i).checked === true) {
                    face = i;
                    saveUploadedPhoto(ev);
                    break ;
                }
            }
        }, false);

        clearphoto();
    }

    function _(elementID) {
        return document.getElementById(elementID);
    }

    function saveUploadedPhoto(ev) {
        ev.preventDefault();
        var file = _("fileToUpload").files[0];
        var formData = new FormData();
        ev.preventDefault();
        formData.append("photo", file);
        formData.append("face", face);
        var ajax = new XMLHttpRequest();

        ajax.open("POST", "upload.php");

        ajax.send(formData);

        ev.preventDefault();
        ajax.onreadystatechange = function() {
            ev.preventDefault();
            if (ajax.readyState == 4 && ajax.status == 200) {
                console.log(ajax.responseText );
                if (ajax.responseText !== "Please upload a picture")
                    photo2.src = 'http://localhost:8080/' + ajax.responseText + '?' + new Date().getTime();
            }
        };
    }
    // Fill the photo with an indication that none has been
    // captured.

    function clearphoto() {
        var context = canvas.getContext('2d');
        context.fillStyle = "#AAA";
        context.fillRect(0, 0, canvas.width, canvas.height);
        var data = canvas.toDataURL('image/png');
        photo.setAttribute('src', data);
    }

    // Capture a photo by fetching the current contents of the video
    // and drawing it into a canvas, then converting that to a PNG
    // format data URL. By drawing it on an offscreen canvas and then
    // drawing that to the screen, we can change its size and/or apply
    // other changes before drawing it.

    function savepicture() {
        var xmlhttp = new XMLHttpRequest();   // new HttpRequest instance
        xmlhttp.open("POST", "../ajax.php");
        xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
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

        var title = document.getElementById('photoTitle').value;
        xmlhttp.send(JSON.stringify({title: title, date : today}));
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                // photo2.src = 'http://localhost:8080/' + xmlhttp.responseText + '?' + new Date().getTime();
                console.log(xmlhttp.responseText );
                window.location.reload();
            }
        };
    }

    function takepicture() {
        var context = canvas.getContext('2d');
        if (width && height) {
            canvas.width = width;
            canvas.height = height;
            context.drawImage(video, 0, 0, width, height);

            var data = canvas.toDataURL('image/png');
            photo.setAttribute('src', data);
            var xmlhttp = new XMLHttpRequest();   // new HttpRequest instance
            xmlhttp.open("POST", "../ajax.php");
            xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xmlhttp.send(JSON.stringify({url: data, face : face}));
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    photo2.src = 'http://localhost:8080/' + xmlhttp.responseText + '?' + new Date().getTime();
                }
            };
        } else {
            clearphoto();
        }
    }
    // Set up our event listener to run the startup process
    // once loading is complete.
    window.addEventListener('load', startup, false);
})();
