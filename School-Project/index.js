
  const form = document.getElementById("myForm");
  const emailInput = document.getElementById("email");

  form.addEventListener("submit", function(event) {
    if (!emailInput.checkValidity()) {
      alert("Please enter a valid email address.");
      event.preventDefault();
    }
  });


 