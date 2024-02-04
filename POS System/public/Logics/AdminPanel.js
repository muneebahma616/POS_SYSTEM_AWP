// function showDropdown() {
//   var dropdown = document.getElementById('dropdown');
//   dropdown.classList.add('show-dropdown');
// }
// function hideDropdown() {
//   var dropdown = document.getElementById('dropdown');
//   dropdown.classList.remove('show-dropdown');
// }
function getBaseURL() {
  return window.location.protocol + "//" + window.location.hostname + (window.location.port ? ":" + window.location.port : "");
}



function openDeleteModal(button) {
  // Get the employee ID from the data-employee-id attribute
  var employeeId = $(button).attr('data-employee-id');

  // Set the employee ID in the modal content or perform deletion logic
  $('#modalContent').text('Are you sure to delete the record with ID: ' + employeeId);

  // Open the modal
  $('#exampleModal2').modal('show');
  // Example usage:
  var currentURL = getBaseURL();
  console.log("Current URL:", currentURL);
  fetch(currentURL + "/delete/" + employeeId)
}

const key = 'ExistingPage'
const expirationTime = 5 * 60 * 1000;

function employeePayment(num) {
  var pay = document.getElementById(`employeePayment${num}`);
  pay.classList.remove('unpaid');

  pay.classList.add('paid');
  pay.setAttribute('disabled', true)
}

function togglePasswordView() {
  var password = document.getElementById('password');
  password.setAttribute('type', password.type === 'text' ? 'password' : 'text');

  var eyeOn = document.getElementById('eye-on');
  var eyeOff = document.getElementById('eye-off');

  if (password.type === 'text') {
    eyeOn.style.display = 'none';
    eyeOff.style.display = 'inline-block';
  } else {
    eyeOn.style.display = 'inline-block';
    eyeOff.style.display = 'none';
  }
}

function toggleRotate(num) {
  var dropdown = document.getElementById(`dropdown-icon${num}`);
  dropdown.classList.toggle('rotate');
}

function openPage(pageId) {
  // Save to localStorage
  const dataToCache = {
    value: pageId,
    timestamp: new Date().getTime(),
  };
  localStorage.setItem(key, JSON.stringify(dataToCache));
  // localStorage.setItem('openedPage', pageId);

  // Hide all content sections
  const contentSections = document.querySelectorAll('.content-section');
  contentSections.forEach(section => {
    section.style.display = 'none';
  });

  // Show the selected content section
  const selectedSection = document.getElementById(pageId);
  if (selectedSection) {
    selectedSection.style.display = 'block';
    document.querySelector('.menu-bar').classList.remove('show')
  }
}

function toggleInvoiceDetails(num) {
  var customerDetails = document.getElementById(`customerDetails${num}`);

  customerDetails.classList.toggle('showY')
}

function removeOpenedPage() {
  localStorage.removeItem(key);
}

function logOut() {
  // Redirect to the login page or perform other actions as needed
  removeOpenedPage()
  window.location.href = '/';
}

function toggleHide() {
  var hiddens = document.querySelectorAll('.hide');
  hiddens.forEach(hidden => {
    hidden.classList.toggle('showY')
  });
}

function printTable(id) {
  toggleHide()
  var table = document.getElementById(id);
  table.style.overflowX = 'visible'
  let cloned = table.cloneNode(true);
  document.body.appendChild(cloned);
  cloned.classList.add("printable");
  window.print();
  document.body.removeChild(cloned);
  toggleHide()
  table.style.overflowX = 'scroll'
}

// function setEditIndex(index) {
//   var xhttp = new XMLHttpRequest();

//   xhttp.onreadystatechange = function () {
//     if (this.readyState == 4 && this.status == 200) {
//       var data = JSON.parse(this.responseText);

//       document.getElementById('ed-id').value = data.id;
//       document.getElementById('ed-name').value = data.name;
//       document.getElementById('ed-password').value = data.password;
//       document.getElementById('ed-salary').value = data.salary;
//       document.getElementById('ed-salary-paid-date').value = data.salarypaiddate;
//       document.getElementById('ed-created-at').value = data.created_at;
//       document.getElementById('ed-updated-at').value = data.updated_at;
//     }
//   };

//   xhttp.open("GET", "get_salesman_data.php?index=" + index, true);
//   xhttp.send();
// }


// function printTable(id) {
//   var table = document.getElementById(id);
//   // Create a new window or iframe
//   var printWindow = window.open('', '_blank');

//   // Write the HTML content of the table to the new window or iframe
//   printWindow.document.write('<html><head><link rel="stylesheet" href="./Styles/AdminPanel.css"><title>Print</title></head><body>');
//   printWindow.document.write('<style>table { border-collapse: collapse; } table, th, td { border: 1px solid black; }</style>');
//   printWindow.document.write(table.outerHTML);
//   printWindow.document.write('</body></html>');

//   // Close the document stream to finish writing the document
//   printWindow.document.close();

//   // Call the print method
//   printWindow.print();
// }


// Retrieve from localStorage
// const cachedValue = localStorage.getItem('openedPage');
// if (cachedValue)
//   openPage(cachedValue);
// else
//   openPage('welcome');

const cachedData = JSON.parse(localStorage.getItem(key));

if (cachedData && new Date().getTime() - cachedData.timestamp < expirationTime) {
  // Data is still within the expiration time, use it
  openPage(cachedData.value);
} else {
  // Data has expired or doesn't exist
  openPage('welcome');
}