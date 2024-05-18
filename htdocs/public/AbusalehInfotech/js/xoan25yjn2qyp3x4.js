function dashMenuToggle() {
    $('.app-sidebar').toggleClass('sidebar-inact');
    $('.app-header').toggleClass('sidebar-inact');
    $('.app-content').toggleClass('sidebar-inact');
	$('body').toggleClass('body-pause');
}


$(document).ready(function(){
  $("#serv-inp").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#serv-table tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
}); 

      function filterService(category) {
        if (category == 'All')
          $('.smmspot-updates-item.hidden').removeClass('hidden');
        else {
          $('.smmspot-updates-item').addClass('hidden');
          $('.smmspot-updates-item[data-type="' + category + '"]').removeClass('hidden');
        }
        removeEmptyCategory();
      }

$(document).ready(function(){
  $("#filterInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".smmspot-updates-item").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});


$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});


$(document).ready(function() {
    setList(0);
    setList(1);

});

function ikon(opt) {
      var ikon = "";
    if (opt.indexOf("Instagram") >= 0 || opt.indexOf("IG") >= 0) {
        ikon = "<span class=\"fs-ig\"><i class=\"fab fa-instagram\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("YouTube") >= 0 || opt.indexOf("YT") >= 0 || opt.indexOf("Youtube") >= 0) {
        ikon = "<span class=\"fs-yt\"><i class=\"fab fa-youtube\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Facebook") >= 0 || opt.indexOf("FB") >= 0) {
        ikon = "<span class=\"fs-fb\"><i class=\"fab fa-facebook-square\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Twitter") >= 0) {
        ikon = "<span class=\"fs-tw\"><i class=\"fab fa-twitter\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Google") >= 0) {
        ikon = "<span class=\"fs-gp\"><i class=\"fab fa-google-plus\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Swarm") >= 0) {
        ikon = "<span class=\"fs-fsq\"><i class=\"fab fa-forumbee\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Dailymotion") >= 0) {
        ikon = "<span class=\"fs-dm\"><i class=\"fab fa-hospital-o\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Periscope") >= 0) {
        ikon = "<span class=\"fs-pc\"><i class=\"fab fa-map-marker\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Soundcloud") >= 0) {
        ikon = "<span class=\"fs-sc\"><i class=\"fab fa-soundcloud\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Vine") >= 0) {
        ikon = "<span class=\"fs-vn\"><i class=\"fab fa-vine\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Spotify") >= 0) {
        ikon = "<span class=\"fs-sp\"><i class=\"fab fa-spotify\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Snapchat") >= 0) {
        ikon = "<span class=\"fs-snap\"><i class=\"fab fa-snapchat-square\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Pinterest") >= 0) {
        ikon = "<span class=\"fs-pt\"><i class=\"fab fa-pinterest-p\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("iTunes") >= 0) {
        ikon = "<span class=\"fs-apple\"><i class=\"fab fa-apple\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Müzik") >= 0) {
        ikon = "<span class=\"fs-music\"><i class=\"fab fa-music\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Vimeo") >= 0) {
        ikon = "<span class=\"fs-videmo\"><i class=\"fab fa-vimeo\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Ekşi") >= 0) {
        ikon = "<span class=\"fs-eksi\"><i class=\"fab fa-tint\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Telegram") >= 0) {
        ikon = "<span class=\"fs-telegram\"><i class=\"fab fa-telegram\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Twitch") >= 0) {
        ikon = "<span class=\"fs-twc\"><i class=\"fab fa-twitch\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Zomato") >= 0) {
        ikon = "<span class=\"fs-zom\"><i class=\"fab fa-cutlery\" aria-hidden=\"true\"></i> </span>";
	} else if (opt.indexOf("Amazon") >= 0) {
        ikon = "<span class=\"fs-amaz\"><i class=\"fab fa-amazon\" aria-hidden=\"true\"></i> </span>";
	} else if (opt.indexOf("Tumblr") >= 0) {
        ikon = "<span class=\"fs-tumb\"><i class=\"fab fa-tumblr-square\" aria-hidden=\"true\"></i> </span>";
	} else if (opt.indexOf("Yandex") >= 0) {
        ikon = "<span class=\"fs-yndx\"><i class=\"fab fa-yoast\" aria-hidden=\"true\"></i> </span>";
	} else if (opt.indexOf("Linkedin") >= 0) {
        ikon = "<span class=\"fs-lnk\"><i class=\"fab fa-linkedin\" aria-hidden=\"true\"></i> </span>";
	} else if (opt.indexOf("Yahoo") >= 0) {
        ikon = "<span class=\"fs-yahoo\"><i class=\"fab fa-yahoo\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("TikTok") >= 0) {
        ikon = "<span class=\"fs-tiktok\"><i class=\"fa fa-music\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Clubhouse") >= 0) {
        ikon = "<span class=\"fs-hand-sparkles\"><i class=\"fa fa-hand-sparkles\" aria-hidden=\"true\"></i> </span>";
    } else {
        ikon = "<span class=\"\"><i class=\"far fa-star\" aria-hidden=\"true\"></i> </span>  ";
    }
    return ikon;
   }

