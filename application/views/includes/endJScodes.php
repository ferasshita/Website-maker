<?php
$checkDir = base_url();
$page_name = $page_name['name'];
?>

<script type="text/javascript">
//==================================================================
function delete_account(){
  if(confirm("Are you sure to delete your data permently?")){
    if(confirm("You will lose your data forever?")){
      if(confirm("You can't recover your data?")){
      }else{
        return false;
      }
    }else{
    return false;
    }
  }else{
    return false;
  }
}
function delete_transaction(table,cid){
  if(confirm("<?php echo lang('are_delete'); ?>")){
    $.ajax({
        type:'POST',
        url:'<?php echo base_url(); ?>project/delete_transaction',
        data:{'table':table,'cid':cid},
        beforeSend: function(){
            $('#tr_'+cid).hide();
        },
        success: function(done){
            if (done = 'yes') {
                $('#tr_'+cid).html('');
            }else{
                $('#tr_'+cid).show();
                alert('Action denied! You are not allowed to doing this action');
            }
        }
    });}
else{
    return false;
}
}
function compile(folder){
	if(confirm("Do you want to start compiling?")){
		$.ajax({
			type:'POST',
			url:'<?php echo base_url(); ?>project/compile',
			data:{'folder':folder},

			success: function(done){
				if (done = 'yes') {
					alert("Done!")
				}else{
					alert('Action denied! You are not allowed to doing this action');
				}
			}
		});}
	else{
		return false;
	}
}
function mode(){
    $.ajax({
        type:'POST',
        url:'<?php echo base_url(); ?>includes/mode',
        success: function(done){
              var $sidebar = $('body');
              var $html = $('html');
              if ($sidebar.hasClass('dark-skin')) {
                $sidebar.removeClass('dark-skin')
                $html.removeClass('dark-skin')

                $sidebar.addClass('light-skin')
                $html.addClass('light-skin')
              } else {
                $sidebar.removeClass('light-skin')
                $html.removeClass('light-skin')
                $sidebar.addClass('dark-skin')
                $html.addClass('dark-skin')
              }

        }
    });

}
function hide_text(id){
  var $text = $(id);
  if ($text.hasClass('regular')) {
    $text.removeClass('regular')
    $text.addClass('hash')
  } else {
    $text.removeClass('hash')
    $text.addClass('regular')
  }
}
</script>
<script type="text/javascript">
var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})()
</script>
<script>
    function print_co(id){
      var print_div = document.getElementById("tr_"+id);
var print_area = window.open();
print_area.document.write(print_div.innerHTML);
print_area.document.close();
print_area.focus();
print_area.print();
print_area.close();
// This is the code print a particular div element
    }
</script>
<script>
$(function () {
  'use strict'

    $('[data-provide~="fullscreen"]').on('click', function () {
      screenfull.toggle($('#container')[0]);
    });

});
</script>
<script>
$(function() {

  function passwordCheck(password) {
    if (password.length >= 8)
      strength += 1;

    if (password.match(/(?=.*[0-9])/))
      strength += 1;

    if (password.match(/(?=.*[!,%,&,@,#,$,^,*,?,_,~,<,>,])/))
      strength += 1;

    if (password.match(/(?=.*[a-z])/))
      strength += 1;

    if (password.match(/(?=.*[A-Z])/))
      strength += 1;

    displayBar(strength);
  }

  function displayBar(strength) {
    switch (strength) {
      case 1:
        $("#password-strength span").css({
          "width": "20%",
          "background": "#de1616"
        });
        break;

      case 2:
        $("#password-strength span").css({
          "width": "40%",
          "background": "#de1616"
        });
        break;

      case 3:
        $("#password-strength span").css({
          "width": "60%",
          "background": "#de1616"
        });
        break;

      case 4:
        $("#password-strength span").css({
          "width": "80%",
          "background": "#FFA200"
        });
        break;

      case 5:
        $("#password-strength span").css({
          "width": "100%",
          "background": "#06bf06"
        });
        break;

      default:
        $("#password-strength span").css({
          "width": "0",
          "background": "#de1616"
        });
    }
  }

  $("[data-strength]").after("<div id=\"password-strength\" class=\"strength\"><span class=\"pst\"></span></div>")

  $("[data-strength]").focus(function() {
    $("#password-strength").css({
      "height": "7px"
    });
  }).blur(function() {
    $("#password-strength").css({
      "height": "0px"
    });
  });

  $("[data-strength]").keyup(function() {
    strength = 0;
    var password = $(this).val();
    passwordCheck(password);
  });

});
</script>
<script type="text/javascript">
  function isNumberKey(txt, evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode == 46) {
      //Check if the text already contains the . character
      if (txt.value.indexOf('.') === -1) {
        return true;
      } else {
        return false;
      }
    } else {
      if (charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;
    }
    return true;
  }
</script>
<script async src="https://www.googletagmanager.com/gtag/js?id=212322130"></script>

<script>
 window.dataLayer = window.dataLayer || [];
 function gtag(){dataLayer.push(arguments);}
 gtag('js', new Date());
 gtag('config', '212322130');
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Corporation",
  "name": "<?php echo project_name(); ?>",
  "alternateName": "<?php echo author(); ?>",
  "url": "<?php echo base_url(); ?>",
  "logo": "<?php echo base_url(); ?>Asset/imgs/logo.ico",
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+218913691247",
    "contactType": "customer service",
    "contactOption": ["TollFree","HearingImpairedSupported"],
    "areaServed": "LY",
    "availableLanguage": ["en","Arabic"]
  },
  "sameAs": "https://facebook.com/<?php echo author(); ?>"
}
</script>
