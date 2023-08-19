function throwError(msg)
{
    toastr.error(msg);
}
function throwInfo(msg)
{
    toastr.info(msg);
}
function throwWarning(msg)
{
    toastr.warning(msg);
}
function throwSuccess(msg)
{
    toastr.success(msg);
}
function enableDisableBtn(id, status)
{
    disable = true;
    if(status == 1) {
        disable = false;
    }
    $(id).attr('disabled', disable);
    if(disable) {
        $(id).append(' <div class="spinner-border text-light spinner-border-sm" role="status"><span class="sr-only">Processing...</span></div>');
    }
    else {
        $('.spinner-border').remove();
    }
}
function showAlert(msg, id, alertClass)
{
    var arClasses = ['success', 'warning', 'error', 'notice'];
    for (cls of arClasses)
    {
        $('#'+id+'_wrapper').removeClass(cls);
    }
    $('#'+id+'_div').show();
    $('#'+id+'_wrapper').addClass(alertClass);
    $('#'+id).html(msg);
}