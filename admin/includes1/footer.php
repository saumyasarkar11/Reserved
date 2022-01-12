    <!-- Modal -->
    <div class="modal fade" id="descModal" tabindex="-1" aria-labelledby="descModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalHead"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="modalBody"></div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Hotel Login</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Phone</label>
              <input type="text" class="form-control" id="login_phone" maxlength="10" minlength="10">
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" class="form-control" id="password">
            </div>
            <div class="mb-3" id="login_msg"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            <button type="button" id="login_main" class="btn btn-primary">Login</button>
          </div>
        </div>
      </div>
    </div>

    <footer>
      Copyright&copy; 2021 <?php echo fetchConfig(2); ?>. Designed and Hosted by <a href="https://techworth.in">Techworth</a>
    </footer> 
  </body>
</html>
<script src="../assets/bootstrap/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script> 

 function toDate(date) {
  day = date.getDate();
  month = date.getMonth() + 1;
  year = date.getFullYear();
  return [date, month, year].join('/');
 }

 $('#location-select').change(function(){
  var date = new Date();
  var min = new Date(date. setDate(date. getDate())).toISOString().split('T')[0];   
   Object.assign(document.getElementById("check-in"), {'min': min});
   const loc = $(this).val();
   $.ajax({
     url: "includes1/ajax.php",
     method: "POST",
     data: {loc: loc},
     success:function(data){
       $('#property-select').html(data);       
     }
   })   
   $('#loc').val(loc);
 })

 $(document).bind('change', '#property-select', function(){
   const prop = $(this).val();   
   $('#filters').show();
 })

 $('#check-in').change(function(){
  var date = new Date($(this).val());
  var date1 = new Date($(this).val());
  var max = new Date(date. setDate(date. getDate() + 7)).toISOString().split('T')[0];
  var tomorrow = new Date(date1. setDate(date1. getDate() + 1)).toISOString().split('T')[0];
  var chkout = document.getElementsByName("check-out")[0];
  Object.assign(chkout, {'max': max, 'min': tomorrow});
 })

 $('#check_avail').click(function(){
   const chkin = $('#check-in').val();
   $('#prop').val($('#property-select').val());
   const chkout = $('#check-out').val();
   const rooms = $('#no-rooms').val();
   const prop = $('#property-select').val();
   if(chkout <= chkin){
      alert("Check Out should be at a date later than check in");
   } else if (rooms == "") {
      alert("Please select no. of rooms");
   } else {
      $('#loader').show();
      $.ajax({
        url: "includes1/ajax.php",
        method: "POST",
        data: {prop, chkin, chkout, rooms},
        success:function(data){
          $('#proceed-btn').show();
          $('#loader').hide();
          $('#property-info').html(data);
        }
      })     
   }    
 })

 $(document).on('change', '.room_numbers', function(){
  var sum = 0;
  var flag = 0;
  const total = $('#no-rooms').val();
  const dataId = $(this).attr("data-id");
  $("[data-id='"+dataId+"']").each(function(){
    var temp = sum + +$(this).val();
      if(temp > total){
        flag = 1;              
      } else {
        sum += +$(this).val();        
      }
  })
  if(flag == 1){
    var dateAr = dataId.split('-');
    var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0];
    alert("Room selection for "+newDate+" exceeds the required number of rooms");
    $(this)[0].selectedIndex = 0;
    return false;
  }  
  $("[name = '"+dataId+"']").val(sum);
 }) 

 $('#proceed').click(function(){
  var chkin = new Date($('#check-in').val());
  var chkout = new Date($('#check-out').val());
  const rooms = $('#no-rooms').val();
  var arr = [];
  
  while(chkin < chkout){
    chkin.getDate() < 10 ? day = "" + 0 + chkin.getDate() : day = chkin.getDate();
    month = chkin.getMonth() + 1;
    year = chkin.getFullYear();
    new1 = [year, month, day].join('-');
    new2 = [day, month, year].join('-');    

    if($("[name='"+new1+"']").val() != rooms){
      alert("Room selection for "+new2+" is not equal the required number of rooms"); 
      return false;     
    }   

    chkin.setDate(chkin.getDate() + 1);
  }
  
  $(".room_numbers").each(function(){
    var str = $(this).attr("data-id")+"?"+$(this).attr("data-room")+"?"+$(this).val();
    arr.push(str);
  })
  
  $.ajax({
    url: "includes1/ajax.php",
    method: "POST",
    data: {arr, chk_in:$('#check-in').val(), chk_out:$('#check-out').val(), prop:$('#prop').val()}
  })
 })

 $('#proceed').click(function(){
   flag = 1;
   $.ajax({
     url: "includes1/ajax.php",
     method: "POST",
     data: {checkAvailFinal:1},
     success:function(data){
      flag = data;
     }
   })
   if(flag == 0){
     alert("The room you were booking is no longer available. Please choose a different room. Returning to the main page...");
     return false;
   }
 })

 $(document).on('click', '.rm_desc', function(){
   $('#modalHead').html($(this).attr("data-id"));
   $('#modalBody').html($(this).attr("data-body"));
 })

  $(document).ready(function(){
    if($(window).width()<500){
      $('.header-logo1').attr("src", "../assets/images/logo.jpg");
      $('#btn-txt').text("Login");
    }
    if($(window).width()>500){
      $('.header-logo1').attr("src", "../assets/images/logo1.jpg");
      $('#btn-txt').text("Hotel Login");
    }    
  });

  $(window).resize(function(){
    if($(window).width()<500){
      $('.header-logo1').attr("src", "../assets/images/logo.jpg");
      $('#btn-txt').text("Login");
    }
    if($(window).width()>500){
      $('.header-logo1').attr("src", "../assets/images/logo1.jpg");
      $('#btn-txt').text("Hotel Login");
    } 
  })

  $('#login_main').click(function(){
    var phone = $('#login_phone').val();
    var password = $('#password').val();

    if(phone == "" || password == ""){
      alert("Please enter both phone and password to login");
    } else {
      $.ajax({
        url: "includes1/ajax.php",
        method: "POST",
        data: {phone:phone, password:password},
        success:function(data){
          $('#login_msg').html(data);
          setTimeout(function () {
            $("#loginModal").modal("toggle");
          }, 500);
          if(data == "Login Successful!"){
            $('#login-btn').hide();
            $('#paid').removeAttr("readonly");
            $('#logout-btn').show();
          }
        }
      })
    }
  })

  $('#logout-btn').click(function(){
    if(confirm("Are you sure you want to logout?")){
      $.ajax({
        url: "includes1/ajax.php",
        method: "POST",
        data: {logout:1},
        success:function(data){
          $('#login-btn').show();
          $('#paid').attr("readonly");
          $('#logout-btn').hide();
        }
      })
    }    
  })

  $('#py_id').keyup(function(){
    $('#pay_id').val($(this).val());
  })

</script>
