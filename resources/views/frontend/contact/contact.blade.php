@extends('frontend.master_dashboard')
@section("main")

@section("title")
Contact Us Page
@endsection

@guest
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
            <span></span> Pages <span></span> Contact
        </div>
    </div>
</div>
<div class="breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
        
        </div>
    </div>
</div>
<p class="text-center mt-15 mb-15"> <b>For contact with admin. You Need To Login First <a href="{{ route('login')}}">Login Here </a> </b></p>
<div class="page-header breadcrumb-wrap">
    <div class="container">
        
    </div>
</div>
@else
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
            <span></span> Pages <span></span> Contact
        </div>
    </div>
</div>
<div class="page-content pt-50">

    <div class="container">
        <div class="row">
            <div class="col-xl-10 col-lg-12 m-auto">
                <section class="mb-50">

                    <div class="row">
                        <div class="col-xl-8">
                            <div class="contact-from-area padding-20-row-col">
                                <h5 class="text-brand mb-10">Contact Us</h5>

                                <p class="mb-30 font-sm">We'd love to hear from you! Reach out to us with any questions or concerns. *</p>
                                <form class="contact-form-style mt-30" id="contact-form" action="{{ route('contact.store') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="input-style mb-20">
                                                <input name="name" placeholder="Enter Your Full Name" type="text" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="input-style mb-20">
                                                <input name="email" placeholder="Your Email" type="email" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="input-style mb-20">
                                                <input name="telephone" placeholder="Your Phone" type="tel" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="input-style mb-20">
                                                <input name="subject" placeholder="Subject" type="text" />
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="textarea-style mb-30">
                                                <textarea name="message" placeholder="Message"></textarea>
                                            </div>
                                            <button class="submit submit-auto-width" type="submit">Send message</button>
                                        </div>
                                    </div>
                                </form>
                                <p class="form-messege"></p>
                            </div>
                        </div>
                        <div class="col-lg-4 pl-50 d-lg-block d-none">
                            <img class="border-radius-15 mt-50" src="assets/imgs/page/contact-2.png" alt="" />
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endguest


@endsection