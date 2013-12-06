</body>
<script type="text/javascript">
$("#head2").click(function fade(div_id) {
$('.modal').fadeIn(300);
window.scrollTo(0, 0);
});
$("#modalClose").click(function fade(div_id) {
$('.modal').fadeOut(300);
});

$(function () {
    $("#categories_select").change(function () {
        $('div[id$="ok"]').css("display", "none");
        $('#' + this.value.toLowerCase() + '_ok').css("display", "block");
    }).change();
});

$(document).ready(function(){
$('#content').fadeIn(1700);
$('#createNewUser').fadeIn(1700);
});
</script>