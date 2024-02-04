const key = 'ExistingPage'
const expirationTime = 5 * 60 * 1000;

// function openPage(pageId) {
//   // Check if the pageId is 'makeInvoice'
//   if (pageId === 'makeInvoice') {
//     // Redirect to the Invoice.html page
//     window.location.href = '/invoice';
//     return;
//   }

//   // Hide all pages
//   const pages = document.querySelectorAll('.page-content div');
//   pages.forEach(page => {
//     page.style.display = 'none';
//     document.querySelector('.menu-bar').classList.remove('show')
//   });

//   // Show the selected page
//   const selectedPage = document.getElementById(pageId);
//   if (selectedPage) {
//     selectedPage.style.display = 'block';
//   }
// }

function toggleInvoiceDetails(num) {
  var customerDetails = document.getElementById(`customerDetails${num}`);

  customerDetails.classList.toggle('showY')
}

function logOut() {
  removeOpenedPage();
  // Redirect to the login page or perform other actions as needed
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

const cachedData = JSON.parse(localStorage.getItem(key));

if (cachedData && new Date().getTime() - cachedData.timestamp < expirationTime) {
  // Data is still within the expiration time, use it
  openPage(cachedData.value);
} else {
  // Data has expired or doesn't exist
  openPage('welcome');
}

function removeOpenedPage() {
  localStorage.removeItem(key);
}