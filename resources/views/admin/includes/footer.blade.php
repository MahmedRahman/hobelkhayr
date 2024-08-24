<div class="footer">
    <p>&copy; 2018 Glance Design Dashboard. All Rights Reserved | Design by <a href="https://w3layouts.com/"
            target="_blank">w3layouts</a></p>
</div>

<!-- side nav js -->
<script src='{{ URL::asset('js/SidebarNav.min.js') }}' type='text/javascript'></script>

<script>
$('.sidebar-menu').SidebarNav()
</script>
<!-- //side nav js -->

<!-- Classie -->
<!-- for toggle left push menu script -->
<script src=""></script>
<script>
var menuLeft = document.getElementById('cbp-spmenu-s1'),
    showLeftPush = document.getElementById('showLeftPush'),
    body = document.body;

showLeftPush.onclick = function() {
    classie.toggle(this, 'active');
    classie.toggle(body, 'cbp-spmenu-push-toright');
    classie.toggle(menuLeft, 'cbp-spmenu-open');
    disableOther('showLeftPush');
};

function disableOther(button) {
    if (button !== 'showLeftPush') {
        classie.toggle(showLeftPush, 'disabled');
    }
}
</script>
<!-- //Classie -->
<!-- //for toggle left push menu script -->

<!--scrolling js-->
<script src="{{ URL::asset('js/jquery.nicescroll.js') }}"></script>
<script src="{{ URL::asset('js/scripts.js') }}"></script>


<!--//scrolling js-->

<!-- Bootstrap Core JavaScript -->
<script src="{{ URL::asset('js/bootstrap.js') }}"></script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>