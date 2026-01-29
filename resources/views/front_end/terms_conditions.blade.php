@extends('front_end.template.layout')
@section('header')
@stop
@section('content')
<div class="body-overlay fs-wrapper search-form-overlay close-search-form"></div>
<!--header-end-->
<!--warpper-->
<div class="wrapper">
    <!--content-->
    <div class="content" style="background: #faf6f2;">
        <!--section-->
        <div class="section hero-section">
            <div class="hero-section-wrap inner-head">
                <div class="hero-section-wrap-item">
                    <div class="container">
                        <div class="hero-section-container">
                            <div class="hero-section-title_container">
                                <div class="hero-section-title">
                                    <h2>{{ $page_heading }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-wrap bg-hero bg-parallax-wrap-gradien fs-wrapper" data-scrollax-parent="true">
                        <div class="bg" data-bg="{{ asset('') }}front-assets/images/bg/12.jpg"
                            data-scrollax="properties: { translateY: '30%' }"></div>
                    </div>
                    <div class="svg-corner svg-corner_white" style="bottom:64px;right: 0;z-index: 100"></div>
                </div>
            </div>
        </div>
        <!--section-end-->

        <!--container-->
        <div class="container">
            <!--breadcrumbs-list-->
            <!--breadcrumbs-list end-->
        </div>
        <!--container end-->

        <!--main-content-->
        <div class="main-content ms_vir_height">
            <!--container-->
            <div class="container">
                <!--boxed-container-->
                <div class="boxed-container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card p-4">
                                <div class="agent-card-item_text-item text-start">
                                    <h4>Reservation</h4>
                                    <ul style="list-style-type: disc;">
                                        <li>A non-refundable reservation fee of half a month’s rent must be paid for the
                                            unit. This amount is non-refundable in case of cancellation.</li>
                                        <li>The reservation is valid for seven (7) days from the date the reservation
                                            fee is paid.</li>
                                        <li>The client must complete all rental procedures within the seven (7) day
                                            period.</li>
                                        <li>If the client fails to comply, the reservation will be automatically
                                            canceled, and the client will not be entitled to a refund of the reservation
                                            fee or any compensation from the company.</li>
                                    </ul>
                                </div>
                                <div class="agent-card-item_text-item text-start mt-3">
                                    <h4>Rental</h4>
                                    <ul style="list-style-type: disc;">
                                        <li>The tenant must pay the security deposit and administrative fees upon
                                            confirming the reservation.</li>
                                        <li>All paid amounts (including rent, security deposit, and administrative fees)
                                            are non-refundable in case of cancellation.</li>
                                        <li>The apartment is designated for residential use only and cannot be used for
                                            commercial or illegal purposes.</li>
                                        <li>The lease term specified in the agreement must be adhered to, and any
                                            extension must be coordinated in advance.</li>
                                        <li>The company reserves the right to amend the terms and conditions at any time
                                            with notification to tenants via the website.</li>
                                        <li>The client must ensure the monthly rent is paid on time.</li>
                                    </ul>
                                </div>
                                <h4 class="fs-5 fw-bold mt-3">Sales Terms and Conditions</h4>
                                <div class="agent-card-item_text-item text-start mt-3">
                                    <h4>Reservation</h4>
                                    <ul style="list-style-type: disc;">
                                        <li>A non-refundable reservation fee of 10,000 Qatari Riyals must be paid for
                                            the unit. This amount is non-refundable in case of cancellation.</li>
                                        <li>The reservation is valid for thirty (30) days from the date the reservation
                                            fee is paid.</li>
                                        <li>The client must complete all procedures for contract signing and payment of
                                            the due amount within the thirty (30) day period.</li>
                                        <li>If the client fails to comply, the reservation will be automatically
                                            canceled, and the client will not be entitled to a refund of the reservation
                                            fee or any compensation from the company.</li>
                                    </ul>
                                </div>
                                <div class="agent-card-item_text-item text-start mt-3">
                                    <h4>Purchase</h4>
                                    <ul style="list-style-type: disc;">
                                        <li>A down payment, along with non-refundable administrative fees, must be paid,
                                            which can be done electronically or through the company’s office. </li>
                                        <li>The client must pay all future installments according to the schedule
                                            outlined in the contract.</li>
                                        <li>The company reserves the right to take legal action in case of any breach of
                                            the contract terms.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--boxed-container end-->
            </div>
        </div>
        <!--main-content end-->
    </div>
    <!--content end-->
</div>
<!--wrapper end-->
@stop
@section('script')
@stop