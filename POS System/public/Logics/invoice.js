// document.getElementById('form').addEventListener('submit', function (event) {
//   event.preventDefault();
// });

function empty() {
  location.reload();
}

function onlyNumberInput(val, id, storedGrams = 0) {
  // return event.charCode >= 48 && event.charCode <= 57
  purity = document.getElementById('purity').value;
  const convertedGrams = (21 / purity) * parseFloat(storedGrams);

  if (val.slice(0, val.length - 1).includes('.') && val[val.length - 1] === '.') {
    document.getElementById(id).value = val.slice(0, val.length - 1);
  }

  if (id === 'totalGrams' && parseFloat(val) > convertedGrams.toFixed(2)) {
    document.getElementById(id).value = convertedGrams.toFixed(2);
    return;
  }
  // if (val.length > (id == 'customerNo' ? 11 : 9)) {
  //   document.getElementById(id).value = val.slice(0, val.length - 1);
  //   return
  // }
  // if (id !== 'customerNo' && val[0] == '.') {
  //   document.getElementById(id).value = val.slice(0, val.length - 1);
  //   return
  // }
  // if (val[val.length - 1] === '.' && id !== 'customerNo') {
  //   return;
  // }
  // if (isNaN(val[val.length - 1]) || val[val.length - 1] === ' ') {
  //   document.getElementById(id).value = val.slice(0, val.length - 1);
  //   return;
  // }
}

function toggleShow() {
  document.getElementById('offcanvasBill').classList.toggle("show");
}

var count = 0;
function addbtn() {
  // const descInput = document.getElementById('desc');
  const purityInput = document.getElementById('purity');
  const priceInput = document.getElementById('price');
  const totalGramsInput = document.getElementById('totalGrams');
  // const labourCostPerGramInput = document.getElementById('labourCostPerGram');

  // const desc = descInput.value;
  const purity = parseInt(purityInput.value);
  const price = parseInt(priceInput.value);
  const totalGrams = parseInt(totalGramsInput.value);
  // const labourCostPerGram = parseInt(labourCostPerGramInput.value);

  const totalPrice = (price * totalGrams);
  const convertedGrams = parseFloat((purity * totalGrams / 21).toFixed(2));

  if (purity === 0) {
    alert("Please select purity");
    return;
  }

  if (isNaN(totalPrice)) {
    alert("Invalid Input");
    return;
  }

  const tableBody = document.getElementById('tabbody');
  const newRow = createTableRow(count, convertedGrams, price, totalGrams, purity, totalPrice);
  tableBody.innerHTML += newRow;

  document.getElementById('tabbody2').innerHTML += `
  <tr id="item${count}">
      <td><span>${purity}</span></td>
      <td>${price}</td>
      <td>${totalGrams}</td>
      <td>${convertedGrams}</td>
      <td id="price17">${totalPrice}</td>
  </tr>`;

  // descInput.value = '';
  priceInput.value = '';
  purityInput.value = 0;
  totalGramsInput.value = '';
  // labourCostPerGramInput.value = '';
  count++;
  plusplus();

  // document.getElementById('descriptionLabel').classList.remove('up')
  document.getElementById('priceLabel').classList.remove('up')
  document.getElementById('totalGramsLabel').classList.remove('up')
  // document.getElementById('labourCostPerGramLabel').classList.remove('up')
  document.getElementById('purityLabel').classList.remove('up')
}

function createTableRow(count, convertedGrams, price, totalGrams, purity, totalPrice) {
  return `
    <tr id="removenew${count}">
      <td align="center" style="padding-left:20px;">${purity}</td>
      <td align="center">
        <span id="counterValue17">${totalGrams}</span>
      </td>
      <td align="center">
        ${convertedGrams}
      </td>
      <td>${totalPrice.toLocaleString()}</td>
      <td>
        <div class="flex-col">
          <button onclick="edit(${count}, ${price}, ${totalGrams}, ${purity})">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px">
              <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
            </svg>
          </button>     
          <button onclick="removelast(${count})">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px">
              <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
          </button>
        </div>
      </td>
    </tr>`;
}

function removelast(num) {
  document.getElementById(`removenew${num}`).remove()
  document.getElementById(`item${num}`).remove();
  plusplus();
}
function edit(num, price, totalGrams, purity) {
  removelast(num)

  document.getElementById('price').value = price;
  document.getElementById('totalGrams').value = totalGrams;
  // document.getElementById('labourCostPerGram').value = labourCostPerGram;
  document.getElementById('purity').value = purity;

  document.getElementById('priceLabel').classList.add('up')
  document.getElementById('totalGramsLabel').classList.add('up')
  // document.getElementById('labourCostPerGramLabel').classList.add('up')
  document.getElementById('purityLabel').classList.add('up')
}

function correctDiscount(val, id) {
  if (isNaN(val[val.length - 1])) {
    document.getElementById(id).value = val.slice(0, val.length - 1);
    return;
  }
  if (val[0] === '0') {
    document.getElementById(id).value = val.slice(1, val.length);
    return;
  } else
    if (val > 100) {
      document.getElementById(id).value = val.slice(0, val.length - 1);
      return;
    }
}

function printbil() {
  var table = document.getElementById('data');
  let cloned = table.cloneNode(true);
  document.body.appendChild(cloned);
  cloned.classList.add("printable");
  window.print();
  document.body.removeChild(cloned);
  // var body = document.getElementById('body').innerHTML;
  // var data = document.getElementById('data').innerHTML;
  // document.getElementById('body').innerHTML = data;
  // document.getElementById('closeBtn').style.display = "none"
  // window.print();
  // document.getElementById('closeBtn').style.display = "block"
  // document.getElementById('body').innerHTML = body
}

function oneAddOnly() {
  var table = document.getElementById('tabbody2');
  return table.rows.length;
}

function plusplus() {
  document.getElementById('add-btn').disabled = oneAddOnly();
  var table = document.getElementById('tabbody2');
  var sumVal = 0;

  const discount = parseInt(document.getElementById('discount').value);
  const gst = parseInt(document.getElementById('tax').value);

  for (var i = 0; i < table.rows.length; i++) {
    sumVal += parseInt(table.rows[i].cells[4].innerText);
  }

  var dst = Math.round(sumVal);
  document.getElementById('total-bill').innerHTML = dst;

  var receive = Math.round(document.getElementById('receive').value);

  document.getElementById('dst').innerHTML = Math.round(dst / 100 * discount) + `(${discount}%)`;
  document.getElementById('after-dct').innerHTML = Math.round(dst - (dst / 100 * discount));
  document.getElementById('gst').innerHTML = Math.round(dst / 100 * gst);

  var total = Math.round(dst - (dst / 100 * discount) + (dst / 100 * gst));
  document.getElementById('net-total').innerHTML = total;

  document.getElementById('rcd').innerHTML = receive.toLocaleString();
  document.getElementById('total-width-tax').innerHTML = Math.round(dst - (dst / 100 * discount) + (dst / 100 * gst)).toLocaleString();

  document.getElementById('inputlast').value = total;
  var balance = Math.round(receive - total);
  document.getElementById('balance').value = balance;
  document.getElementById('blnc').innerHTML = balance.toLocaleString();
}