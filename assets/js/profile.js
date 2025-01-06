// document DomLoaded
document.addEventListener('DOMContentLoaded', function() {

    // if id upload_profile changes update the image

    document.getElementById('upload_profile').addEventListener('change', function() {
        var file = this.files[0];
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profile-picture').src = e.target.result;
        };
        reader.readAsDataURL(file);

        document.getElementById('profile-image-submit-button').disabled = false;
    });
});