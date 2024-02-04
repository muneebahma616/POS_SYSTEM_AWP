// const adminBtn = document.querySelector('.admin-btn');

// adminBtn.addEventListener('click', function () {
//   // Show a password entry screen when the "Admin Panel" button is clicked
//   const passwordEntry = prompt('Enter admin password:');
//   // You can replace the following password check with your own validation logic
//   if (passwordEntry === '') {
//     window.location.href = '/admin';
//   } else {
//     alert('Invalid admin password');
//   }
// });

const authentication = (ev) => {
  ev.preventDefault();
  const usernameInput = document.getElementById('username');
  const passwordInput = document.getElementById('password');

  const username = usernameInput.value;
  const password = passwordInput.value;

  // if (username === 'admin') {
  //   adminAuthentication(ev)
  //   return;
  // }

  if (username === 'employee' && password === '123') {
    window.location.href = 'EmployeeScreen.html';
  } else {
    alert('Invalid username or password');
  }
};
const adminAuthentication = (ev) => {
  ev.preventDefault();
  const usernameInput = document.getElementById('username');
  const passwordInput = document.getElementById('password');

  const username = usernameInput.value;
  const password = passwordInput.value;

  if (username === 'admin' && password === '123456789') {
    window.location.href = 'AdminPanel.html';
  } else {
    alert('Invalid username or password');
  }
};

