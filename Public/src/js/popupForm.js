window.onclick = function(event) {
    if (event.target == document.getElementById('modal-wrapper1') || event.target == document.getElementById('modal-wrapper')) {
        document.getElementById('modal-wrapper').style.display = "none";
    }
};

var popForm = Object.create(Formulaire);
//BUTTON
document.getElementById('formButton').addEventListener('click', popForm.registerButton);
// IMAGE
document.getElementById('imgContain').addEventListener('click', popForm.imgContain);

var verifData = Object.create(VerifData);
document.getElementById('email').addEventListener('blur', verifData.verifEmail);
document.getElementById('password').addEventListener('input', verifData.verifPassword);
document.getElementById("idForm").addEventListener("submit", verifData.verifFinal);