function setList(val) {

    if (val == 0) {
        $("#orders-drop").empty();
        $("#orderform-service option").each(function() {
          if($(this).attr('data-show') != 'hidden') {
			var ico = ikon($(this).text());
            $("#orders-drop").append('<button id="order-sItem" class="dropdown-item" type="button" onclick="selectOrder(' + $(this).val() + ')">' + ico + $(this).text() + '</button>');
          }
        });
        var e = document.getElementById("orderform-service");

        if (e == null)return;
        var selected = e.options[e.selectedIndex].text;
		var ico = ikon(selected);
        $("#order-services").html(ico + selected);


    } else if (val == 1) {

        $("#category-drop").empty();
        $("#orderform-category option").each(function() {
          if($(this).attr('data-show') != 'hidden') {
            var ico = ikon($(this).text());
              $("#category-drop").append('<button id="order-cItem" class="dropdown-item" type="button" onclick="selectCategory(' + $(this).val() + ')">' + ico + $(this).text() + '</button>');
          }
        });

        var e = document.getElementById("orderform-category");
      	if (e == null)return;
        var selected = e.options[e.selectedIndex].text;
        var ico = ikon(selected);
        $("#order-category").html(ico + selected);

    }
}
$(function(ready) {
    $("#orderform-service").change(function() {
        setList(0);
    });
    $("#orderform-category").change(function() {
        setList(1);
    });
});

function selectOrder(val) {
    $('#orderform-service').val(val);
    $("#orderform-service").trigger("change");
	var ico = ikon($("#orderform-service option[value='" + val + "']").text());
    $("#order-services").html(ico + $("#orderform-service option[value='" + val + "']").text());
}
$("#order-sItem").click(function() {
    $("#order-services").html($(this).html());
});

function selectCategory(val) {
    $('#orderform-category').val(val);
    $("#orderform-category").trigger("change");
  	var ico = ikon($("#orderform-category option[value='" + val + "']").text());
    $("#order-category").html(ico + $("#orderform-category option[value='" + val + "']").text());
}

function selectCategory(val) {
    $('#orderform-category').val(val);
    $("#orderform-category").trigger("change");
  	var ico = ikon($("#orderform-category option[value='" + val + "']").text());
    $("#order-category").html(ico + $("#orderform-category option[value='" + val + "']").text());
}


$('.home-ss-tab').click(function(){
  if($(this).hasClass('active')){
      $(this).find('.ss-tab-content').slideToggle(200);
      $(this).toggleClass('active');
  }else {
      $('.home-ss-tab').removeClass('active');
      $('.home-ss-tab > .ss-tab-content').slideUp(200);
      $(this).find('.ss-tab-content').slideToggle(200);
      $(this).toggleClass('active');
  }
});

$('.tos-nav-btn').click(function(){
    if($(this).hasClass('active')){

    }else {
        let getFor = $(this).attr('for');
        $('.tos-nav-btn').removeClass('active');
        $(this).toggleClass('active');
        $('.tos-tab').removeClass('active');
        $('#'+ getFor +'.tos-tab').addClass('active')

    }
});


function change_mode() {

		var app = document.getElementsByTagName("BODY")[0];

		if (localStorage.lightMode == "dark") {
			localStorage.lightMode = "light";
			app.setAttribute("class", "light");
		} else {
			localStorage.lightMode = "dark";
			app.setAttribute("class", "dark");
		}
		console.log("lightMode = " + localStorage.lightMode);
}


function copywalletid(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
}

$("#orderform-service").change(function () {
    service_id = $(this).val();
    $("#s_id").text(service_id);
    console.log($("#s_time").text());
    serviceData = window.modules.siteOrder.services[service_id]
    $("#s_time").text(serviceData.average_time);
    $("#s_desc").html(serviceData.description ?? 'No description available.');
    $('#s_time').val($('#s_time').text());
})