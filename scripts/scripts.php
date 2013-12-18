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
        $('div[id$="ok"]').hide();
        $('#' + this.value + '_ok').show();	
	}).change();
});

$(document).ready(function(){
$('#content').fadeIn(800);
$('#createNewUser').fadeIn(800);
});
</script>