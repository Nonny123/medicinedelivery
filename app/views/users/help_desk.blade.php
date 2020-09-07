@include('...header')

<div class="contact-container">
        <div class="contact-inner container">
            <div class="col-sm-3">
                <h1 class="contact-h1">HelpDesk</h1>
            </div>
            <div class="col-sm-9 contact-right-section about-cont">
                <div class="contact-right-upper">
                    <div class="contact-upp-inn">
                    <h2 class="contact-h2">HelpDesk of {{ Setting::param('site','app_name')['value'] }}</h2>

                    <p> We will be a creditable partner to educate and guide our customers in getting the right access to medicines. You will be getting professional support from every side, either through email, phone or in-person support.</p>

                   <h2 class="contact-h2">Telephonic Assistance :</h2>

                    <p> You can reach us just by dialling<span class="hno"> {{ Setting::param('site','phone')['value'] }}</span>. We will be there at the end for answering even your simple queries. Also users are encouraged to leave a voice call, if we are not available on the spot right at that time.</p>

                  <h2 class="contact-h2">Email</h2>

                    <p> You can tie with us through email also - a convenient tool which enables us stay connected with our customers faster and smoother throughout.Mail us at   <a href="mailto:{{ Setting::param('site','mail')['value'] }}" target="_top" style="color: #00c0a7;">{{ Setting::param('site','mail')['value'] }}</a></p>

                    </div>


                    <h2 class="contact-h2">Walk-In Offices</h2>

                    <ul class="contact-ul">
                        <li>Our users can also take the benefit of in-person support and consultation as we are accessible on live for our customers.</li>
                        <li>{{ Setting::param('site','address')['value'] }}</li>
                    </ul>

                   <!-- <p>We made it simple and trouble free for you to connect with us for making your

                        purchase of medicine online.</p>-->

                   <!-- <button type="button" class="btn btn-primary save-btn ripple" data-color="#40E0BC" style="margin-top:30px;">Read More</button>-->

                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <footer>
        <div class="container innerBtm">


@include('...footer')