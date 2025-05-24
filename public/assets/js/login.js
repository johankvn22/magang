document.addEventListener("DOMContentLoaded", function () {
  const passwordInput = document.getElementById("password");
  const showPasswordCheckbox = document.getElementById("showPassword");

  if (showPasswordCheckbox) {
    showPasswordCheckbox.addEventListener("change", function () {
      passwordInput.type = this.checked ? "text" : "password";
    });
  }
});
