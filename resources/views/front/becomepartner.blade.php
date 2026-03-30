@extends('layout.app')
@section('content')
@php
    use App\Models\Admins\Setting;
    $pro= Setting::where(['id'=>'1'])->first();
@endphp
<div class="hero-image" style="background-image: url({{asset('')}}front/assets/images/contactushero2.png);">
    <div class="headings">
        <h1 class="hero-title">Your own Candyshop </h1>
        <div class="breadcrumbs">
            <i class="fa-solid fa-house" style="color: white; font-size: 13px;"></i>
            <a href="{{url('/')}}" target="_blank">Home</a>
            <i class="fa-solid fa-angle-right" style="color: white; font-size: 13px;"></i>
            <a href="#" target="_blank">Become a Partner</a>
        </div>
    </div>
</div>

<div class="container partner">
    <div class="row align-items-center partner-grid-row g-4">
        <div class="col-md-6 image">
            <img src="{{asset('')}}front/assets/images/partners.png" />
        </div>
        <div class="col-md-6 content">
            <h1 class="heading">Why Partner with Us?</h1>
            <p class="desc">Join Goodiset, the premier Swedish candy brand, and bring a taste of Sweden’s finest
                candies to your local community. As a Goodiset franchise partner, you’ll be part of a brand loved
                for its quality, variety, and authentic Swedish flavors.</p>
            <ul class="list-unstyled">
                <li><strong>1. Proven Business Model</strong>
                    <p>Our franchise model is designed for success, based on years of experience and a deep
                        understanding of our market.</p>
                </li>
                <li><strong>2. Popular & Unique Product Range</strong>
                    <p>With Goodset, you'll have access to an extensive variety of Swedish candies that stand out
                        and draw in customers.</p>
                </li>
                <li><strong>3. Complete Brand Support</strong>
                    <p class="desc">From marketing to supply, we provide everything you need to establish and run a
                        successful store.</p>
                </li>
            </ul>
            <button class="submit"><a href="#contact_us_form">Get Started</a></button>
        </div>
    </div>
</div>

<div class="franchise-container">
    <h1 class="heading">What We Offer to Our Franchise Partners</h1>
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6 col-lg-6 grid-column">
                <div class="offer-card">
                    <div class="icon">
                        <img src="{{asset('')}}front/assets/icons/handshake.svg" />
                    </div>
                    <div class="content">
                        <h4>Turnkey Setup</h4>
                        <p>We handle everything from initial setup to ongoing support. All you need is the location
                            – we manage the rest.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 grid-column">
                <div class="offer-card">
                    <div class="icon">
                        <img src="{{asset('')}}front/assets/icons/advertise.svg" />
                    </div>
                    <div class="content">
                        <h4>Marketing & Advertising</h4>
                        <p>We take care of promoting your store locally and nationally through various marketing
                            channels, ensuring high visibility and brand presence.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 grid-column">
                <div class="offer-card">
                    <div class="icon">
                        <img src="{{asset('')}}front/assets/icons/management.svg" />
                    </div>
                    <div class="content">
                        <h4>Continuous Supply Chain Management</h4>
                        <p>You’ll receive fresh stock regularly from our suppliers, so you can focus on serving your
                            customers without worrying about logistics.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 grid-column">
                <div class="offer-card">
                    <div class="icon">
                        <img src="{{asset('')}}front/assets/icons/support.svg" />
                    </div>
                    <div class="content">
                        <h4>Training & Operational Support</h4>
                        <p>Our team provides in-depth training on product knowledge, customer service, and daily
                            operations to ensure you’re fully equipped for success.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container partner">
    <div class="row align-items-center partner-grid-row g-4 partner2">
        <div class="col-md-6 content">
            <h1 class="heading">Franchise Requirements</h1>
            <ul class="list-unstyled">
                <li><strong>1. Find the Perfect Location</strong>
                    <p>The location is crucial to our success. We’ll provide guidance on selecting the best spot to
                        attract foot traffic and maximize visibility.</p>
                </li>
                <li><strong>2. Initial Investment</strong>
                    <p>You’ll need a startup investment to cover location setup and branding. All other costs, from
                        supply to marketing, are handled by us.</p>
                </li>
                <li><strong>3. Passion for Candies</strong>
                    <p class="desc">A love for candies and a commitment to providing an enjoyable customer
                        experience are essential.</p>
                </li>
            </ul>
            <button class="submit"> <a href="#contact_us_form">Get Started</a></button>
        </div>
        <div class="col-md-6 image">
            <img src="{{asset('')}}front/assets/images/partners2.png" />
        </div>
    </div>
</div>

<div class="form_outer_container" id="contact_us_form">
<div class="form-container">
    <div class="form become_partner_outer_form">
        <h1 class="heading">Get in Touch with Goodiset</h1>
        <form action="{{url('/')}}/contact-us" method="post" class="become_partner_form">
            <div class="fields">
                @csrf
                <div class="field">
                    <label for="name">Full name</label>
                    <input type="hidden" name="contact_type" value="Franchise">
                    <input required type="text" name="name" id="name"
                        placeholder="Enter your full name">
                </div>
                <div class="two-fields">
                   <div class="field">
                       <label for="org_name">Email Address</label>
                       <input required type="email" name="email" id="email"
                           placeholder="Email address">
                   </div>
                   <div class="field">
                       <label for="phone">Phone number</label>
                       <input required type="text" name="phone" id="phone"
                           placeholder="Phone number">
                   </div>
               </div>
                <div class="two-fields">
                    <div class="field">
                        <label for="org_name">Country</label>
                        <input required type="text" name="email" id="email" placeholder="Country">
                    </div>
                    <div class="field">
                        <label for="phone">Location of interest</label>
                        <input required type="text" name="event_location" id="location"
                            placeholder="Location of interest">
                    </div>
                </div>
                <div class="two-fields">
                    <div class="field">
                        <label for="est_att">Model type</label>
                        <select required name="model_type" id="est_att">
                            <option value="">Select</option>
                            <option value="Kiosk">Kiosk</option>
                            <option value="Inside Mall">Inside Mall</option>
                            <option value="Outdoor Retail">Outdoor Retail</option>
                        </select>
                    </div>
                    <div class="field">
                        <label for="est_att">Estimated investment budget</label>
                        <select required name="estimated_investment_budget" id="est_att">
                            <option value="">Select</option>
                            <option value="AED 10k">AED 10k</option>
                            <option value="AED 20k">AED 20k</option>
                            <option value="AED 30k">AED 30k</option>
                            <option value="AED 40k">AED 40k</option>
                        </select>
                    </div>
                </div>
                <div class="field">
                    <label for="msg">Message</label>
                    <textarea name="meg" id="msg" placeholder="Let us know your product needs..." rows="5"></textarea>
                </div>
                <button class="contactus-btn" type="submit" value="submit" name="submit">Contact
                    US</button>
            </div>
        </form>
    </div>
    {{-- <div class="image">
        <img src="{{asset('')}}front/assets/images/House.png" />
    </div> --}}
</div>
</div>

<div class="commitment">
    <div class="container container11">
        <div class="container-inner">
            <div class="headingss">
                <h1 class="heading11">Our Commitment to You</h1>
                <p class="desc">Partnering with Goodiset means you have a reliable partner who stands by you at
                    every step. Our commitment is to ensure your success, so you can focus on building your business
                    and creating a beloved destination for Swedish candy in your community.</p>
            </div>
            <a href="#contact_us_form">    <button class="apply-btn">Apply Now</button> </a>
        </div>
    </div>
</div>
<script src="{{ asset('') }}front/Becomepartner.js"></script>
@endsection
