// Password validation function
function validatePassword(password) {
  const minLength = 8;
  const hasUpperCase = /[A-Z]/.test(password);
  const hasLowerCase = /[a-z]/.test(password);
  const hasNumber = /\d/.test(password);
  const hasSpecialChar = /[!@#$%^&*]/.test(password);

  return password.length >= minLength && hasUpperCase && hasLowerCase && hasNumber && hasSpecialChar;
}

// Update circles function
function updateCircles(password) {
  const lengthCircle = document.getElementById('length-circle');
  const uppercaseCircle = document.getElementById('uppercase-circle');
  const lowercaseCircle = document.getElementById('lowercase-circle');
  const numberCircle = document.getElementById('number-circle');
  const specialCharCircle = document.getElementById('special-char-circle');

  lengthCircle.classList.toggle('valid', password.length >= 8);
  uppercaseCircle.classList.toggle('valid', /[A-Z]/.test(password));
  lowercaseCircle.classList.toggle('valid', /[a-z]/.test(password));
  numberCircle.classList.toggle('valid', /\d/.test(password));
  specialCharCircle.classList.toggle('valid', /[!@#$%^&*]/.test(password));
}

// Form validation function
function validateForm(event) {
  event.preventDefault();
  const password = document.getElementById('regPass').value;
  const confirmPassword = document.getElementById('regConfPass').value;
  const passwordError = document.getElementById('passwordError');

  if (!validatePassword(password)) {
      passwordError.textContent = 'Password does not meet all requirements.';
      return false;
  }

  if (password !== confirmPassword) {
      passwordError.textContent = 'Passwords do not match.';
      return false;
  }

  passwordError.textContent = '';
  event.target.submit();
}

// Add event listener to password input
document.getElementById('regPass').addEventListener('input', function() {
  updateCircles(this.value);
});

// Add event listener to form submission
document.getElementById('registerForm').addEventListener('submit', validateForm);
