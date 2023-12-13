form.addEventListener("submit", function(event) {
  if (!emailInput.checkValidity()) {
    alert("Please enter a valid email address.");
    event.preventDefault();
  }
});