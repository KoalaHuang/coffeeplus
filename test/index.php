<!doctype html>
<html lang="en">
  <head>

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/bootstrap.min.js"></script>
    <script src="test.js"></script>
  </head>

  <body>
  	<? include "../navbar.php" ?>
    <h1 class="text-center">TEST</h1>
    <div class="container-fluid">

      <div class="col">my message:&nbsp<span id="msg"></span></div>
      <div class="col">server message:&nbsp<span id="srv_msg"></span></div>
      <p></p>
      <p></p>
      <label for="stockRange1" class="form-label col-2">Example range</label>
      <div class="col-10">
      <input type="range" class="form-range col-sm-10" min="0" max="5" step="1" id="stockRange1" onchange="f_test2('stockRange1')">
      </div>
      <p></p>
      <label for="stockRange2" class="form-label">Example range</label>
      <input type="range" class="form-range" min="0" max="5" step="1" id="stockRange2" onchange="f_test2('stockRange2')">
      <p></p>
      <p></p>
      <button type="button" class="btn btn-primary" onclick="f_test2()">TEST</button>

      <!-- Button trigger modal
      <button type="button" id="btn_launch" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#RequestModal">
        Launch demo modal
      </button>-->

      <!-- Modal 1-->
      <div class="modal fade" id="RequestModal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="RequestModalLabel">test</h5>
            </div>
            <div class="modal-body" id="modal_text">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary" id="btn_close" onclick="f_test()">OK</button>
            </div>
          </div>
        </div>
      </div>

    </div> <!-- container -->

  <div class="container-fluid">
    <div class="mb-3 row">
      <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
      <div class="col-sm-10">
        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="email@example.com">
      </div>
    </div>
    <div class="mb-3 row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
      <div class="col-sm-10">
        <input type="password" class="form-control" id="inputPassword">
      </div>
    </div>
  </div>


  </body>
</html>
