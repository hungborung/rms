<!DOCTYPE html>
<html lang="en">
<head>
  <title>RMS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="public/assets/js/wallet.js"></script>
  <script src="public/assets/js/transaction.js"></script>
</head>
<body>
    <div class="container">
      <div class="row">
          <div class="col-lg-12" style="text-align: center; margin-top: 3em;">
            <a type="button" class="btn btn-default" onclick="return window.location.reload();">Refresh latest</a>
          </div>
      </div>
      <div class="row">
        <h2 style="text-align: center;">Wallet</h2>
        <div class="col-lg-3">
          <h3>Create</h3>
          <form method="post" id="createWalletForm">
            <div class="form-group">
              <label for="email">Name:</label>
              <input type="text" class="form-control name" id="name" placeholder="Enter name" name="name">
            </div>
            <div class="form-group">
              <label for="pwd">Hash key:</label>
              <input type="text" class="form-control hash_key" id="hash_key" placeholder="Enter hash key" name="hash_key">
            </div>
            <button type="button" class="btn btn-default" id="createWallet">Create</button>
          </form>
        </div>
        <div class="col-lg-6">
          <h3>List</h3>
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>HASH KEY</th>
              </tr>
            </thead>
            <tbody id="wallets_table"></tbody>
          </table>
        </div>
        
        <div class="col-lg-3">
          <h3>Delete</h3>
          <form method="delete" id="DeleteWalletForm">
            <div class="form-group">
              <label for="email">Name:</label>
              <input type="text" class="form-control name" id="nameDelete" placeholder="Enter name" name="name">
            </div>
            <div class="form-group">
              <label for="pwd">Hash key:</label>
              <input type="text" class="form-control hash_key" id="keyDelete" placeholder="Enter hash key" name="hash_key">
            </div>
            <button type="button" class="btn btn-default" id="DeleteWallet">Delete</button>
          </form>
        </div>
      </div>
        <hr/>
      <div class="row">
        <h2 style="text-align: center;">Transactions</h2>
        <div class="col-lg-3">
          <h3>Create</h3>
          <form method="post" action="Request.php?type=CreateTransaction" id="CreateTransactionForm">
            <div class="form-group">
              <label for="email">Name:</label>
              <input type="text" class="form-control" id="nameTransaction" placeholder="Enter name" name="name">
            </div>
            <div class="form-group">
              <label for="pwd">Type:</label>
                <select class="form-control" name="type" id="type">
                    <option>BET</option>
                    <option>WIN</option>
                </select>
            </div>
            <div class="form-group">
              <label for="pwd">Amount:</label>
              <input type="text" class="form-control" id="amount" placeholder="Enter amount" name="amount">
            </div>
            <div class="form-group">
              <label for="pwd">Reference:</label>
              <input type="text" class="form-control" id="reference" placeholder="Enter reference" name="reference">
            </div>
            <button type="button" class="btn btn-default" id="CreateTransaction">Create</button>
          </form>
        </div>
        <div class="col-lg-9">
          <h3>List</h3>
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>WALLET ID</th>
                <th>TYPE</th>
                <th>AMOUNT</th>
                <th>REFERENCE</th>
                <th>TIMESTAMP</th>
              </tr>
            </thead>
            <tbody id="transactions_table"></tbody>
          </table>
        </div>
      </div>
    </div>
    <script>
        $(document).ready(function () {
            getWallets();
            getTransactions();
        })

    </script>
</body>
</html>
