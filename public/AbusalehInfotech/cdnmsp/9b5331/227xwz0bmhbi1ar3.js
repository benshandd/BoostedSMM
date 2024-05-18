$(document).ready(function () {
    var letCollapseWidth = false,
        paddingValue = 30,
        sumWidth = $('.navbar-right-block').width() + $('.navbar-left-block').width() + $('.navbar-brand').width() + paddingValue;

    $(window).on('resize', function () {
        navbarResizerFunc();
    });

    var navbarResizerFunc = function navbarResizerFunc() {
        if (sumWidth <= $(window).width()) {
            if (letCollapseWidth && letCollapseWidth <= $(window).width()) {
                $('#navbar').addClass('navbar-collapse');
                $('#navbar').removeClass('navbar-collapsed');
              	
                $('nav').removeClass('navbar-collapsed-before');
                letCollapseWidth = false;
            }
        } else {
            $('#navbar').removeClass('navbar-collapse');
            $('#navbar').addClass('navbar-collapsed');
            $('nav').addClass('navbar-collapsed-before');
            letCollapseWidth = $(window).width();
        }
    };

    if ($(window).width() >= 768) {
        navbarResizerFunc();
      $('#wrapper').addClass('toggled');  
    }else{
    	$('#wrapper').removeClass('toggled');  
    }

    //$('[data-toggle="tooltip"]').tooltip();
});







/**Objet Favorite */
class FavController {

    categories = new Array();
    services = new Array();

    constructor(__data__) {
        
        //var allCategories = this.convertToArray(__data__);

        //init class attributes
        this.categories = new Array();
        this.services = new Array();

        //get All favorites from local storage
        var favorites = new Array();
        if(localStorage.hasOwnProperty('favorites')){
            favorites = JSON.parse(localStorage.getItem('favorites'));
        }

        for(var i=0; i<favorites.length;i++){
            var obj = {category:favorites[i].category_id,name:favorites[i].category_name};
            this.categories.push(obj);
        }

    }

    get categories(){
        return this.categories;
    }

    static servicesByCategory(category){
        //where category
        var __data__ = window.modules.siteOrder.services;
        var allServices = Object.keys(__data__).map(function (key) { return __data__[key]; });
        
        var favorites = new Array();
        if(localStorage.hasOwnProperty('favorites')){
            favorites = JSON.parse(localStorage.getItem('favorites'));
        }

        var serviceArray = new Array();
        for(var i=0; i<favorites.length;i++){
            var obj = favorites[i];
            if(obj.category_id === category){
                serviceArray = obj.services;
            }
        }

        this.services = new Array();
        for(var j=0; j<serviceArray.length;j++){
            var ss = serviceArray[j];
            var o = allServices.find((o) => { return Number.parseInt(o.id) === ss.service });
            this.services.push(o);
        }

        
        return this.services;
    }


