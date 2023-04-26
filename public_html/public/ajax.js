$(document).ready(function(){
    
  $("#overlay").css("opacity", "0");
  setTimeout(function() {
    $("#overlay").css("display", "none");
  }, 2000);

  category_detail();
  $("#neworder_category").change(function(){
    category_detail();
  });
  
  
  $("#neworder_services").change(function(){
    service_detail();
  });
  $("#payment_method").change(function(){
    addfunds_form();
  });

  $(document).on('keyup', '#order_quantity', function() {
    var service   = $("#neworder_services").val();
    var quantity  = $("#neworder_quantity").val();
    var charge  = $("#charge_default").val();
    var runs      = $("#dripfeed-runs").val();
      if( $("#dripfeedcheckbox").prop('checked') ){
        var dripfeed  = "var";
      }else{
        var dripfeed  = "bos";
      }
    var calculated_charge = charge*quantity/1000;
    $("#charge").val(calculated_charge);
  });
  $(document).on('keyup', '#dripfeed-runs', function() {
    var service   = $("#neworder_services").val();
    var quantity  = $("#neworder_quantity").val();
    var runs      = $("#dripfeed-runs").val();
      if( $("#dripfeedcheckbox").prop('checked') ){
        var dripfeed  = "var";
      }else{
        var dripfeed  = "bos";
      }
    $.post('ajax_data',{action:'service_price',service:service,quantity:quantity,dripfeed:dripfeed,runs:runs}, function(data){
        $("#charge").val(data.price);
        $("#dripfeed-totalquantity").val(data.totalQuantity);
    }, 'json');
  });
  $(document).on('keyup', '#neworder_comment', function() {
    comment_charge();
  });

  $(document).on('change', '#dripfeedcheckbox', function() {
    var dripfeed = $(this).prop('checked');
    if( dripfeed ){
      $("#dripfeed-options").removeClass();
      dripfeed_charge();
    }else{
      $("#dripfeed-options").addClass('hidden');
      dripfeed_charge();
    }
  });
  /* Dripfeed değiştir */
});

function category_detail(){
    var category_now = $("#neworder_category").val();
    var results = [];
    findAllCategoryChildren(category_now, results);
    results.map(function(element) {
        var services;
        if(element.length !== 0){
            for (var e in element) {
                    services += '<option value="'+element[e].service_id+'">'+element[e].service_name+' - '+element[e].currency_symbol+element[e].service_price+'</option>';
            }
        }else{
            services = '<option>Service not found in this category</option>';
        }
         $('#neworder_services').html(services);
         service_detail();
         return services;
    });
}

function service_detail(){
  $("#neworder_fields").html("");
  var service_now = $("#neworder_services").val();
  var results = [];
  findAllServicesData(service_now, results);
    
        $("#charge_div").show();
        $("#neworder_fields").html(results[0].service_details);
        $("#charge_default").val(results[0].service_price);
        $("#charge").val(results[0].service_price);
        
        $.post('ajax_data',{action:'service_detail',service:service_now}, function(data){
          if( data.empty == 1 ){
            $("#charge_div").hide();
          }else{
            $("#neworder_fields").html("");
            $("#charge_div").show();
            $("#neworder_fields").html(data.details);
            $("#charge").val(data.price);
          }
        //   $(".datetime").datepicker({
        //      format: "dd/mm/yyyy",
        //      language: "tr",
        //      startDate: new Date(),
        //   }).on('change', function(ev){
        //      $(".datetime").datepicker('hide');
        //   });
        //   $("#clearExpiry").click(function(){
        //       $("#expiryDate").val('');
        //   });
           var dripfeed = $("#dripfeedcheckbox").prop('checked');
           if( dripfeed ){
             $("#dripfeed-options").removeClass();
           }
           comment_charge();
            if( $("#dripfeedcheckbox").prop('checked') ){
              dripfeed_charge();
            }
              if( data.sub ){
                $("#charge_div").hide();
              }else{
                $("#charge_div").show();
              }
      }, 'json');
}

function addfunds_form(){
    var method_now = $("#payment_method").val();
    $("#addfunds_form").html();
    if( $(method_now).val() !== "" ) { 
      $("#addfunds_form").html("<style>.loader {border: 16px solid #f3f3f3;border-radius: 50%;border-top: 16px solid #3498db;width: 120px;height: 120px;-webkit-animation: spin 2s linear infinite; /* Safari */animation: spin 2s linear infinite;}@-webkit-keyframes spin {0% { -webkit-transform: rotate(0deg); }100% { -webkit-transform: rotate(360deg); }}@keyframes spin {0% { transform: rotate(0deg); }100% { transform: rotate(360deg); }}</style><center><div class='loader'></div></center>");
      $.post('ajax_data',{action:'addfunds_form',method:method_now}, function(data){
          $("#addfunds_form").html(data.form_data);
          service_detail();
      }, 'json');
    }
}

function comment_charge(){
  var service   = $("#neworder_services").val();
  var comments  = $("#neworder_comment").val();
    if( comments ){
      $.post('ajax_data',{action:'service_price',service:service,comments:comments}, function(data){
          $("#neworder_quantity").val(data.commentsCount);
          $("#charge").val(data.price);
      }, 'json');
    }
}

function findAllCategoryChildren(id, results) {
    if (typeof data !== 'undefined'){
      for (d in data) {
        if (data[d].category_id == id) {
          results.push(data[d].services)
        }
      }
    }
}

function findAllServicesData(id, results) {
    if(data.length !== 0){
      for (d in data) {
        for (f in data[d].services) {
          if (data[d].services[f].service_id == id) {
            results.push(data[d].services[f])
          }
        }
      }
    }
}

function dripfeed_charge(){
  var service     = $("#neworder_services").val();
  var quantity    = $("#neworder_quantity").val();
  var runs        = $("#dripfeed-runs").val();
    if( $("#dripfeedcheckbox").prop('checked') ){
      var dripfeed  = "var";
    }else{
      var dripfeed  = "bos";
    }
  $.post('ajax_data',{action:'service_detail',service:service,quantity:quantity,dripfeed:dripfeed,runs:runs}, function(data){
      $("#charge").val(data.price);
  }, 'json');
}
