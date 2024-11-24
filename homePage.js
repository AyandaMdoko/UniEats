  navbar = document.querySelector(' .header .flex .navbar');

document.querySelector('#menu-btn').onclick = () =>{
  navbar.classList.toggle('active');
  profile.classList.remove('active');
}

profile = document.querySelector(' .header .flex .profile');

document.querySelector('#user-btn').onclick = () =>{
  profile.classList.toggle('active');
  navbar.classList.remove('active');
}

window.onscroll = () =>{
  navbar.classList.remove('active');
  profile/classList.remove('active');
}

//loader script
function loader(){
  document.querySelector('.loader').style.display = 'none'
}
// keep in mind 1000 = 1 seconds
// so 2000 = 2 seconds
function fadeOut(){
  setInterval(loader, 2000);
}
window.onload = fadeOut();


// Handle dropdown changes and input restrictions
const dropdown = document.getElementById('myDropdownRegister');
const studentStaffNumberInput = document.getElementById('studentStaffNumber');
const regNumbInput = document.getElementById('regNumber');

dropdown.addEventListener('change', () => {
  if (dropdown.value === 'option4') {
    studentStaffNumberInput.disabled = true;
    studentStaffNumberInput.value = '';
  } else {
    studentStaffNumberInput.disabled = false;
  }
});

function handleNumericInput(event) {
  let inputValue = event.target.value.replace(/[^0-9]/g, '');
  event.target.value = inputValue;
}

studentStaffNumberInput.addEventListener('input', handleNumericInput);
regNumbInput.addEventListener('input', handleNumericInput);

// Validate passwords
const passwordInput = document.getElementById('regPass');
const confirmPasswordInput = document.getElementById('regConfPass');
const passwordError = document.getElementById('passwordError');

function validatePasswords() {
  const password = passwordInput.value;
  const confirmPassword = confirmPasswordInput.value;

  if (password && confirmPassword && password !== confirmPassword) {
    passwordError.textContent = 'Passwords do not match!';
  } else {
    passwordError.textContent = '';
  }
}


passwordInput.addEventListener('input', validatePasswords);
confirmPasswordInput.addEventListener('input', validatePasswords);

      
        const lengthCircle = document.getElementById('length-circle');
        const uppercaseCircle = document.getElementById('uppercase-circle');
        const lowercaseCircle = document.getElementById('lowercase-circle');
        const numberCircle = document.getElementById('number-circle');
        const specialCharCircle = document.getElementById('special-char-circle');

        passwordInput.addEventListener('input', updateCircles);

        function updateCircles() {
            const password = passwordInput.value;
            lengthCircle.classList.toggle('valid', password.length >= 8);
            uppercaseCircle.classList.toggle('valid', /[A-Z]/.test(password));
            lowercaseCircle.classList.toggle('valid', /[a-z]/.test(password));
            numberCircle.classList.toggle('valid', /\d/.test(password));
            specialCharCircle.classList.toggle('valid', /[!@#$%^&*]/.test(password));
        }