    static getFielsFromType(type){
        var html = '';

        var _services_data = window.modules.siteOrder.services;

        switch (parseInt(type)){
            case 0:
                html = '' +
                    '<div class="form-group fields" id="order_link">\n' +
                    '    <label class="control-label" for="fav-field-orderform-fields-link">Link</label>\n' +
                    '    <input class="form-control" name="OrderForm[link]" value="" type="text" id="fav-field-orderform-fields-link">\n' +
                    '</div>' +
                    '<div class="form-group fields" id="order_quantity">\n' +
                    '    <label class="control-label" for="fav-field-orderform-fields-quantity">Quantity</label>\n' +
                    '    <input class="form-control" name="OrderForm[quantity]" value="" type="number" id="fav-field-orderform-fields-quantity">' +
                    '<small class="help-block min-max" id="fav-min-max-label">Min: 1000 - Max: 1000</small>\n' +
                    '</div>' +
                    '<div class="form-group">\n' +
'                              <label for="fav-charge" class="control-label">Charge</label>\n' +
'                              <input type="text" class="form-control" id="fav-charge" value="" readonly="">\n' +
'                        </div>';
                break;
            case 1:
                break;
            case 2:
                html = '<div class="form-group fields" id="order_link">\n' +
                    '    <label class="control-label" for="fav-field-orderform-fields-link">Link</label>\n' +
                    '    <input class="form-control" name="OrderForm[link]" value="" type="text" id="fav-field-orderform-fields-link">\n' +
                    '</div>' +
                    '<div class="form-group fields" id="order_quantity">\n' +
                    '    <label class="control-label" for="fav-field-orderform-fields-quantity">Quantity</label>\n' +
                    '    <input class="form-control" name="OrderForm[quantity]" value="" type="number" id="fav-field-orderform-fields-quantity" disabled="">' +
                    '<small id="fav-min-max-label" class="help-block min-max">Min: 5 - Max: 2000</small>\n' +
                    '</div>' +
                    '<div class="form-group fields" id="order_comment">\n' +
                    '    <label class="control-label" for="fav-field-orderform-fields-comment">Comments (1 per line)</label>\n' +
                    '    <textarea class="form-control counter" name="OrderForm[comment]" id="fav-field-orderform-fields-comment" cols="30" rows="10" data-related="quantity"></textarea>\n' +
                    '</div>' +
                    '<div class="form-group">\n' +
                    '<label for="fav-charge" class="control-label">Charge</label>\n' +
                    '    <input type="text" class="form-control" id="fav-charge" value="" readonly="">\n' +
                    '</div>';
                break;
            case 3:
                break;
            case 4:
                html='<div class="form-group fields" id="order_link">\n' +
                    '    <label class="control-label" for="fav-field-orderform-fields-link">Link</label>\n' +
                    '    <input class="form-control" name="OrderForm[link]" value="" type="text" id="fav-field-orderform-fields-link">\n' +
                    '</div>' +
                    '<div class="form-group fields" id="order_quantity">\n' +
                    '    <label class="control-label" for="fav-field-orderform-fields-quantity">Quantity</label>\n' +
                    '    <input class="form-control" name="OrderForm[quantity]" value="" type="number" id="fav-field-orderform-fields-quantity" disabled="">' +
                    '<small class="help-block min-max" id="fav-min-max-label">Min: 1000 - Max: 100000</small>\n' +
                    '</div>' +
                    '<div class="form-group fields" id="order_usernames_custom">\n' +
                    '    <label class="control-label" for="fav-field-orderform-fields-usernames_custom">Usernames (1 per line)</label>\n' +
                    '    <textarea class="form-control counter" name="OrderForm[usernames_custom]" id="fav-field-orderform-fields-usernames_custom" cols="30" rows="10" data-related="quantity"></textarea>\n' +
                    '</div>' +
                    '<div class="form-group">\n' +
                    '<label for="fav-charge" class="control-label">Charge</label>\n' +
                    '    <input type="text" class="form-control" id="fav-charge" value="" readonly="">\n' +
                    '</div>';
                break;
            case 5:
                break;
            case 6:
                break;
            case 7:
                html = '<div class="form-group fields" id="order_link">\n' +
                    '    <label class="control-label" for="fav-field-orderform-fields-link">Link</label>\n' +
                    '    <input class="form-control" name="OrderForm[link]" value="" type="text" id="fav-field-orderform-fields-link">\n' +
                    '</div>' +
                    '<div class="form-group fields" id="order_quantity">\n' +
                    '    <label class="control-label" for="fav-field-orderform-fields-quantity">Quantity</label>\n' +
                    '    <input class="form-control" name="OrderForm[quantity]" value="" type="number" id="fav-field-orderform-fields-quantity">' +
                    '<small class="help-block min-max" id="fav-min-max-label">Min: 1000 - Max: 100000</small>\n' +
                    '</div>' +
                    '<div class="form-group fields" id="order_username">\n' +
                    '    <label class="control-label" for="fav-field-orderform-fields-username">Username</label>\n' +
                    '    <input class="form-control" name="OrderForm[username]" value="" type="text" id="fav-field-orderform-fields-username">\n' +
                    '</div>' +
                    '<div class="form-group">\n' +
                    '     <label for="fav-charge" class="control-label">Charge</label>\n' +
                    '     <input type="text" class="form-control" id="fav-charge" value="" readonly="">\n' +
                    '</div>';
                break;
            case 8:
                break;
            case 9:
                html='<div class="form-group fields" id="order_link">\n' +
                    '    <label class="control-label" for="fav-field-orderform-fields-link">Link</label>\n' +
                    '    <input class="form-control" name="OrderForm[link]" value="" type="text" id="fav-field-orderform-fields-link">\n' +
                    '</div>' +
                    '<div class="form-group fields" id="order_link">\n' +
                    '    <label class="control-label" for="fav-field-orderform-fields-link">Link</label>\n' +
                    '    <input class="form-control" name="OrderForm[link]" value="" type="text" id="fav-field-orderform-fields-link">\n' +
                    '</div>' +
                    '<div class="form-group fields" id="order_quantity">\n' +
                    '    <label class="control-label" for="fav-field-orderform-fields-quantity">Quantity</label>\n' +
                    '    <input class="form-control" name="OrderForm[quantity]" value="" type="number" id="fav-field-orderform-fields-quantity">' +
                    '<small class="help-block min-max" id="fav-min-max-label">Min: 10000 - Max: 100000</small>\n' +
                    '</div>' +
                    '<div class="form-group fields" id="order_mentionUsernames">\n' +
                    '    <label class="control-label" for="fav-field-orderform-fields-mentionUsernames">Usernames (1 per line)</label>\n' +
                    '    <textarea class="form-control" name="OrderForm[mentionUsernames]" id="fav-field-orderform-fields-mentionUsernames" cols="30" rows="10"></textarea>\n' +
                    '</div>' +
                    '<div class="form-group">\n' +
                    '     <label for="fav-charge" class="control-label">Charge</label>\n' +
                    '     <input type="text" class="form-control" id="fav-charge" value="" readonly="">\n' +
                    '</div>';
                break;
            case 10:
                html = '<div class="form-group fields" id="order_link">\n' +
                    '    <label class="control-label" for="fav-field-orderform-fields-link">Link</label>\n' +
                    '    <input class="form-control" name="OrderForm[link]" value="" type="text" id="fav-field-orderform-fields-link">\n' +
                    '</div>' +
                    '<div class="form-group">\n' +
                    '     <label for="fav-charge" class="control-label">Charge</label>\n' +
                    '     <input class="form-control" name="OrderForm[quantity]" value="1" type="hidden" id="fav-field-orderform-fields-quantity">' +
                    '     <input type="text" class="form-control" id="fav-charge" value="" readonly="">\n' +
                    '     </div>';
                break;
            case 11:
                break;
            case 12:
                html = '<div class="form-group fields" id="order_link">\n' +
                    '    <label class="control-label" for="fav-field-orderform-fields-link">Link</label>\n' +
                    '    <input class="form-control" name="OrderForm[link]" value="" type="text" id="fav-field-orderform-fields-link">\n' +
                    '</div>' +
                    '<div class="form-group fields" id="order_quantity">\n' +
                    '    <label class="control-label" for="fav-field-orderform-fields-quantity">Quantity</label>\n' +
                    '    <input class="form-control" name="OrderForm[quantity]" value="" type="number" id="fav-field-orderform-fields-quantity">' +
                    '<small class="help-block min-max" id="fav-min-max-label">Min: 10 - Max: 2000</small>\n' +
                    '</div>' +
                    '<div id="dripfeed">\n' +
                    '    <div class="form-group fields" id="fav-order_check">\n' +
                    '        <label class="control-label has-depends " for="fav-field-orderform-fields-check">\n' +
                    '            <input name="OrderForm[check]" class="check-has-depends" data-depend="fav-dripfeed-options" value="1" type="checkbox" id="fav-field-orderform-fields-check">\n' +
                    '            Drip-feed\n' +
                    '        </label>\n' +
                    '        <div class="depend-fields" style="display: none" id="fav-dripfeed-options" data-depend="fav-field-orderform-fields-check">\n' +
                    '            <div class="form-group">\n' +
                    '                <label class="control-label" for="fav-field-orderform-fields-runs">Runs</label>\n' +
                    '                <input class="form-control" name="OrderForm[runs]" value="" type="text" id="fav-field-orderform-fields-runs">\n' +
                    '            </div>\n' +
                    '\n' +
                    '            <div class="form-group">\n' +
                    '                <label class="control-label" for="fav-field-orderform-fields-interval">Interval (in minutes)</label>\n' +
                    '                <input class="form-control" name="OrderForm[interval]" value="" type="text" id="fav-field-orderform-fields-interval">\n' +
                    '            </div>\n' +
                    '\n' +
                    '            <div class="form-group">\n' +
                    '                <label class="control-label" for="fav-field-orderform-fields-total-quantity">Total quantity</label>\n' +
                    '                <input class="form-control" name="OrderForm[total_quantity]" value="0" type="text" id="fav-field-orderform-fields-total-quantity" readonly="">\n' +
                    '            </div>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '</div>' +
                    '<div class="form-group">\n' +
                    '<label for="fav-charge" class="control-label">Charge</label>\n' +
                    '<input type="text" class="form-control" id="fav-charge" value="" readonly="">\n' +
                    '</div>';



                break;
            case 13:
                break;
            case 14:
                break;
            case 15:
                html='<div class="form-group fields" id="order_link">\n' +
                    '    <label class="control-label" for="fav-field-orderform-fields-link">Link</label>\n' +
                    '    <input class="form-control" name="OrderForm[link]" value="" type="text" id="fav-field-orderform-fields-link">\n' +
                    '</div>' +
                    '<div class="form-group fields" id="order_quantity">\n' +
                    '    <label class="control-label" for="fav-field-orderform-fields-quantity">Quantity</label>\n' +
                    '    <input class="form-control" name="OrderForm[quantity]" value="" type="number" data-rate="0.0005" id="fav-field-orderform-fields-quantity">' +
                    '<small class="help-block min-max" id="fav-min-max-label">Min: 20 - Max: 5000</small>\n' +
                    '</div>' +
                    '<div class="form-group fields" id="order_comment_username">\n' +
                    '    <label class="control-label" for="fav-field-orderform-fields-comment_username">Username of the comment owner</label>\n' +
                    '    <input class="form-control" name="OrderForm[comment_username]" value="" type="text" id="fav-field-orderform-fields-comment_username">\n' +
                    '</div>' +
                    '<div class="form-group">\n' +
                    '     <label for="fav-charge" class="control-label">Charge</label>\n' +
                    '     <input type="text" class="form-control" id="fav-charge" value="" readonly="">\n' +
                    '</div>';
                break;
            case 16:
                break;
            case 17:
                break;
            case 100:
                html = '<div class="form-group fields" id="fav-order_username">\n' +
                    '    <label class="control-label" for="fav-field-orderform-fields-username">Username</label>\n' +
                    '    <input class="form-control" name="OrderForm[username]" value="" type="text" id="fav-field-orderform-fields-username">\n' +
                    '</div>' +
                    '<div class="form-group fields" id="fav-order_posts">\n' +
                    '    <label class="control-label" for="fav-field-orderform-fields-posts">New posts</label>\n' +
                    '    <input class="form-control" name="OrderForm[posts]" value="" type="text" id="fav-field-orderform-fields-posts">\n' +
                    '</div>' +
                    '<div class="form-group fields" id="fav-order_min">\n' +
                    '    <label class="control-label" for="fav-order_count">Quantity</label>\n' +
                    '    <div class="row">\n' +
                    '        <div class="col-xs-6">\n' +
                    '            <input type="text" class="form-control" id="fav-order_count" name="OrderForm[min]" value="" placeholder="Min">' +
                    '            <small class="help-block min-max" id="fav-min-max-label">Min: 20 - Max: 50000</small>\n' +
                    '        </div>\n' +
                    '\n' +
                    '        <div class="col-xs-6">\n' +
                    '            <input type="text" class="form-control" id="fav-order_count_max" name="OrderForm[max]" value="" placeholder="Max">\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '</div>' +
                    '<div class="form-group fields" id="fav-order_delay">\n' +
                    '    <div class="row">\n' +
                    '        <div class="col-xs-6">\n' +
                    '            <label class="control-label" for="fav-field-orderform-fields-delay">Delay</label>\n' +
                    '            <select class="form-control" name="OrderForm[delay]" id="fav-field-orderform-fields-delay">\n' +
                    '                \n' +
                    '                <option value="0">No delay</option>\n' +
                    '                \n' +
                    '                <option value="300">5 minutes</option>\n' +
                    '                \n' +
                    '                <option value="600">10 minutes</option>\n' +
                    '                \n' +
                    '                <option value="900">15 minutes</option>\n' +
                    '                \n' +
                    '                <option value="1800">30 minutes</option>\n' +
                    '                \n' +
                    '                <option value="3600">60 minutes</option>\n' +
                    '                \n' +
                    '                <option value="5400">90 minutes</option>\n' +
                    '                \n' +
                    '            </select>\n' +
                    '        </div>\n' +
                    '        <div class="col-xs-6">\n' +
                    '            <label for="fav-field-orderform-fields-expiry">Expiry</label>\n' +
                    '            <div class="input-group">\n' +
                    '                <input class="form-control datetime" name="OrderForm[expiry]" value="" autocomplete="off" type="text" id="fav-field-orderform-fields-expiry">\n' +
                    '                <span class="input-group-btn">\n' +
                    '                    <button class="btn btn-default clear-datetime" type="button" data-rel="#field-orderform-fields-expiry"><span class="fa fa-trash-o"></span></button>\n' +
                    '                </span>\n' +
                    '            </div>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '</div>';

                break;
        }

        $('#favoriteform-fields').html(html);
        
        $('#favoriteform-fields .datetime').datetimepicker({
               format: 'DD/MM/YYYY' 
        });
        
        $('.check-has-depends').click(function () {
            var depend_id = $(this).data('depend');
            if($(this).is(":checked")){
                $('#'+depend_id).show();
            }else{
                $('#'+depend_id).hide();
            }
            totalFee();
        });

        $('#fav-field-orderform-fields-quantity').keyup(function () {
            totalFee();
        });

        $('#fav-field-orderform-fields-runs').keyup(function () {
            totalFee();
        });

        $('#fav-field-orderform-fields-usernames_custom').keyup(function () {
            this.totalFee();
        });

        $('.clear-datetime').click(function () {
            $(this).closest('div.input-group').find('input').val('');
        });

        $('.datetime').datetimepicker({
            format: 'MM/DD/YYYY',
        });

        updateMinMax();
        totalFee();

        function totalFee(){
            var qty = parseInt($('#fav-field-orderform-fields-quantity').val());
            if(!qty) qty = 0;
    
            var rate = getServicePrice();
            if($('#fav-field-orderform-fields-check').is(":checked")){
                var run = $('#fav-field-orderform-fields-runs').val();
                if(!run) run = 0;
                var total = qty*parseInt(run);
                $('#fav-field-orderform-fields-total-quantity').val(total);
                var fee = total*rate;
                $('#fav-charge').val('$'+fee);
            }else{
                $('#fav-field-orderform-fields-total-quantity').val(qty);
                var fee = qty*rate;
                $('#fav-charge').val('$'+fee);
            }
        }
    
        function updateMinMax(){
            if($('#fav-field-orderform-fields-quantity')){
    
                var id = $('#favoriteform-service').val();
                var service = getServiceById(id);
                //alert(service.min_max_label);
                $('#fav-min-max-label').html(service.min_max_label);
                $('#fav-field-orderform-fields-quantity').attr('min',service.min);
                $('#fav-field-orderform-fields-quantity').attr('max',service.max);
            }
        }
    
    
        function buildForm(type){
            var __fields__ = window.modules.siteOrder.fields;
            var fields = Object.keys(__fields__).map(function (key) { return __fields__[key]; });
            var type_fields = fields[type];;
    
           $('#fav_fields .form-group').addClass('hidden');
    
            for(var i=0;i<type_fields.length;i++){4
               $('#fav_order_'+type_fields[i].name).removeClass('hidden');
            }
        }

        function getServiceById(id) {
            var service = '';
            var services_data =  convertToArray(_services_data);
            for (var i = 0; i < services_data.length; i++) {
                if (services_data[i].id == parseInt(id)) {
                    return services_data[i];
                }
            }
            return service;
        }

        function convertToArray (myObj) {
            var arr = Object.keys(myObj).map(function (key) { return myObj[key]; });
            return arr;
        }

        function getServicePrice() {
            var id = $('#favoriteform-service').val();
            var service = getServiceById(id);
            return parseFloat(service.price)/1000;
        }
    
    }


}

