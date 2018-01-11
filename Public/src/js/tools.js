
var Formulaire = {
    registerButton : function () {
        document.getElementById('modal-wrapper').style.display = "block";
    },
    connectButton : function () {
        document.getElementById('modal-wrapper1').style.display = "block";
    },
    imgContain : function () {
        document.getElementById('modal-wrapper').style.display = "none";
    },
    imgContain1 : function () {
        document.getElementById('modal-wrapper1').style.display = "none";
    }
};

var VerifData = {
    verifFinal : function (event) {
        if (document.getElementById("infoEmail").textContent === 'Adresse invalide'){
            event.preventDefault();
        }
        if (event.target.passwordConf.value === event.target.password.value){
            if(document.getElementById("infoInput").textContent === '(Longueur: faible)'){
                event.preventDefault();
            }else if(document.getElementById("infoInput").textContent === '(Longueur: moyenne)'){
                event.preventDefault();
            }else if(document.getElementById("infoInput").textContent === '(Longueur: suffisante)'){
                console.log("salut");
            }
        }else {
            document.getElementById("infoInput").textContent = "Mots de passe non similaire";
            event.preventDefault();
        }
    },
    verifPassword : function (event) {
        var password = event.target.value;
        if (password.length >= 8) {
            passwordLenght = "suffisante";
            colorMsg = "green";
            dataForVerifFinal = true
        }else if (password.length >= 4) {
            passwordLenght = "moyenne";
            colorMsg = "orange";
            dataForVerifFinal = false;
        }else if (password.length < 4) {
            passwordLenght = "faible";
            colorMsg = "red";
            dataForVerifFinal = false;
        }
        document.getElementById("infoInput").textContent = "(" + "Longueur: " + passwordLenght + ")";
        document.getElementById("infoInput").style.color = colorMsg;
        return dataForVerifFinal;
    },
    verifEmail : function (e) {
        // Correspond à une chaîne de la forme xxx@yyy.zzz
        var regexCourriel = /.+@.+\..+/;
        var validiteCourriel = "";
        if (!regexCourriel.test(e.target.value)) {
            validiteCourriel = "Adresse invalide";
        }
        document.getElementById("infoEmail").textContent = validiteCourriel;
        document.getElementById("infoEmail").style.color = "red";

    }
};

var images = [
    "/projet5/Public/src/images/imgjdr/arbre1.jpg",
    "/projet5/Public/src/images/imgjdr/cite.jpg",
    "/projet5/Public/src/images/imgjdr/cite3.jpg",
    "/projet5/Public/src/images/imgjdr/cite4.jpg",
    "/projet5/Public/src/images/imgjdr/volcan.jpg",
    "/projet5/Public/src/images/imgjdr/balrog.jpg"
];

var num = 0;
var Slider = {
    move :function () {
        num++;
        if ( num >= images.length ) {
            num = 0;
        }
        document.getElementById("homePage").style.backgroundImage = "url('"+images[num]+"')";
        document.getElementById("homePage").style.transitionDuration = "5s";
    }
};

var TextEditor = {
    parameter : {
        selector : "textarea",
        theme: "modern",
        height: 200,
        width: "100%",
        plugins: [  "advlist autolink link image lists charmap print preview hr anchor pagebreak" +
        " searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking table contextmenu" +
        " contextmenu directionality emoticons paste textcolor responsivefilemanager code"],
        toolbar1: " formatselect | undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist" +
        " numlist outdent indent |responsivefilemanager | link unlink anchor | image media | forcolor backcolor |" +
        "preview code | caption",
        menubar: false,
        image_caption: true,
        image_advtab: true,
        external_filemanager_path: "/projet5/Public/src/filemanager/",
        filemanager_title: "Gallerie d'image",
        external_plugins: { "filemanager":"/projet5/Public/src/filemanager/plugin.min.js" },
        visualblocks_default_state: true,
        style_formats_autohide: true,
        style_formats_merge: true
    },
    loadTextEditor : function () {
        tinymce.init(TextEditor.parameter);
    }
};

var Scroll = {
    appear : function () {
        if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
            document.getElementById("rolTop").style.display = "block";
        } else {
            document.getElementById("rolTop").style.display = "none";
        }
    },
    parameter : {
        block: "start",
        behavior: "smooth"
    },
    smooth : function () {
        document.getElementById("main").scrollIntoView(Scroll.parameter);
    }

};