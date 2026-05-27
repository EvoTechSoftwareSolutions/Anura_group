function send() {

    // Button as reference to disable and change text
    var btn = document.getElementById("sub_btn");
    
    // Button disable put text "Sending..."
    btn.disabled = true;
    btn.classList.add("disable");
    btn.innerHTML = "Sending...";

    var f = new FormData();
    f.append("name", document.getElementById("name").value);
    f.append("email", document.getElementById("email").value);
    f.append("phone", document.getElementById("phone").value);
    f.append("message", document.getElementById("message").value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            if (r.responseText == "Message Sent successfully") {
                document.getElementById("name").value = "";
                document.getElementById("email").value = "";
                document.getElementById("phone").value = "";
                document.getElementById("message").value = "";
                Swal.fire({
                    title: 'Message sent',
                    text: "We'll get back to you soon",
                    icon: 'success',
                    confirmButtonText: 'OK',
                    background: '#1a1a1a',
                    color: '#fff',
                    confirmButtonColor: '#0066b3'
                });

            } else {
                Swal.fire({
                    title: 'Try Again',
                    text: r.responseText,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    background: '#1a1a1a',
                    color: '#fff',
                    confirmButtonColor: '#0066b3'
                });
            }

            // Back to enable and original text
            btn.disabled = false;
            btn.classList.remove("disable");
            btn.innerHTML = "Send Message";
        }
    }

    r.open("POST", "mail/sendEmailProcess.php", true);
    r.send(f);
}