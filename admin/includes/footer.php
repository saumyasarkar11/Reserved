<footer class="footer">
  <div
    class="
      d-sm-flex
      justify-content-center justify-content-sm-between
    "
  >
    <span
      class="
        text-muted
        d-block
        text-center text-sm-left
        d-sm-inline-block
      "
      >Copyright© Techworth Technologies Pvt. Ltd. | Technical Support: support@techworth.in</span
    >
    <span
      class="
        float-none float-sm-right
        d-block
        mt-1 mt-sm-0
        text-center
      "
    >                
      <a href="https://www.techworth.in/" target="_blank"     >www.techworth.in</a></span>

  </div>
</footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="vendors/base/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/template.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <!-- End custom js for this page-->
  </body>
</html>

<script>
  $(document).ready(function() {
    var pathname = window.location.pathname;
    var name = pathname.replace('/hotel/admin/', '');
    const urlParams = new URLSearchParams(window.location.search);
    if(name == "bookings.php" && urlParams == "1="){
        $('#book2').removeClass("active");
        $('#book3').removeClass("active");   
        $('#book4').removeClass("active"); 
        $('#book5').removeClass("active"); 
    }
    if(name == "bookings.php" && urlParams == "2="){
        $('#book1').removeClass("active");
        $('#book3').removeClass("active");
        $('#book4').removeClass("active"); 
        $('#book5').removeClass("active"); 
    }
    if(name == "bookings.php" && urlParams == "3="){
        $('#book1').removeClass("active");
        $('#book2').removeClass("active");
        $('#book4').removeClass("active"); 
        $('#book5').removeClass("active"); 
    }
    if(name == "bookings.php" && urlParams == "4="){
        $('#book1').removeClass("active");
        $('#book2').removeClass("active");
        $('#book3').removeClass("active"); 
        $('#book5').removeClass("active"); 
    }
    if(name == "bookings.php" && urlParams == "5="){
        $('#book1').removeClass("active");
        $('#book2').removeClass("active");
        $('#book3').removeClass("active");
        $('#book4').removeClass("active"); 
    }
       

    $('#dataTable').DataTable( {
        "order": [[ 0, "desc" ]],
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
    });    
  });

  $('#dataTable2').DataTable( {
        "order": [[ 1, "asc" ]],
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
    });
    
    $('#dataTable3').DataTable( {
        "order": [[ 1, "asc" ]],
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
        "columnDefs": [ {
            targets: [ 1 ],
            orderData: [ 1, 5 ]
        }, {
            targets: [ 5 ],
            orderData: [ 5, 1 ]
        }]
    });
    
    

  $('#location-select').change(function(){
   const loc = $(this).val();
   $('#dataTable1').DataTable().destroy();
   $('#content').empty();
   $.ajax({
     url: "includes/ajax.php",
     method: "POST",
     data: {loc: loc},
     success:function(data){
       $('#property-select').html(data);       
     }
   })    
 })
 
 $('.location_name').blur(function(){
   $.ajax({
     url: "includes/ajax.php",
     method: "POST",
     data: {loc_id: $(this).attr("data-id"), loc_name: $(this).text()},
     success:function(data){
       alert(data);       
     }
   })    
 })
  $('.sequence').blur(function(){
   $.ajax({
     url: "includes/ajax.php",
     method: "POST",
     data: {room_id: $(this).attr("data-id"), sq: $(this).text()},
    //  success:function(data){
    //   alert(data);       
    //  }
   })    
 })
 
 $("[name='changeDate']").click(function(){
     if(confirm("Are you sure you want to change the booking dates?")){
         return true;
     } else {
         return false;
     }
 })


 $(document).on('change', '#property-select', function(){
     const prop = $(this).val();
     var urlParams = new URLSearchParams(window.location.search);
     var param;
     if(urlParams == "1="){
       param = 1;
     } else if(urlParams == "2="){
       param = 2;
     } else if(urlParams == "3="){
       param = 3;
     } else {
       param = 4;
     }
     $('#dataTable1').DataTable( {
         "order": [[ 6, "desc" ]],
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
        "ajax": {
          "url": "includes/ajax.php",
          "type": "POST",
          "dataSrc": "",
          "data": {
            "prop": prop,
            "param": param
          },          
        },
        "columns": [
            {"data":"time"},
            {"data":"reservation_number"},
            {"data":"name"},
            {"data":"phone"},
            {"data":"email"},
            {"data":"check_in"},
            {"data":"check_out"},
            {"data":"amount"},
            {"data":"payment_id"},
        ]
     });
 })

 $('.statusUpdate').change(function(){
    const id = $(this).attr("data-id");
    const statusVal = $(this).val();
    $.ajax({
     url: "includes/ajax.php",
     method: "POST",
     data: {id: id, statusVal: statusVal},
     success:function(data){
       alert(data);      
     }
   })
 })  

 $('#bookRoom').click(function(){
    $.ajax({
     url: "includes/ajax.php",
     method: "POST",
     data: {bookRoom:1}
   })
 })

 $('#status').change(function(){   
   if($(this).val() == "Cancelled"){
     $('#note').show();
     $('#noteText').attr("required", true);
   } else {
     $('#note').hide();
     $('#noteText').attr("required", false);
     $('#noteText').val("");
   }
 })  

 $("[name='updateBooking']").click(function(){
   if($('#status').val() == "Cancelled"){
       if(confirm("Are you sure you want to cancel the booking?")){
         return true;
       } else {
         return false;
       }
   } else {
       return true;
   }
 })
</script>