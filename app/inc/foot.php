
<!-- Scripts --> 
<script src="scripts/jquery-3.4.1.min.js"></script> 
<script src="scripts/chosen.min.js"></script> 
<script src="scripts/perfect-scrollbar.min.js"></script>
<script src="scripts/slick.min.js"></script> 
<script src="scripts/rangeslider.min.js"></script> 
<script src="scripts/magnific-popup.min.js"></script> 
<script src="scripts/jquery-ui.min.js"></script> 
<script src="scripts/mmenu.js"></script>
<script src="scripts/tooltips.min.js"></script> 
<script src="scripts/color_switcher.js"></script>
<script src="scripts/jquery_custom.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="scripts/functions.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
(function($) {
try {
	var jscr1 = $('.js-scrollbar');
	if (jscr1[0]) {
		const ps1 = new PerfectScrollbar('.js-scrollbar');

	}
    } catch (error) {
        console.log(error);
    }
})(jQuery);

<?php
if (count($arAdditionalJs) > 0)
{
  echo implode(PHP_EOL, $arAdditionalJs);
}
?>

function doOpenLogoutModal()
{
  Swal.fire({
    title: '',
    text: 'Are you sure you want to logout?',
    icon: 'error',
    showCancelButton: true,
    reverseButtons: true,
    confirmButtonText: 'Logout',
    confirmButtonColor: '#d33',
    customClass: 'swalWide',
    }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = 'app/logout';
    }
  });
}

</script>

<script>
$(document).ready(function() {
  <?php
  if (count($arAdditionalJsOnLoad) > 0)
  {
    echo implode(PHP_EOL, $arAdditionalJsOnLoad);
  }
  ?>
  
  $('#logoutSidebarBtn').click(function()
  {
    doOpenLogoutModal();
  });
  $('#logoutHeaderBtn').click(function()
  {
    doOpenLogoutModal();
  });

});
</script>

</body>

</html>