<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link rel="icon" href="../Images/invoice.png" type="image/x-icon">
  <title>Invoice App</title>
  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.0/css/all.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('Styles/invoice.css') }}">
</head>

<body id="body">
  <div style="position: absolute; left: 10px; right: 10px; top: 1px; z-index: 10;">
    @if (\Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <div>
        <a>{!! \Session::get('success') !!}</a>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if (\Session::has('err'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <div>
        <a>{!! \Session::get('err') !!}</a>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
  </div>
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
      <div class="modal-content bg-dark text-white">
        <div class="modal-body">
          <span>
            Are you sure do you want to go back?
          </span>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
          <a href="{{$salesman == 'admin' ? '/admin' : 'show'}}" class="btn btn-primary">Yes</a>
        </div>
      </div>
    </div>
  </div>

  <form action="submitsales" method="get">
    @csrf
    <div>
      <input type="hidden" name="GoldKarat" id="GoldKarat" value="18">
      <input type="hidden" name="Price" id="Price" value="0">
      <input type="hidden" name="Grams" id="Grams" value="0">
      <input type="hidden" name="Salesman" id="Salesman" value="{{$salesman}}">
    </div>
    <div class="parent-container">
      <div class="first-box">
        <nav>Product</nav>
        <form id="form">
          <div class="button-box2">
            <div style="display: flex; justify-content:space-between; padding: 0px 25px;">
              <span style="font-size: larger; font-weight: 600;">Sales Invoice</span>
              <div onclick="toggleShow()" class="menuBars">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 30px; height: 30px; color: white;">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
              </div>
            </div>
            <!-- Customer Name area -->
            <div class="relative">
              <label id="custLabel" for="customerName" class="label">Customer Name</label>
              <input required name="CustomerName" onfocus="document.getElementById('custLabel').classList.add('up')" onblur="!this.value && document.getElementById('custLabel').classList.remove('up')" onkeyup="this.value ? (document.getElementById('custName').innerText = this.value.slice(0,25) && (this.value = this.value.slice(0,25))) : (document.getElementById('custName').innerText = 'xyz')" type="text" class="add-prd" id="customerName">
            </div>
            <!-- Customer phonenumber area -->
            <div class="relative">
              <label id="custNoLabel" for="customerNo" class="label">Phone No.</label>
              <input required name="CustomerPhone" onfocus="document.getElementById('custNoLabel').classList.add('up')" onblur="!this.value && document.getElementById('custNoLabel').classList.remove('up')" onkeyup="this.value ? (document.getElementById('custNo').innerText = this.value) : (document.getElementById('custNo').innerText = 123456)" onkeypress="return event.charCode >= 48 && event.charCode <= 57" type="text" class="add-prd" id="customerNo">
            </div>

            <!-- Description area -->
            <!-- <div class="relative">
              <label id="descriptionLabel" for="desc" class="label">Description</label>
              <input onfocus="document.getElementById('descriptionLabel').classList.add('up')" onblur="!this.value && document.getElementById('descriptionLabel').classList.remove('up')" type="text" class="add-prd" id="desc" autocomplete="off">
            </div> -->

            <div class="relative">
              <label id="salesmanLabel" for="salesman" class="selectLabel up">Salesman</label>
              <select name="salesman" readonly onfocus="document.getElementById('salesmanLabel').classList.add('up')" onblur="this.value === '0' && document.getElementById('salesmanLabel').classList.remove('up')" class="add-prd" id="salesman">
                <option selected>{{$salesman}}</option>
              </select>
            </div>

            <div class="relative">
              <label id="purityLabel" for="purity" class="selectLabel up">Purity</label>
              <select onchange="document.getElementById('GoldKarat').value = this.value; document.getElementById('totalGrams').value = '';document.getElementById('totalGramsLabel').classList.remove('up')" onfocus="document.getElementById('purityLabel').classList.add('up')" onblur="this.value === '0' && document.getElementById('purityLabel').classList.remove('up')" class="add-prd" id="purity">
                <option value="18">
                  18
                </option>
                <option value="21">
                  21
                </option>
                <option value="24">
                  24
                </option>
              </select>
            </div>

            <!-- Price area -->
            <div class="relative">
              <label id="priceLabel" for="price" class="label">Price/Gram</label>
              <input onchange="document.getElementById('Price').value = this.value" onfocus="document.getElementById('priceLabel').classList.add('up')" onblur="!this.value && document.getElementById('priceLabel').classList.remove('up')" onkeypress="return this.value.length < 10 && ((event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46)" oninput="onlyNumberInput(this.value, this.id)" type="text" class="add-prd" id="price" autocomplete="off">
            </div>

            <!-- Total grams area -->
            <div class="relative">
              <label id="totalGramsLabel" for="totalGrams" class="label">Total Grams</label>
              <input onchange="document.getElementById('Grams').value = this.value" onfocus="document.getElementById('totalGramsLabel').classList.add('up')" onblur="!this.value && document.getElementById('totalGramsLabel').classList.remove('up')" onkeypress="return this.value.length < 10 && ((event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46)" oninput="onlyNumberInput(this.value, this.id, '{{$storedGrams}}')" type="text" class="add-prd" id="totalGrams" autocomplete="off">
            </div>

            <!-- Labour cost area -->
            <!-- <div class="relative">
              <label id="labourCostPerGramLabel" for="labourCostPerGram" class="label">Labour/Gram</label>
              <input onfocus="document.getElementById('labourCostPerGramLabel').classList.add('up')" onblur="!this.value && document.getElementById('labourCostPerGramLabel').classList.remove('up')" onkeypress="return this.value.length < 10 && ((event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46)" oninput="onlyNumberInput(this.value, this.id)" type="text" class="add-prd" id="labourCostPerGram" autocomplete="off">
            </div> -->

            <!-- Payment menthod area -->
            <div class="relative">
              <label id="paymentMethodLabel" for="payment-method" class="selectLabel up">Payment Method</label>
              <select onchange="document.getElementById('paymentMethod').innerText = this.value" name="payment_method" readonly onfocus="document.getElementById('paymentMethodLabel').classList.add('up')" onblur="this.value === '0' && document.getElementById('salesmanLabel').classList.remove('up')" class="add-prd">
                <option selected value="Cash">Cash</option>
                <option value="Bank">Bank</option>
              </select>
            </div>

            <!-- Dlivery date area -->
            <div class="relative">
              <label id="dateLabel" for="date" class="label">Delivery Date</label>
              <input required onfocus="document.getElementById('dateLabel').classList.add('up')" onblur="!this.value && document.getElementById('dateLabel').classList.remove('up')" class="add-prd" style="background: linear-gradient(90deg, rgba(0, 0, 0, 0.8) 80%, rgba(0, 0, 0, 0.2) 100%);" type="date" name="deliverydate" id="date">
            </div>

            <div class="form-btns">
              <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Go Back
              </button>
              <button onclick="addbtn()" type="button" id="add-btn">Add</button>
            </div>
          </div>
        </form>
      </div>

      <div class="second-box">
        <nav>Cart</nav>
        <div class="table-div">
          <div class="item-name2">
            <table class="table1">
              <thead>
                <tr class="tr">
                  <!-- <td width="100%" style="height: 26px; padding-left: 20px;">
                    Description
                  </td> -->
                  <td width="100%" style="padding-left: 20px;">Purity</td>
                  <td width="100%">Grams</td>
                  <td width="100%">Conversion(21K)</td>
                  <td width="100%">Price</td>
                  <td width="100%"></td>
                </tr>
              </thead>
              <tbody id="tabbody">
              </tbody>
            </table>
          </div>
        </div>
        <button type="button" class="btn-emty" onclick="empty()">EMPTY CART</button>
      </div>

      <div id="offcanvasBill" class="third-box">
        <nav>Total Bill</nav>

        <div class="all-item-box" id="data">
          <div>
          </div>
          <div class="justify-content-center">
            <div class="invoice-bil">
              <span class="Cake-bakes">
                Al Baraka Factory
              </span>
              <div id="closeBtn" class="menuBars" onclick="toggleShow()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 30px; height: 30px; position: absolute; right: 30px; top: 45; cursor: pointer;">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
              </div>
              <span class="sale">Sale Invoice</span>
              <span class="address">Near Souq Dakhli Gold Marker, Sabya</span>
            </div>

            <span style="display: flex; justify-content: space-between; width: 100%;">
              <div style="font-size: small;">
                <b>Salesman: </b>
                <span>{{$salesman}}</span>
              </div>
              <div style="font-size: small;">
                <b>Invoice No:</b>
                <span>DB-{{$randomNumber}}</span>
                <input type="hidden" name="uuid" value="{{$randomNumber}}">
              </div>
            </span>

            <span style="display: flex; justify-content: space-between; width: 100%;">
              <div style="font-size: small;">
                <b>Customer Name: </b>
                <span id="custName">xyz</span>
              </div>
              <div style="font-size: small;">
                <b>Phone No:</b>
                <span id="custNo">123456</span>
              </div>
            </span>

            <table class="table text-light bill-table">
              <thead>
                <tr>
                  <th>Purity</th>
                  <th>Rate</th>
                  <th>Gram</th>
                  <th>Conversion(21K)</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody id="tabbody2">

              </tbody>
            </table>

            <div class="line-1"></div>
            <div class="container">
              <div class="name-box">
                <span>Payment Mode</span>
                <span>invoice Total (GST Exclusive):</span>
                <span>Discount:</span>
                <span>Invoice Total (After Discount):</span>
              </div>
              <div class=" price-span">
                <span id="paymentMethod">Cash</span>
                <span id="total-bill">0.00</span>
                <span id="dst">0(%)</span>
                <span id="after-dct">0.00</span>
              </div>
            </div>
            <div class="line"></div>

            <div class="container">
              <div class="name-box">
                <span>Total GST</span>
                <span>Invoice Net Total</span>
                <span>Recived</span>
              </div>
              <div class="price-span">
                <span id="gst">0.00</span>
                <span id="net-total">0.00</span>
                <span id="rcd">0.00</span>
              </div>
            </div>
            <div class="line"></div>

            <div class="container">
              <div class="name-box">
                <span>Customer Balance</span>
              </div>
              <div class="price-span">
                <span id="blnc">0.00</span>
              </div>
            </div>
            <div class="line"></div>

            <div class="container">
              <div class="name-box">
                <span>Total</span>
              </div>
              <div class="price-span">
                <span id="total-width-tax">0.00</span>
              </div>
            </div>
            <div class="line"></div>

            <span class="span">
              <h5 align="center">For any Assistance. Pleace Contact</h5>
            </span>
            <span class="span">
              <h4 align="center">03xx-xxxxxxx</h4>
            </span>
            <hr>

          </div>
        </div>

        <div class="button-box">
          <div style="display: flex; flex-direction:column;">
            <div class="input-container">
              <span class="recived-text">Bill</span>
              <input value="0" name="TotalPrice" type="text" class="input total-input" id="inputlast" readonly>
            </div>
            <div class="input-container">
              <span class="recived-text">Recived</span>
              <input onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="0" name="DownPayment" type="text" class="input total-input" id="receive" onkeyup="plusplus()">
            </div>
            <div class="input-container">
              <span class="recived-text">Balance</span>
              <input value="0" name="RemainingPayment" type="text" class="input total-input" id="balance" readonly>
            </div>
            <div id="line"></div>
            <div class="input-container">
              <span class="recived-text">Tax%</span>
              <input name="Tax" onkeyup="plusplus()" oninput="this.value ? correctDiscount(this.value, this.id) : this.value = 0" type="text" value="0" class="input total-input" id="tax">
            </div>
            <div class="input-container">
              <span class="recived-text">Discount%</span>
              <input name="Discount" onkeyup="plusplus()" oninput="this.value ? correctDiscount(this.value, this.id) : this.value = 0" type="text" value="0" class="input total-input" id="discount">
            </div>
          </div>
          <button type="submit" class="last-btn" id="btn" onclick="printbil()">Save & Print bill</button>
        </div>

      </div>

    </div>
  </form>


  <script src="{{ asset('Logics/invoice.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>