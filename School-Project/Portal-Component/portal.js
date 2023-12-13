function togglePassword() {
    var passwordInput = document.getElementById("password");
    var toggleIcon = document.getElementById("toggleIcon");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    } else {
        passwordInput.type = "password";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    }
}

document.getElementById('role').addEventListener('change', function() {
    var studentIdInput = document.getElementById('student_id');
    var adminIdInput = document.getElementById('admin_id');

    if (this.value === 'student') {
        studentIdInput.style.display = 'block';
        adminIdInput.style.display = 'none';
    } else {
        studentIdInput.style.display = 'none';
        adminIdInput.style.display = 'block';
    }
});

