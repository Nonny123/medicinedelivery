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
        <div class="prescription-inner container alert-success" style="min-height: 680px;text-align:center;line-height:60px;">
             <h2 style="text-align: center;color: #67A568;"><strong>Success !</strong> Your payment was has been processed.</h2>
             <p> Thank you for shopping with us. We will ship your package once in a short while, you can track the status of the shippment in My Shipping.</p>
             <a href="{{url()}}" class="btn btn-warning" style="background-color: #6d7289">Back To Home</a>

        </div>

        <!-- prescription-cont -->
    </div>


     <footer>
            <div class="container innerBtm">

    @include('...footer')
