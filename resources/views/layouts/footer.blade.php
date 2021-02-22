@section('footer')
    <footer class="footer" style="padding: 0px;">
    </footer>
    <script src="{{url('js/app.js?v=1.13')}}"></script>
    <script src="{{url('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
	<script src="{{url('assets/js/plugin/jquery-mapael/jquery.mapael.min.js')}}"></script>
	<script src="{{url('assets/js/plugin/jquery-mapael/maps/world_countries.min.js')}}"></script>
	<script src="{{url('assets/js/plugin/chart-circle/circles.min.js')}}"></script>
	<script src="{{url('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
	<script src="{{url('assets/demo/demo.js')}}"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	<script type="text/javascript">
        function openTab3(evt, tabName) {
        // Declare all variables
            var i, tabcontent, tablinks;

            // Get all elements with class="tabcontent" and hide them
            tabcontent = document.getElementsByClassName("tabcontent3");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Get all elements with class="tablinks" and remove the class "active"
            tablinks = document.getElementsByClassName("tablinks3");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Show the current tab, and add an "active" class to the button that opened the tab
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }
	</script>
@endsection