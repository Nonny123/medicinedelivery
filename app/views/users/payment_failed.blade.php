@include('...header')

<link href="{{ URL::asset('sass/styles.css') }}" rel="stylesheet">
    {{--<link href="{{ URL::asset('sass/style2.css') }}" rel="stylesheet">--}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    {{--<script src="assets/js/jquery.form.js"></script>--}}


    <script type="text/javascript" src="{{url()}}/javascripts/jquery.validate.min.js"></script>
    <div class="contact-container">
        <div class="prescription-inner container alert-danger" style="min-height: 680px;text-align:center;line-height:60px;">
             <h2><strong>Failure !</strong> Your payment was not processed.</h2>
             <p> Due to some technical issues, your payment was not processed, please contact us incase of any queries.</p>
             <a href="{{url()}}" class="btn btn-warning" style="background-color: #6d7289">Back To Home</a>
        </div>
        <!-- prescription-cont -->
    </div>
    <footer>
            <div class="container innerBtm">

    @include('...footer')