class Favorite{
    category_id  ;
    category_name;
    services = new Array();

    constructor(category_id,category_name){
        this.category_id = category_id;
        this.category_name = category_name;

        var favorites = this.favorites();

        for(var i=0; i<favorites.length;i++){
            if(favorites[i].category_id == category_id ){
                this.services = favorites[i].services;
            }
        }
    }

    

    addService(service){
        var obj = {service : service};
        this.services.push(obj);

        var favorites = this.favorites();
        
        var exist = false;
        for(var i=0;i<favorites.length;i++){
            if(favorites[i].category_id  === this.category_id){
                favorites[i].services = this.services;
                exist = true;
            }
        }

        if(!exist){
            favorites.push(this);
        }

        localStorage.setItem("favorites", JSON.stringify(favorites));
    }

    removeService(service){
        var obj = {service : service};
        this.services.push(obj);

        var favorites = this.favorites();
        
        for(var i=0;i<favorites.length;i++){
            if(favorites[i].category_id  === this.category_id){
                favorites[i].services = $.grep(favorites[i].services, function(e){ 
                    return e.service != service; 
                });
            }
        }
        localStorage.setItem("favorites", JSON.stringify(favorites));
    }

    favorites(){
        var favorites = new Array();
        if(localStorage.hasOwnProperty('favorites')){
            favorites = JSON.parse(localStorage.getItem('favorites'));
        }
        return favorites;
    }
}



function getCookie(c_name)
{
var i,x,y,ARRcookies=document.cookie.split(";");
for (i=0;i<ARRcookies.length;i++)
  {
  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
  x=x.replace(/^\s+|\s+$/g,"");
  if (x==c_name)
    {
    return unescape(y);
    }
  }
}

function setCookie(c_name,value,exminutes)
{
var exdate=new Date();
exdate.setMinutes(exdate.getMinutes() + exminutes);
var c_value=escape(value) + ((exminutes==null) ? "" : "; expires="+exdate.toUTCString());
document.cookie=c_name + "=" + c_value;
}

function checkCookie()
{
var lastload=getCookie("lastload");

if (lastload!=null && lastload!="")
  {
  console.log(lastload);
  }
else 
  {
   // $("#newsModal").modal() 
  }
 // setCookie("lastload",1,60);
}

function dark(){
	console.log('darkness theme'); 
    var isDarkness = document.getElementsByClassName('darkness');
    if (isDarkness.length > 0) {
        var body = document.body;
        body.classList.remove("darkness");
    }else{
        var body = document.body;
        body.classList.add("darkness");
    }
     
}