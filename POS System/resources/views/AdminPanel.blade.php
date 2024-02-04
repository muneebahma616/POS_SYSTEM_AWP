<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="icon" href="../Images/invoice.png" type="image/x-icon">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('Styles/AdminPanel.css') }}">
  <title>Admin Panel</title>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.0/css/all.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <style>
    .ellipsis {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 200px;
      /* Adjust the maximum width as needed */
    }

    .record-box {
      display: grid;
      grid-template-columns: 1fr 1fr;
      width: fit-content;
      /* border: 1px solid white; */
      row-gap: 20px;
      padding: 10px 0;
    }

    .record-box>span {
      border-bottom: 1px solid white;
      padding: 0 5px;
    }

    .record-box>span:nth-child(even) {
      text-align: right;
    }

    .filter-container {
      border: 1px solid white;
    }

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

    .time-box-container {
      width: 350px;
      position: fixed;
      right: -100%;
      text-align: right;
      background-color: rgb(0, 0, 0, 0.9);
      padding: 10px;
      border-radius: 10px;
      transition: 0.3s all ease;
    }

    @media (max-width: 360px) {
      .time-box-container {
        width: 100%;
      }
    }

    .show {
      right: 0;
    }

    .time-box {
      display: grid;
      align-items: center;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
    }

    aside {
      position: absolute;
      right: 0;
      color: white;
      cursor: pointer;
      padding: 10px;
    }

    .form-control {
      border: none;
      border-bottom: 1px solid white;
      border-radius: 0;
    }
  </style>
</head>

