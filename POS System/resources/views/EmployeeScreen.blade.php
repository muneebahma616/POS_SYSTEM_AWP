<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="icon" href="../Images/invoice.png" type="image/x-icon">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('Styles/EmployeeScreen.css')}}">
  <title>Employee Home Page</title>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.0/css/all.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <style>
    #pagination-container {
      text-align: right;
    }

    #pagination-container>nav>span {
      cursor: no-drop;
    }

    #pagination-container>nav>span:nth-child(1),
    #pagination-container>nav>a:nth-child(1) {
      border-radius: 5px 0px 0px 5px;
    }

    #pagination-container>nav>a:nth-child(2),
    #pagination-container>nav>span:nth-child(2) {
      border-radius: 0px 5px 5px 0px;
    }

    .uppercase {
      text-transform: uppercase;
      font-weight: bold;
    }

    .green {
      color: green;
    }

    .red {
      color: red;
    }
  </style>
</head>

<body>
  <div class="employee-container">
    <div onclick="document.querySelector('.menu-bar').classList.add('show')" class="menu-icon">
      <ion-icon name="menu-outline"></ion-icon>
    </div>
    <div class="menu-bar">
      <div onclick="document.querySelector('.menu-bar').classList.remove('show')" class="close-icon">
        <ion-icon name="close-outline"></ion-icon>
      </div>
      <nav onclick="openPage('welcome')" class="logo">
        <img width="30px" height="30px" src="../Images/logo.png" alt="">
        <b>Al Baraka Factory</b>
      </nav>
      <a href="/invoice" class="menu-btn" onclick="removeOpenedPage()">Make Invoice</a>
      <button class="menu-btn" onclick="openPage('salesRecords')">Sales Records</button>
      <button class="menu-btn" onclick="openPage('changePassword')">Change Password</button>
      <button class="menu-btn" onclick="logOut()">Log Out</button>
    </div>
    <div class="page-content">
      <div id="welcome" class="content-section" style="display: block;">
        <h1 style="text-align: center;">Welcome {{$saleman->name}}</h1>
        <h3>Inventory Record:</h3>
        <div>
          <span>Storage Left: </span>
          <span>{{$storedGrams}} Grams</span>
        </div>
        <div>
          <span>Salary Status: </span>
          <span class="uppercase {{$saleman->salarystatus == 'paid' ? 'green' : 'red'}}">{{$saleman->salarystatus ?? 'unpaid'}}</span>
        </div>
      </div>

      <div id="salesRecords" class="content-section">
        <h2>Sales Records</h2>
        <nav style="display: flex; justify-content: end; margin: 5px;">
          <button type="button" class="btn-default bg-dark" style="color: white;" onclick="printTable('salesReportsTable')">
            Print Table
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 15px; height: 15px;">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
            </svg>
          </button>
        </nav>
        <nav id="salesReportsTable" style="overflow-x: scroll;">
          <nav style="text-align: center;" class="hide">
            <h4>Al Baraka Factory</h4>
            <h6>Sales Report</h6>
          </nav>
          <table class="basic">
            <thead>
              <tr>
                <th>No#</th>
                <th>Customer Details</th>
                <th>Salesman</th>
                <!-- <th>Description</th> -->
                <th>DownPayment</th>
                <th>Remaining Payment</th>
                <th>Gold Karat</th>
                <th>Price</th>
                <th>Grams</th>
                <th>Conversion</th>
                <!-- <th>Labour/ Gram</th> -->
                <th>Tax</th>
                <th>Discount</th>
                <th>Total Price</th>
                <th>Payment Method</th>
                <th>Delivery Date</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $totalSalesPrice = 0;
              ?>
              @forelse ($sales as $key=>$data)
              <?php
              $totalSalesPrice += $data->TotalPrice;
              ?>
              <tr>
                <td>{{$key+1}}</td>
                <td style="cursor: pointer;" onclick="toggleInvoiceDetails(1)">
                  <nav class="text-wrapping">
                    <span><u>Name:</u> {{$data->CustomerName}}</span>
                    <nav id="customerDetails1" class="hide">
                      <span><u>Phone Number:</u> {{$data->CustomerPhone}}</span>
                    </nav>
                  </nav>
                </td>
                <td style="text-wrap: nowrap;">{{$data->Salesman}}</td>
                <!-- <td>
                  <nav class="text-wrapping">
                    Test
                  </nav>
                </td> -->
                <td>{{$data->DownPayment}}</td>
                <td>{{$data->RemainingPayment}}</td>
                <td>{{$data->GoldKarat}}</td>
                <td>{{$data->Price}}</td>
                <td>{{$data->Grams}}</td>
                <td>{{round(($data->GoldKarat * $data->Grams) / 21, 2)}}</td>
                <td>{{$data->Tax}}</td>
                <td>{{$data->Discount}}</td>
                <td>{{$data->TotalPrice}}</td>
                <td>{{$data->payment_method}}</td>
                <td>{{$data->deliverydate}}</td>
                <td>
                  <a href="/printInvoice/{{$data->uuid}}/sales">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 15px; height: 15px;">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                    </svg>
                  </a>
                </td>
              </tr>
              @empty
              no data found
              @endforelse
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td align="right">Total:</td>
                <td colspan="3">{{$totalSalesPrice}}</td>
              </tr>
            </tbody>
          </table>
        </nav>
        <nav style="margin: 5px;" aria-label="Page navigation example">
          <nav id="pagination-container" class="pagination-container" style="padding: 20px 0;">
            <?php echo $sales->links(); ?>
          </nav>
        </nav>
      </div>

      <div id="changePassword" class="content-section">
        @if (\Session::has('err'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <div>
            <a>{!! \Session::get('err') !!}</a>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if (\Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <div>
            <a>{!! \Session::get('success') !!}</a>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <h2>Change password</h2>
        <form action="/changepassword/{{$saleman->uuid}}" method="get">
          @csrf
          <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 20px">
            <div class="form-floating">
              <input required name="oldPassword" value="" type="password" class="form-control bg-dark text-white" id="floatingoldPassword" placeholder="Old Password">
              <label for="floatingoldPassword">Old Password</label>
            </div>
            <div class="form-floating">
              <input required pattern=".{6,21}" name="newPassword" value="" type="password" class="form-control bg-dark text-white" id="floatingnewPassword" placeholder="New Password">
              <label for="floatingnewPassword">New Password</label>
            </div>
            <div class="form-floating">
              <input required pattern=".{6,21}" name="confirmnewPassword" value="" type="password" class="form-control bg-dark text-white" id="floatingconfirmPassword" placeholder="Confirm New Password">
              <label for="floatingconfirmPassword">Confirm New Password</label>
            </div>
          </div>
          <br>
          <button type="button" onclick="openPage('welcome')" class="btn btn-secondary">Cancel</button>
          <button type="submit" class="btn btn-success">Save</button>
        </form>
      </div>
    </div>
  </div>
  <script src="{{asset('Logics/EmployeeScreen.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var navTag = document.querySelector(".pagination-container > nav");
      if (navTag) {
        navTag.className = "pagination pagination-sm justify-content-end";
        var anchorTags = document.querySelectorAll(".pagination-container > nav > a");
        var spanTags = document.querySelectorAll(".pagination-container > nav > span");

        // Loop through each 'a' tag and remove all classes
        anchorTags.forEach(function(tag) {
          tag.className = "page-item page-link bg-dark";
        });
        spanTags.forEach(function(tag) {
          tag.className = "page-item page-link bg-dark";
        });
      }
    });
  </script>
</body>

</html>