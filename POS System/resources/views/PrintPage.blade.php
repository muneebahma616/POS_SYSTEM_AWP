<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Print Invoice</title>
  <link rel="stylesheet" href="{{asset('Styles/invoice.css')}}">
</head>

<body>
  <div style="height: 100vh;">
    <div class="all-item-box" id="data" style="height: 90vh">
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
            <span>{{$data->Salesman}}</span>
          </div>
          <div style="font-size: small;">
            <b>Invoice No:</b>
            <span>DB-{{$data->uuid}}</span>
            <input type="hidden" name="uuid" value="{{$randomNumber}}">
          </div>
        </span>

        <span style="display: flex; justify-content: space-between; width: 100%;">
          <div style="font-size: small;">
            <b>Customer Name: </b>
            <span id="custName">{{$data->CustomerName ?? $data->vendor_name}}</span>
          </div>
          <div style="font-size: small;">
            <b>Phone No:</b>
            <span id="custNo">{{$data->CustomerPhone ?? $data->vendor_phone}}</span>
          </div>
        </span>

        <table class="table text-light bill-table" width="100%">
          <thead>
            <tr>
              <th style="border-bottom: 2px solid white;">Purity</th>
              <th style="border-bottom: 2px solid white;">Rate</th>
              <th style="border-bottom: 2px solid white;">Gram</th>
              <th style="border-bottom: 2px solid white;">Converted Grams(21K)</th>
              <th style="border-bottom: 2px solid white;">Total</th>
            </tr>
          </thead>
          <tbody align="center" id="tabbody2">
            <tr>
              <td>{{$data->GoldKarat ?? $data->goldKarat}}K</td>
              <td>{{$data->Price ?? $data->price}}</td>
              <td>{{$data->Grams ?? $data->grams}}</td>
              <td>{{round((($data->goldKarat ?? $data->GoldKarat) * ($data->grams ?? $data->Grams)) / 21, 2)}}</td>
              <td>{{$data->TotalPrice ?? $data->total_price}}</td>
            </tr>
          </tbody>
        </table>
        <br>

        <div class="line-1"></div>
        <div class="container">
          <div class="name-box">
            <span>Payment Mode</span>
            <span>invoice Total (GST Exclusive):</span>
            <span>Discount:</span>
            <span>Invoice Total (After Discount):</span>
          </div>
          <div class=" price-span">
            <span id="paymentMethod">{{$data->payment_method}}</span>
            <span id="total-bill">{{$data->TotalPrice ?? $data->total_price}}</span>
            <span id="dst">{{$data->Discount}}(%)</span>
            <span id="after-dct">{{($data->TotalPrice ?? $data->total_price) - (($data->TotalPrice ?? $data->total_price) * ($data->Discount/100))}}</span>
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
            <span id="gst">{{$afterTax = ($data->TotalPrice ?? $data->total_price) * ($data->Tax/100)}}</span>
            <span id="net-total">{{$netTotal = ($data->TotalPrice ?? $data->total_price) + $afterTax}}</span>
            <span id="rcd">{{($data->DownPayment ?? $netTotal)}}</span>
          </div>
        </div>
        <div class="line"></div>

        <div class="container">
          <div class="name-box">
            <span>Customer Balance</span>
          </div>
          <div class="price-span">
            <span id="blnc">{{$data->RemainingPayment ?? 0}}</span>
          </div>
        </div>
        <div class="line"></div>

        <div class="container">
          <div class="name-box">
            <span>Total</span>
          </div>
          <div class="price-span">
            <span id="total-width-tax">{{$netTotal}}</span>
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
    <div style="text-align: center;">
      <button type="submit" class="last-btn" id="btn" onclick="printbil()">Print bill</button>
    </div>
  </div>
  <script>
    function printbil() {
      var table = document.getElementById('data');
      let cloned = table.cloneNode(true);
      document.body.appendChild(cloned);
      cloned.classList.add("printable");
      window.print();
      document.body.removeChild(cloned);
      window.history.back();
    }
  </script>
</body>

</html>