<body>
  <div class="admin-container">
    <div onclick="document.querySelector('.menu-bar').classList.add('show')" class="menu-icon">
      <ion-icon name="menu-outline"></ion-icon>
    </div>
    <div class="menu-bar">
      <div onclick="document.querySelector('.menu-bar').classList.remove('show')" class="close-icon">
        <ion-icon name="close-outline"></ion-icon>
      </div>

      <!-- <div style="border: 1px solid red; width: 100%; display: flex; gap: 10px; align-items: center;">
        <img class="logo" src="../Images/logo.png" width="30px" height="30px" alt="">
        <span style="color: white;">Gold Shop</span>
      </div> -->

      <!-- <div class="dropdown-container" style="position: relative;">
        <button class="menu-btn" onmouseleave="hideDropdown()" onmouseenter="showDropdown()">Invoices</button>
        <div onmouseleave="hideDropdown()" onmouseenter="showDropdown()" id="dropdown" class="dropdown"
          style="position: absolute;">
          <button class="menu-btn" onclick="openPage('salesInvoice')">Sales Invoice</button>
          <button class="menu-btn" onclick="openPage('purchaseInvoice')">Purchase Invoice</button>
        </div>
      </div> -->
      <a href="/admin?page=1" onclick="openPage('welcome')" class="logo">
        <img width="30px" height="30px" src="../Images/logo.png" alt="">
        <b>Al Baraka Factory</b>
      </a>

      <span class="d-inline-flex gap-1" style="width: 100%;">
        <button ondblclick="toggleRotate(1)" onclick="toggleRotate(1)" data-bs-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample" class="menu-btn">
          <div>
            <ion-icon name="newspaper-outline"></ion-icon>
            Invoices
          </div>
          <ion-icon id="dropdown-icon1" style="transition: 0.5s all ease;" name="chevron-down-outline"></ion-icon>
        </button>
      </span>
      <nav style="width: 100%;" class="collapse" id="collapseExample">
        <nav style="display: flex; flex-direction: column; gap: 0px;">
          <a onclick="removeOpenedPage()" href="invoice" class="menu-btn">
            <div>
              <ion-icon name="card-outline"></ion-icon>
              Sales Invoice
            </div>
          </a>
          <a onclick="removeOpenedPage()" href="purchase" class="menu-btn">
            <div>
              <ion-icon name="cash-outline"></ion-icon>
              Purchase Invoice
            </div>
          </a>
          <a href="/admin?page=1" onclick="openPage('pendngPage')" class="menu-btn">
            <div>
              <ion-icon name="hourglass-outline"></ion-icon>
              Pending Order
            </div>
          </a>
        </nav>
      </nav>

      <span class="d-inline-flex gap-1" style="width: 100%;">
        <button ondblclick="toggleRotate(2)" onclick="toggleRotate(2)" data-bs-toggle="collapse" href="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2" class="menu-btn">
          <div>
            <ion-icon name="people-outline"></ion-icon>
            Employee Management
          </div>
          <ion-icon id="dropdown-icon2" style="transition: 0.5s all ease;" name="chevron-down-outline"></ion-icon>
        </button>
      </span>
      <nav style="width: 100%;" class="collapse" id="collapseExample2">
        <nav style="display: flex; flex-direction: column; gap: 0px;">
          <button class="menu-btn" onclick="openPage('addEmployee')">
            <div>
              <ion-icon name="person-add-outline"></ion-icon>
              Add Employee
            </div>
          </button>
          <a href="/admin?page=1" class="menu-btn" onclick="openPage('manageEmployee')">
            <div>
              <ion-icon name="person-outline"></ion-icon>
              Manage Employee
            </div>
          </a>
        </nav>
      </nav>

      <!-- <button class="menu-btn" onclick="openPage('employeeManager')">

      </button> -->
      <!-- <button class="menu-btn" onclick="openPage('purchaseReport')">Purchase Report</button> -->
      <!-- <button class="menu-btn" onclick="openPage('salesReport')">Sales Report</button> -->
      <button class="menu-btn" onclick="openPage('otherExpanses')">
        <div>
          <ion-icon name="wallet-outline"></ion-icon>
          Other Expanses
        </div>
      </button>

      <span class="d-inline-flex gap-1" style="width: 100%;">
        <button ondblclick="toggleRotate(3)" onclick="toggleRotate(3)" data-bs-toggle="collapse" href="#collapseExample3" aria-expanded="false" aria-controls="collapseExample3" class="menu-btn">
          <div>
            <ion-icon name="receipt-outline"></ion-icon>
            Reports
          </div>
          <ion-icon id="dropdown-icon3" style="transition: 0.5s all ease;" name="chevron-down-outline"></ion-icon>
        </button>
      </span>
      <nav style="width: 100%;" class="collapse" id="collapseExample3">
        <nav style="display: flex; flex-direction: column; gap: 0px;">
          <a href="/admin?page=1" class="menu-btn" onclick="openPage('purchaseReport')">
            <div>
              <ion-icon name="wallet-outline"></ion-icon>
              Purchase Report
            </div>
          </a>
          <a href="/admin?page=1" class="menu-btn" onclick="openPage('salesReport')">
            <div>
              <ion-icon name="server-outline"></ion-icon>
              Sales Report
            </div>
          </a>
          <a href="/admin?page=1" class="menu-btn" onclick="openPage('otherReport')">
            <div>
              <ion-icon name="pricetags-outline"></ion-icon>
              Other
            </div>
          </a>
        </nav>
      </nav>

      <span class="d-inline-flex gap-1" style="width: 100%;">
        <button ondblclick="toggleRotate(4)" onclick="toggleRotate(4)" data-bs-toggle="collapse" href="#collapseExample4" aria-expanded="false" aria-controls="collapseExample4" class="menu-btn">
          <div>
            <ion-icon name="list-outline"></ion-icon>
            Records
          </div>
          <ion-icon id="dropdown-icon4" style="transition: 0.5s all ease;" name="chevron-down-outline"></ion-icon>
        </button>
      </span>
      <nav style="width: 100%;" class="collapse" id="collapseExample4">
        <nav style="display: flex; flex-direction: column; gap: 0px;">
          <a href="/admin?page=1" class="menu-btn" onclick="openPage('customerRecord')">
            <div>
              <ion-icon name="person-circle-outline"></ion-icon>
              Customer Records
            </div>
          </a>
          <a href="/admin?page=1" class="menu-btn" onclick="openPage('venderRecord')">
            <div>
              <ion-icon name="logo-venmo"></ion-icon>
              Vender Records
            </div>
          </a>
          <a href="/admin?page=1" class="menu-btn" onclick="openPage('ledger')">
            <div>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 15px; height: 15px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
              </svg>
              ledger
            </div>
          </a>
        </nav>
      </nav>

      <!-- <button class="menu-btn" onclick="openPage('otherReport')">
        <div>
          <ion-icon name="receipt-outline"></ion-icon>
          Reports
        </div>
      </button> -->

      <button class="menu-btn" onclick="logOut()">
        <div>
          <ion-icon name="log-out-outline"></ion-icon>
          Logout
        </div>
      </button>
    </div>
    <div class="page-content">
      <aside>
        <svg onclick="document.getElementById('dateForm').classList.toggle('show')" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
        </svg>
        <div class="time-box-container" id="dateForm">
          <div class="time-box">
            <label for="startTime">Start Time:</label>
            <input required class="bg-dark text-white btn" type="date" name="startTime" id="startTime">
            <label for="endTime">End Time:</label>
            <input required class="bg-dark text-white btn" type="date" name="endTime" id="endTime">
          </div>
          <div style="margin-top: 10px;">
            <a href="/admin?page=1" class="btn btn-secondary">Reset</a>
            <button onclick="submitForm()" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </aside>
      <div id="pendngPage" class="content-section">
        <!-- Done Pending Model -->
        <div class="modal fade" id="exampleModal9" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content bg-dark">
              <div class="modal-body" style="text-align: center;">
                <b>Are you sure to done the sales complete?</b>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="/" id="donePayment-btn" type="button" class="btn btn-success">Yes</a>
              </div>
            </div>
          </div>
        </div>

        <!-- Edit Model -->
        <div class="modal fade" id="exampleModal11" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <form id="edit-pending-form" action="/" method="get">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
              <div class="modal-content bg-dark">
                <div class="modal-body">
                  <div>
                    <label for="ed-pending-id">ID:</label>
                    <input type="text" readonly id="ed-pending-id" value="">
                  </div>
                  <div>
                    <label for="ed-pending-name">Name:</label>
                    <input readonly type="text" name="name" id="ed-pending-name" value="">
                  </div>
                  <div>
                    <label for="ed-pending-phone">Phone number:</label>
                    <input readonly type="text" name="phoneNumber" id="ed-pending-phone" value="">
                  </div>
                  <div>
                    <label for="ed-pending-downpayment">Down Payment:</label>
                    <input readonly type="text" name="downpayment" id="ed-pending-downpayment" value="">
                  </div>
                  <div>
                    <label for="ed-pending-remaining">Remaining Payment:</label>
                    <input readonly type="text" name="remainingpayment" id="ed-pending-remaining" value="">
                  </div>
                  <div>
                    <label for="ed-pending-add">Add Payment:</label>
                    <input onkeypress="return event.charCode >= 48 && event.charCode <= 57" type="text" name="add-balance" id="ed-pending-add" value="">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-success">Update</button>
                </div>
              </div>
            </div>
          </form>
        </div>

        <h2>Pending Orders</h2>
        <div style="overflow-x: scroll;">
          <table class="basic">
            <thead>
              <tr>
                <th>No#</th>
                <th>Customer Details</th>
                <th>Salesman</th>
                <th>Down Payment</th>
                <th>Remaining Payment</th>
                <th>Purity</th>
                <th>Price</th>
                <th>Grams</th>
                <th>Conversion</th>
                <th>Tax Rate</th>
                <th>Discount Rate</th>
                <th>Total Price</th>
                <th>Payment Method</th>
                <th>Delivery Date</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $totalPendingDownPayment = 0;
              ?>
              @forelse ($pendingSales as $key=>$data)
              @if ($data->RemainingPayment >= 0) @continue @endif <tr>
                <?php
                $totalPendingDownPayment += $data->DownPayment;
                ?>
              <tr>
                <td>{{ ($key + 1) + ((request('page') - 1) * 10) }}</td>
                <td style="cursor: pointer;" onclick="toggleInvoiceDetails(1)">
                  <div class="text-wrapping">
                    <span><u>Name:</u> {{$data->CustomerName}}</span>
                    <div id="customerDetails1" class="hide">
                      <span><u>Phone Number:</u> {{$data->CustomerPhone}}</span>
                    </div>
                  </div>
                </td>
                <td>{{$data->Salesman}}</td>
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
                  <div style="display: flex; gap: 5px;">
                    <button onclick="setEditSalesIndex('{{$key}}','{{$data->id}}')" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal11" class="btn-default">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 15px; height: 15px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                      </svg>
                    </button>
                    <button onclick="document.getElementById('donePayment-btn').href = '/editsalesdone/{{$data->id}}'" data-bs-toggle="modal" data-bs-target="#exampleModal9" type="button" class="btn-default">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 15px; height: 15px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>
              @empty
              no data found
              @endforelse
              <tr>
                <td></td>
                <td></td>
                <td align="right">Total:</td>
                <td colspan="11">{{$totalPendingDownPayment}}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <nav style="margin: 5px;" aria-label="Page navigation example">
          <div id="pagination-container" class="pagination-4" style="padding: 20px 0;">
            <?php echo $pendingSales->appends(request()->query())->links(); ?>
          </div>
        </nav>
      </div>

      <div id="addEmployee" class="content-section">
        <!-- Content for Employee Manager -->
        <h2>New Employee</h2>
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
        <form method="get" action="addsalesman">
          @csrf
          <nav class="addEmployeeContainer">
            <nav>
              <label for="username">Username</label>
              <input pattern="\w{1}[\w\d]{1,}" type="text" name="name" id="username" required>
            </nav>

            <nav>
              <label for="password">Password</label>
              <nav style="position: relative;">
                <input type="password" name="password" id="password" required>
                <ion-icon onclick="togglePasswordView()" class="eye-icon" id="eye-on" name="eye-outline"></ion-icon>
                <ion-icon style="display: none;" onclick="togglePasswordView()" class="eye-icon" id="eye-off" name="eye-off-outline"></ion-icon>
              </nav>
            </nav>

            <nav>
              <label for="phoneNumber">Phone number</label>
              <input onkeypress="return event.charCode >= 48 && event.charCode <= 57" type="text" name="phoneNumber" id="phoneNumber" required>
            </nav>

            <nav>
              <label for="salary">Salary</label>
              <input onkeypress="return event.charCode >= 48 && event.charCode <= 57" type="text" name="salary" id="salary" required>
            </nav>
            <span>
              <button type="submit">Save</button>
            </span>
          </nav>
        </form>
      </div>

      <div id="manageEmployee" class="content-section">
        <!-- Content for Employee Manager -->
        @if (\Session::has('unautherr'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <div>
            <a>{!! \Session::get('unautherr') !!}</a>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if (\Session::has('successChange'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <div>
            <a>{!! \Session::get('successChange') !!}</a>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <!-- Edit Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <form id="edit-form" action="/" method="get">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
              <div class="modal-content bg-dark">
                <!-- <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div> -->
                <input type="hidden" name="employeeKey" id="employeeId" value="0">
                <div class="modal-body">
                  <div>
                    <label for="ed-id">ID:</label>
                    <input type="text" readonly id="ed-id" value="">
                  </div>
                  <div>
                    <label for="ed-name">Name:</label>
                    <input type="text" name="name" id="ed-name" value="">
                  </div>
                  <div>
                    <label for="ed-phone">Phone number:</label>
                    <input onkeypress="return event.charCode >= 48 && event.charCode <= 57" type="text" name="phoneNumber" id="ed-phone" value="">
                  </div>
                  <!-- <div>
                    <label for="ed-password">Password:</label>
                    <input disabled type="password" name="password" id="ed-password" value="">
                  </div> -->
                  <div>
                    <label for="salary">Salary:</label>
                    <input onkeypress="return event.charCode >= 48 && event.charCode <= 57" type="text" name="salary" id="ed-salary" value="">
                  </div>
                  <div>
                    <label for="privilege">Privilege:</label>
                    <select name="privilege" id="ed-privilege">
                      <option value="employee">Employee</option>
                      <option value="all">All</option>
                    </select>
                  </div>
                  <div>
                    <label for="ed-salary-paid-date">Salary paid date:</label>
                    <input readonly type="text" id="ed-salary-paid-date" value="">
                  </div>
                  <div>
                    <label for="ed-created-at">Created at:</label>
                    <input type="text" id="ed-created-at" readonly value="">
                  </div>
                  <div>
                    <label for="ed-updated-at">Updated at:</label>
                    <input type="text" id="ed-updated-at" readonly value="">
                  </div>
                </div>
                <div class="modal-footer">
                  <div style="display: flex; justify-content:space-between; width: 100%;">
                    <a href="/" id="reset-btn" class="btn-default">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 15px; height: 15px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                      </svg>
                    </a>
                    <div>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-success">Update</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content bg-dark">
              <div class="modal-body" style="text-align: center;">
                <b>Are you sure to delete the record?</b>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="/" id="delete-btn" type="button" class="btn btn-danger">Delete</a>
              </div>
            </div>
          </div>
        </div>

        <!-- Pay Modal -->
        <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel3" aria-hidden="true">
          <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content bg-dark">
              <div class="modal-body" style="display: flex; flex-direction: column; align-items: center;">
                <span>Are you sure?</span>
                <span>You will not be able to reset again!!!</span>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="/paid/0" id="pay-btn" type="button" class="btn btn-success">Pay</a>
              </div>
            </div>
          </div>
        </div>

        <input type="hidden" name="paymenyNo" id="paymenyNo" value="0">

        <h2>Manage Employees</h2>
        <!-- <p>This is the Employee Manager content.</p> -->
        <div style="overflow-x: scroll;">
          <table class="basic">
            <thead>
              <tr>
                <th>No#</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Salary status</th>
                <th>Salary</th>
                <th>ID</th>
                <th>Privilage</th>
                <th>Operations</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($salesman as $key=>$data)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$data->name}}</td>
                <td>{{$data->phoneNumber}}</td>
                <!-- <td class="ellipsis">{{$data->password}}</td> -->
                <td>{{$data->salarystatus}}</td>
                <td>{{$data->salary}}</td>
                <td>{{$data->id}}</td>
                <td>{{$data->privilege}}</td>
                <td>
                  <div style="display: flex; gap: 5px;">
                    <button onclick="setEditIndex('{{$key}}', '{{$data->uuid}}')" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn-default">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" style="width: 15px; height: 15px;">
                        <path strokeLinecap="round" strokeLinejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                      </svg>
                    </button>
                    <button onclick="document.getElementById('delete-btn').href = 'delete/{{$data->uuid}}'" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal2" class="btn-red">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 15px; height: 15px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                      </svg>
                    </button>
                    <button {{ $data->salarystatus == 'paid' ? 'disabled' : '' }} onclick="document.getElementById('pay-btn').href = `/paid/{{$data->uuid}}`" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal3" id="employeePayment1" class="btn-default {{$data->salarystatus}}">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; height: 18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>
              @empty
              no data found
              @endforelse
            </tbody>
          </table>
        </div>
        <nav style="margin: 5px;" aria-label="Page navigation example">
          <div id="pagination-container" class="pagination-2x" style="padding: 20px 0;">
            <?php echo $salesman->appends(request()->query())->links(); ?>
          </div>
        </nav>
        <!-- <nav style="margin: 5px;" aria-label="Page navigation example">
          <ul class="pagination pagination-sm justify-content-end">
            <li class="page-item">
              <a class="page-link bg-dark" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <li class="page-item"><a class="page-link bg-dark" href="#">1</a></li>
            <li class="page-item"><a class="page-link bg-dark" href="#">2</a></li>
            <li class="page-item"><a class="page-link bg-dark" href="#">3</a></li>
            <li class="page-item">
              <a class="page-link bg-dark" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav> -->
      </div>

      <div id="otherExpanses" class="content-section">
        <!-- Content for Other Expanses -->
        <h2>Add Other Expanses</h2>
        <form action="otherexpenses" method="get">
          @csrf
          <nav class="addOtherContainer">
            <nav>
              <label for="username">Item name</label>
              <input type="text" name="itemName" id="item-name" required>
            </nav>

            <nav>
              <label for="price">Price</label>
              <input onkeypress="return event.charCode >= 48 && event.charCode <= 57" type="text" name="Price" id="price" required>
            </nav>

            <nav>
              <label for="description">Description</label>
              <textarea value="" name="description" id="description" cols="10" rows="3"></textarea>
              <!-- <input type="text" name="item-name" id="item-name" required> -->
            </nav>

            <nav>
              <label for="type">Type</label>
              <input style="background-color: rgba(128, 128, 128, 0.164); color: gray;" type="text" name="type" id="type" value="Other" readonly>
            </nav>

            <span>
              <button type="submit">Save</button>
            </span>
          </nav>
        </form>
      </div>

      <div id="purchaseReport" class="content-section">
        <!-- Content for Purchase Report -->
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
        <!-- Edit Modal -->
        <div class="modal fade" id="exampleModal6" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <form id="edit-purchase" action="/returnPurchase/" method="get">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
              <div class="modal-content bg-dark">
                <div class="modal-body">
                  <div>
                    <label for="purchase-id">ID:</label>
                    <input type="text" readonly id="purchase-id" value="">
                  </div>
                  <div>
                    <label for="purchase-name">Name:</label>
                    <input readonly type="text" name="name" id="purchase-name" value="">
                  </div>
                  <div>
                    <label for="purchase-phone">Phone number:</label>
                    <input readonly onkeypress="return event.charCode >= 48 && event.charCode <= 57" type="text" name="phoneNumber" id="purchase-phone" value="">
                  </div>
                  <div>
                    <label for="purchase-returned">Returned Amount:</label>
                    <input required onkeypress="return event.charCode >= 48 && event.charCode <= 57" type="text" name="returnedAmount" id="purchase-returned" value="">
                  </div>
                  <div>
                    <label for="purchase-returned-gold">Returned Gold(In grams):</label>
                    <input required onkeypress="return event.charCode >= 48 && event.charCode <= 57" type="text" name="returnedGold" id="purchase-returned-gold" value="">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-success">Update</button>
                </div>
              </div>
            </div>
          </form>
        </div>

        <h2>Purchase Report</h2>
        <div style="display: flex; justify-content: space-between; margin: 5px;">
          <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              {{request('payment_method') ?? 'All'}}
            </button>
            <ul class="dropdown-menu bg-dark">
              <li><a class="dropdown-item bg-dark text-white" href="/admin?page=1">All</a></li>
              <li><button class="dropdown-item bg-dark text-white" onclick="updateUrlParameter('payment_method', 'Cash')">Cash</button></li>
              <li><button class="dropdown-item bg-dark text-white" onclick="updateUrlParameter('payment_method', 'Bank')">Bank</button></li>
            </ul>
          </div>
          <button type="button" class="btn-default bg-dark" style="color: white;" onclick="printTable('purchaseReportsTable')">
            Print Table
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 15px; height: 15px;">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
            </svg>
          </button>
        </div>
        <div id="purchaseReportsTable" style="overflow-x: scroll;">
          <div style="text-align: center;" class="hide">
            <h4>Al Baraka Factory</h4>
            <h6>Purchase Report</h6>
          </div>
          <table class="basic">
            <thead>
              <tr>
                <th>No#</th>
                <th>Vender Name</th>
                <th>Phone number</th>
                <th>Purity</th>
                <th>Price</th>
                <th>Grams</th>
                <th>Conversion(21K)</th>
                <th>Tax</th>
                <th>Discount</th>
                <th>Total Price</th>
                <th>Payment Method</th>
                <th>Date of Purchase</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $TotalPurchaseAmount = 0;
              ?>
              @forelse ($purchases as $key=>$data)
              <?php
              if (!$data->returned) {
                $TotalPurchaseAmount += $data->total_price;
              }
              ?>
              <tr>
                <td>{{ ($key + 1) + ((request('page') - 1) * 10) }}</td>
                <td>{{$data->vendor_name}}</td>
                <td>
                  <a onclick="openPage('venderRecord')" href="/admin?page=1&search={{$data->vendor_phone}}">
                    {{$data->vendor_phone}}
                  </a>
                </td>
                <!-- <td>
                  <div class="text-wrapping">
                    Test
                  </div>
                </td> -->
                <td>{{$data->goldKarat}}</td>
                <td>{{$data->price}}</td>
                <td>{{$data->grams}}</td>
                <td>{{round(($data->goldKarat * $data->grams) / 21, 2)}}</td>
                <td>{{$data->Tax}}</td>
                <td>{{$data->Discount}}</td>
                <td>
                  @if ($data->returned)
                  <s>{{$data->total_price}}</s>
                  @else
                  {{$data->total_price}}
                  @endif
                </td>
                <td>{{$data->payment_method}}</td>
                <td>{{$data->created_at}}</td>
                <td>
                  <div>
                    <a href="/printInvoice/{{$data->uuid}}/purchase">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 15px; height: 15px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                      </svg>
                    </a>
                    <button onclick="setEditPurchase('{{$key}}', '{{$data->uuid}}')" class="btn" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal6" style="display: {{ $data->returned == 0 ? 'inline-block' : 'none' }};">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 15px; height: 15px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                      </svg>
                    </button>
                  </div>
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
                <td align="right">Total:</td>
                <td colspan="4">{{$TotalPurchaseAmount}}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <nav style="margin: 5px;" aria-label="Page navigation example">
          <div id="pagination-container" class="pagination-container" style="padding: 20px 0;">
            <?php echo $purchases->appends(request()->query())->links(); ?>
          </div>
        </nav>
      </div>

      <div id="salesReport" class="content-section">
        <!-- Content for Sales Report -->
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
        <!-- Edit Modal -->
        <div class="modal fade" id="exampleModal5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <form id="edit-sales" action="/" method="get">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
              <div class="modal-content bg-dark">
                <div class="modal-body">
                  <div>
                    <label for="sales-id">ID:</label>
                    <input type="text" readonly id="sales-id" value="">
                  </div>
                  <div>
                    <label for="sales-name">Name:</label>
                    <input readonly type="text" name="name" id="sales-name" value="">
                  </div>
                  <div>
                    <label for="sales-phone">Phone number:</label>
                    <input readonly onkeypress="return event.charCode >= 48 && event.charCode <= 57" type="text" name="phoneNumber" id="sales-phone" value="">
                  </div>
                  <div>
                    <label for="sales-returned">Returned Amount:</label>
                    <input required onkeypress="return event.charCode >= 48 && event.charCode <= 57" type="text" name="returnedAmount" id="sales-returned" value="">
                  </div>
                  <div>
                    <label for="sales-returned-gold">Returned Gold(In grams):</label>
                    <input required onkeypress="return event.charCode >= 48 && event.charCode <= 57" type="text" name="returnedGold" id="sales-returned-gold" value="">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-success">Update</button>
                </div>
              </div>
            </div>
          </form>
        </div>

        <h2>Sales Report</h2>
        <div style="display: flex; justify-content: space-between; margin: 5px;">
          <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              {{request('payment_method') ?? 'All'}}
            </button>
            <ul class="dropdown-menu bg-dark">
              <li><a class="dropdown-item bg-dark text-white" href="/admin?page=1">All</a></li>
              <li><button class="dropdown-item bg-dark text-white" onclick="updateUrlParameter('payment_method', 'Cash')">Cash</button></li>
              <li><button class="dropdown-item bg-dark text-white" onclick="updateUrlParameter('payment_method', 'Bank')">Bank</button></li>
            </ul>
          </div>
          <button type="button" class="btn-default bg-dark" style="color: white;" onclick="printTable('salesReportsTable')">
            Print Table
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 15px; height: 15px;">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
            </svg>
          </button>
        </div>
        <div id="salesReportsTable" style="overflow-x: scroll;">
          <div style="text-align: center;" class="hide">
            <h4>Al Baraka Factory</h4>
            <h6>Sales Report</h6>
          </div>
          <table class="basic">
            <thead>
              <tr>
                <th>No#</th>
                <th>Customer Name</th>
                <th>Phone number</th>
                <th>Salesman</th>
                <th>Gold Karat</th>
                <th>Price</th>
                <th>Grams</th>
                <th>Conversion(21K)</th>
                <th>Tax</th>
                <th>Total Price</th>
                <th>Payment Method</th>
                <th>Delivery Date</th>
                <th>Sale Date</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $totalSalesAmount = 0;
              ?>
              @forelse ($sales as $key=>$data)
              @if ($data->RemainingPayment < 0) @continue @endif <tr>
                <?php
                if (!$data->returned) {
                  $totalSalesAmount += $data->TotalPrice;
                }
                ?>
                <td>{{ ($key + 1) + ((request('page') - 1) * 10) }}</td>
                <td>{{$data->CustomerName}}</td>
                <td style="text-wrap: nowrap;">
                  <a onclick="openPage('customerRecord')" href="/admin?page=1&search={{$data->CustomerPhone}}">
                    {{$data->CustomerPhone}}
                  </a>
                </td>
                <!-- <td>
                  <div class="text-wrapping">
                    Test
                  </div>
                </td> -->
                <td>{{$data->Salesman}}</td>
                <td>{{$data->GoldKarat}}</td>
                <td>{{$data->Price}}</td>
                <td>{{$data->Grams}}</td>
                <td>{{round(($data->GoldKarat * $data->Grams) / 21, 2)}}</td>
                <td>{{$data->Tax}}</td>
                <td>
                  @if ($data->returned)
                  <s>{{$data->TotalPrice}}</s>
                  @else
                  {{$data->TotalPrice}}
                  @endif
                </td>
                <td>{{$data->payment_method}}</td>
                <td>{{$data->deliverydate}}</td>
                <td>{{$data->updated_at}}</td>
                <td>
                  <div class="d-flex">
                    <a href="/printInvoice/{{$data->uuid}}/sales">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 15px; height: 15px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                      </svg>
                    </a>
                    <button onclick="setEditSales('{{$key}}', '{{$data->uuid}}')" class="btn" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal5" style="display: {{ $data->returned == 0 ? 'inline-block' : 'none' }};">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 15px; height: 15px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                      </svg>
                    </button>
                  </div>
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
                  <td align="right">Total:</td>
                  <td colspan="6">{{$totalSalesAmount}}</td>
                </tr>
            </tbody>
          </table>
        </div>
        <nav style="margin: 5px;" aria-label="Page navigation example">
          <div id="pagination-container" class="pagination-3" style="padding: 20px 0;">
            <?php echo $sales->appends(request()->query())->links(); ?>
          </div>
        </nav>
      </div>

      <div id="otherReport" class="content-section">
        <!-- Content for Other Report -->
        <h2>Other Report</h2>
        <div style="display: flex; justify-content: space-between; margin: 5px;">
          <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              {{request('filter') ?? 'All'}}
            </button>
            <ul class="dropdown-menu bg-dark">
              <li><a class="dropdown-item bg-dark text-white" href="/admin?page=1">All</a></li>
              <li><a class="dropdown-item bg-dark text-white" href="/admin?page=1&filter=Other">Others</a></li>
              <li><a class="dropdown-item bg-dark text-white" href="/admin?page=1&filter=Salary">Salary</a></li>
            </ul>
          </div>
          <button type="button" class="btn-default bg-dark" style="color: white;" onclick="printTable('otherReportsTable')">
            Print Table
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 15px; height: 15px;">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
            </svg>
          </button>
        </div>
        <div id="otherReportsTable" style="overflow-x: scroll;">
          <div style="text-align: center;" class="hide">
            <h4>Al Baraka Factory</h4>
            <h6>Other Report</h6>
          </div>
          <table class="basic">
            <thead>
              <tr>
                <th>No#</th>
                <th>Title</th>
                <th>Price</th>
                <th>Description</th>
                <th>Type</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($otherExpanses as $key=>$data)
              <span style="display: none;">
                {{$TotalPrice+=$data->Price}}
              </span>
              <tr>
                <td>{{ ($key + 1) + ((request('page') - 1) * 10) }}</td>
                <td>{{$data->itemName}}</td>
                <td>{{$data->Price}}</td>
                <td>{{$data->description}}</td>
                <td>{{$data->type}}</td>
                <td>{{$data->created_at}}</td>
              </tr>
              @empty
              no data found
              @endforelse
              <tr>
                <td></td>
                <td align="right"><span style="color: #0080ff;">Total Price = </span></td>
                <td colspan="4">{{$TotalPrice}}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <nav style="margin: 5px;" aria-label="Page navigation example">
          <div id="pagination-container" class="pagination-2" style="padding: 20px 0;">
            <?php echo $otherExpanses->appends(request()->query())->links(); ?>
          </div>
        </nav>
      </div>

      <div id="customerRecord" class="content-section" style="display: block;">
        <h2>
          Customer Record
        </h2>
        <div style="display: flex; justify-content: space-between; margin: 5px;">
          <div class="dropdown d-flex" style="align-items: center;">
            <div class="form-floating" style="width: 300px;">
              <input required type="search" class="form-control bg-transparent text-white" id="searchItem" placeholder="Search">
              <label for="searchItem">Search</label>
            </div>
            <button type="button" onclick="document.getElementById('searchItem').value && updateUrlParameter('search',document.getElementById('searchItem').value)" class="btn">
              <ion-icon class="btn text-white" name="search-outline"></ion-icon>
            </button>
          </div>
          <button type="button" class="btn-default bg-dark" style="color: white;" onclick="printTable('customerRecordTable')">
            Print Table
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 15px; height: 15px;">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
            </svg>
          </button>
        </div>
        <div id="customerRecordTable" style="overflow-x: scroll;">
          <div style="text-align: center;" class="hide">
            <h4>Al Baraka Factory</h4>
            <h6>Other Report</h6>
          </div>
          <table class="basic">
            <thead>
              <tr>
                <th>No#</th>
                <th>Customer Name</th>
                <th>Customer Phone</th>
                <th>Total Sales</th>
                <th>Total Returned</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @forelse ($customers as $key=>$data)
              <tr>
                <td>{{ ($key + 1) + ((request('page') - 1) * 10) }}</td>
                <td>{{$data->customerName}}</td>
                <td>{{$data->customerPhone}}</td>
                <td>{{$data->totalSales}}</td>
                <td>{{$data->totalReturned}}</td>
                <td>
                  <a onclick="openPage('salesReport')" href="/admin?page=1&search={{$data->customerPhone}}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 15px; height: 15px;">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3.75H6A2.25 2.25 0 0 0 3.75 6v1.5M16.5 3.75H18A2.25 2.25 0 0 1 20.25 6v1.5m0 9V18A2.25 2.25 0 0 1 18 20.25h-1.5m-9 0H6A2.25 2.25 0 0 1 3.75 18v-1.5M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                  </a>
                </td>
              </tr>
              @empty
              no data found
              @endforelse
            </tbody>
          </table>
        </div>
        <nav style="margin: 5px;" aria-label="Page navigation example">
          <div id="pagination-container" class="pagination-2c" style="padding: 20px 0;">
            <?php echo $customers->appends(request()->query())->links(); ?>
          </div>
        </nav>
      </div>

      <div id="ledger" class="content-section" style="display: block;">
        <h2>
          Ledger
        </h2>
        <div style="display: flex; justify-content: space-between; margin: 5px;">
          <div class="dropdown d-flex" style="align-items: center;">
            <div class="form-floating" style="width: 300px;">
              <input required type="search" class="form-control bg-transparent text-white" id="searchItemL" placeholder="Search">
              <label for="searchItemL">Search</label>
            </div>
            <button type="button" onclick="document.getElementById('searchItemL').value && updateUrlParameter('search',document.getElementById('searchItemL').value)" class="btn">
              <ion-icon class="btn text-white" name="search-outline"></ion-icon>
            </button>
          </div>
          <button type="button" class="btn-default bg-dark" style="color: white;" onclick="printTable('customerRecordTable')">
            Print Table
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 15px; height: 15px;">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
            </svg>
          </button>
        </div>
        <div id="customerRecordTable" style="overflow-x: scroll;">
          <div style="text-align: center;" class="hide">
            <h4>Al Baraka Factory</h4>
            <h6>Other Report</h6>
          </div>
          <table class="basic">
            <thead style="text-align: center;">
              <tr>
                <th>No#</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Sales Amount</th>
                <th>Purchase Amount</th>
                <th>Return Amount</th>
                <th>Remaining Amount</th>
                <th>Gold Karat</th>
                <th>Grams</th>
                <th>Conversion</th>
                <th>Tax</th>
                <th>Discount</th>
                <th>Total Price</th>
                <th>Delivery Date</th>
                <th>Date</th>
                <th></th>
              </tr>
            </thead>
            <tbody align="center">
              @forelse ($ledger as $key=>$data)
              <tr>
                <td>{{ ($key + 1) + ((request('page') - 1) * 10) }}</td>
                <td>{{$data->name}}</td>
                <td>{{$data->phone}}</td>
                <td>{{$data->salesAmount}}</td>
                <td>{{$data->purchaseAmount}}</td>
                <td>{{$data->returnAmount}}</td>
                <td>{{$data->remainingAmount}}</td>
                <td>{{$data->goldKarat}}</td>
                <td>{{$data->grams}}</td>
                <td>{{round(($data->goldKarat * $data->grams) / 21, 2)}}</td>
                <td>{{$data->Tax}}</td>
                <td>{{$data->Discount}}</td>
                <td>{{$data->TotalPrice}}</td>
                <td>{{$data->deliverydate}}</td>
                <td>{{$data->created_at}}</td>
              </tr>
              @empty
              no data found
              @endforelse
            </tbody>
          </table>
        </div>
        <nav style="margin: 5px;" aria-label="Page navigation example">
          <div id="pagination-container" class="pagination-2l" style="padding: 20px 0;">
            <?php echo $ledger->appends(request()->query())->links(); ?>
          </div>
        </nav>
      </div>

      <div id="venderRecord" class="content-section" style="display: block;">
        <h2>
          Vender Record
        </h2>
        <div style="display: flex; justify-content: space-between; margin: 5px;">
          <div class="dropdown d-flex" style="align-items: center;">
            <div class="form-floating" style="width: 300px;">
              <input required type="search" class="form-control bg-transparent text-white" id="searchItemV" placeholder="Search">
              <label for="searchItemV">Search</label>
            </div>
            <button type="button" onclick="document.getElementById('searchItemV').value && updateUrlParameter('search',document.getElementById('searchItemV').value)" class="btn">
              <ion-icon class="btn text-white" name="search-outline"></ion-icon>
            </button>
          </div>
          <button type="button" class="btn-default bg-dark" style="color: white;" onclick="printTable('customerRecordTable')">
            Print Table
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 15px; height: 15px;">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
            </svg>
          </button>
        </div>
        <div id="customerRecordTable" style="overflow-x: scroll;">
          <div style="text-align: center;" class="hide">
            <h4>Al Baraka Factory</h4>
            <h6>Other Report</h6>
          </div>
          <table class="basic">
            <thead>
              <tr>
                <th>No#</th>
                <th>Vender Name</th>
                <th>Vender Phone</th>
                <th>Total Purchases Amount</th>
                <th>Total Purchase Grams</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @forelse ($venders as $key=>$data)
              <tr>
                <td>{{ ($key + 1) + ((request('page') - 1) * 10) }}</td>
                <td>{{$data->venderName}}</td>
                <td>{{$data->venderPhone}}</td>
                <td>{{$data->totalPurchasesAmount}}</td>
                <td>{{$data->totalPurchasesGrams}}</td>
                <td>
                  <a onclick="openPage('purchaseReport')" href="/admin?page=1&search={{$data->venderPhone}}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 15px; height: 15px;">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3.75H6A2.25 2.25 0 0 0 3.75 6v1.5M16.5 3.75H18A2.25 2.25 0 0 1 20.25 6v1.5m0 9V18A2.25 2.25 0 0 1 18 20.25h-1.5m-9 0H6A2.25 2.25 0 0 1 3.75 18v-1.5M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                  </a>
                </td>
              </tr>
              @empty
              no data found
              @endforelse
            </tbody>
          </table>
        </div>
        <nav style="margin: 5px;" aria-label="Page navigation example">
          <div id="pagination-container" class="pagination-2v" style="padding: 20px 0;">
            <?php echo $venders->appends(request()->query())->links(); ?>
          </div>
        </nav>
      </div>

      <div id="welcome" class="content-section" style="display: block;">
        <h1 style="text-align: center;">Welcome to the Admin Panel</h1>
        <h3>
          Inventory Record:
        </h3>
        <div class="record-box">
          <span>Storage Left: </span>
          <span>{{$storedGrams}} Grams</span>
          <span>Total Purchase:</span>
          <span>{{$TotalPurchaseGrams}} Grams</span>
          <span>Total Sales:</span>
          <span>{{$totalSalesGrams}} Grams</span>
          <span>Total Purchase Amount:</span>
          <span>{{$TotalPurchaseAmount}}</span>
          <span>Total Sales Amount:</span>
          <span>{{$TotalSalesAmount}}</span>
        </div>
      </div>
    </div>
  </div>
  <?php
  // Assuming $salesman is coming from compact
  $salesmanData = json_encode($salesman);
  $salesData = json_encode($pendingSales);
  $sales = json_encode($sales);
  $purchase = json_encode($purchases);
  ?>
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

      var navTag2l = document.querySelector(".pagination-2l > nav");
      if (navTag2l) {
        navTag2l.className = "pagination pagination-sm justify-content-end";
        var anchorTags2l = document.querySelectorAll(".pagination-2l > nav > a");
        var spanTags2l = document.querySelectorAll(".pagination-2l > nav > span");

        // Loop through each 'a' tag and remove all classes
        anchorTags2l.forEach(function(tag) {
          tag.className = "page-item page-link bg-dark";
        });
        spanTags2l.forEach(function(tag) {
          tag.className = "page-item page-link bg-dark";
        });
      }

      var navTag2x = document.querySelector(".pagination-2x > nav");
      if (navTag2x) {
        navTag2x.className = "pagination pagination-sm justify-content-end";
        var anchorTags2x = document.querySelectorAll(".pagination-2x > nav > a");
        var spanTags2x = document.querySelectorAll(".pagination-2x > nav > span");

        // Loop through each 'a' tag and remove all classes
        anchorTags2x.forEach(function(tag) {
          tag.className = "page-item page-link bg-dark";
        });
        spanTags2x.forEach(function(tag) {
          tag.className = "page-item page-link bg-dark";
        });
      }

      var navTag2c = document.querySelector(".pagination-2c > nav");
      if (navTag2c) {
        navTag2c.className = "pagination pagination-sm justify-content-end";
        var anchorTags2c = document.querySelectorAll(".pagination-2c > nav > a");
        var spanTags2c = document.querySelectorAll(".pagination-2c > nav > span");

        // Loop through each 'a' tag and remove all classes
        anchorTags2c.forEach(function(tag) {
          tag.className = "page-item page-link bg-dark";
        });
        spanTags2c.forEach(function(tag) {
          tag.className = "page-item page-link bg-dark";
        });
      }

      var navTag2 = document.querySelector(".pagination-2 > nav");
      if (navTag2) {
        navTag2.className = "pagination pagination-sm justify-content-end";
        var anchorTags2 = document.querySelectorAll(".pagination-2 > nav > a");
        var spanTags2 = document.querySelectorAll(".pagination-2 > nav > span");

        // Loop through each 'a' tag and remove all classes
        anchorTags2.forEach(function(tag) {
          tag.className = "page-item page-link bg-dark";
        });
        spanTags2.forEach(function(tag) {
          tag.className = "page-item page-link bg-dark";
        });
      }

      var navTag3 = document.querySelector(".pagination-3 > nav");
      if (navTag3) {
        navTag3.className = "pagination pagination-sm justify-content-end";
        var anchorTags3 = document.querySelectorAll(".pagination-3 > nav > a");
        var spanTags3 = document.querySelectorAll(".pagination-3 > nav > span");

        // Loop through each 'a' tag and remove all classes
        anchorTags3.forEach(function(tag) {
          tag.className = "page-item page-link bg-dark";
        });
        spanTags3.forEach(function(tag) {
          tag.className = "page-item page-link bg-dark";
        });
      }

      var navTag4 = document.querySelector(".pagination-4 > nav");
      if (navTag4) {
        navTag4.className = "pagination pagination-sm justify-content-end";
        var anchorTags4 = document.querySelectorAll(".pagination-4 > nav > a");
        var spanTags4 = document.querySelectorAll(".pagination-4 > nav > span");

        // Loop through each 'a' tag and remove all classes
        anchorTags4.forEach(function(tag) {
          tag.className = "page-item page-link bg-dark";
        });
        spanTags4.forEach(function(tag) {
          tag.className = "page-item page-link bg-dark";
        });
      }
    });
    // Use PHP to embed the JSON data into JavaScript
    var salesmanData = <?php echo $salesmanData; ?>;
    var salesData = <?php echo $salesData; ?>;
    var sales = <?php echo $sales; ?>;
    var purchase = <?php echo $purchase; ?>;
  </script>
  <script>
    // function submitSearch() {
    //   var currentURL = window.location.href;
    //   var searchItem = document.getElementById('searchItem').value;

    //   if (searchItem) {
    //     // Remove existing startTime and endTime parameters from the URL
    //     var urlWithoutParams = currentURL.replace(/[?&]search=[^&]*(&|$)/g, '');

    //     // Check if there are existing parameters in the modified URL
    //     var separator = urlWithoutParams.includes('?') ? '&' : '?';

    //     // Append the new values to the modified URL
    //     var newURL = urlWithoutParams + separator + 'search=' + searchItem;

    //     // Redirect to the new URL
    //     window.location.href = newURL;
    //   }
    // }

    function submitForm() {
      // Get the values from the date inputs
      var startTime = document.getElementById('startTime').value;
      var endTime = document.getElementById('endTime').value;

      if (startTime && endTime) {
        // Get the current URL
        var currentURL = window.location.href;

        // Remove existing startTime and endTime parameters from the URL
        var urlWithoutParams = currentURL.replace(/[?&]startTime=.*?(?=&|$)|[?&]endTime=.*?(?=&|$)/g, '');

        // Check if there are existing parameters in the modified URL
        var separator = urlWithoutParams.includes('?') ? '&' : '?';

        // Append the new values to the modified URL
        var newURL = urlWithoutParams + separator + 'startTime=' + startTime + '&endTime=' + endTime;

        // Redirect to the new URL
        window.location.href = newURL;
      }
    }

    function setEditPurchase(index, purchaseId) {
      document.getElementById('edit-purchase').action = `/returnPurchase/${purchaseId}`;

      document.getElementById('purchase-id').value = purchase.data[index].uuid;
      document.getElementById('purchase-name').value = purchase.data[index].vendor_name;
      document.getElementById('purchase-phone').value = purchase.data[index].vendor_phone;
      document.getElementById('purchase-returned').placeholder = purchase.data[index].total_price;
      document.getElementById('purchase-returned-gold').placeholder = purchase.data[index].grams;
    }

    function setEditSales(index, salesId) {
      document.getElementById('edit-sales').action = `/return/${salesId}`;

      document.getElementById('sales-id').value = sales.data[index].uuid;
      document.getElementById('sales-name').value = sales.data[index].CustomerName;
      document.getElementById('sales-phone').value = sales.data[index].CustomerPhone;
      document.getElementById('sales-returned').placeholder = sales.data[index].TotalPrice;
      document.getElementById('sales-returned-gold').placeholder = sales.data[index].Grams;
    }

    function setEditIndex(index, salesmanId) {
      document.getElementById('edit-form').action = `/edit/${salesmanId}`;
      document.getElementById('reset-btn').href = `resetPassword/${salesmanId}`;

      document.getElementById('ed-id').value = salesmanData.data[index].id;
      document.getElementById('ed-name').value = salesmanData.data[index].name;
      document.getElementById('ed-phone').value = salesmanData.data[index].phoneNumber;
      // document.getElementById('ed-password').value = salesmanData.data[index].password;
      document.getElementById('ed-salary').value = salesmanData.data[index].salary;
      document.getElementById('ed-privilege').value = salesmanData.data[index].privilege;
      document.getElementById('ed-salary-paid-date').value = salesmanData.data[index].salarypaiddate;
      document.getElementById('ed-created-at').value = salesmanData.data[index].created_at;
      document.getElementById('ed-updated-at').value = salesmanData.data[index].updated_at;
    }

    function setEditSalesIndex(index, salesId) {
      document.getElementById('edit-pending-form').action = `/editsales/${salesId}`;

      document.getElementById('ed-pending-id').value = salesData.data[index].id;
      document.getElementById('ed-pending-name').value = salesData.data[index].CustomerName;
      document.getElementById('ed-pending-phone').value = salesData.data[index].CustomerPhone;
      document.getElementById('ed-pending-downpayment').value = salesData.data[index].DownPayment;
      document.getElementById('ed-pending-remaining').value = salesData.data[index].RemainingPayment;
    }

    function updateUrlParameter(variable, value) {
      // Get the current URL
      var currentUrl = window.location.href;

      // Create a URL object
      var url = new URL(currentUrl);

      // Check if the variable exists in the URL parameters
      if (url.searchParams.has(variable)) {
        // Update the existing value
        url.searchParams.set(variable, value);
      } else {
        // Add the variable and its value to the URL
        url.searchParams.append(variable, value);
      }

      // Replace the current URL with the updated URL
      window.history.replaceState({}, document.title, url.toString());
      openUrl(url.toString());
    }

    function openUrl(url) {
      window.open(url, '_self');
    }
  </script>
  <script src="{{ asset('Logics/AdminPanel.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>