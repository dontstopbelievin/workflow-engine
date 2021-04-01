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
    <script src="{{url('js/jquery_3.6.js')}}"></script>
    <script src="{{url('js/jquery_migrate_1.2.1.js')}}"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{url('assets/js/ncalayer/jquery.blockUI.js')}}" charset="utf-8"></script>
    <script type="text/javascript" src="{{url('assets/js/ncalayer/ncalayer.js')}}" charset="utf-8"></script>
    <script type="text/javascript" src="{{url('assets/js/ncalayer/process-ncalayer-calls.js')}}" charset="utf-8"></script>
	<script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
	</script>
@endsection
