@extends('front_end.template.layout')
@section('header')

@stop

@section('content')
    <div class="page-start"></div>

    <section class="pb-5 pt-4">

        <div class="container">
            <div class="row ">

                <div class="col-12 col-md-12 order-last order-md-0">

                    <div class="cart-box mb-3">
                        <div class="cart-box-header p-3">
                            <h6 class="text-white mb-0 text-uppercase">

                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-person-circle me-1" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                    <path fill-rule="evenodd"
                                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                </svg>Payment
                            </h6>
                        </div>
                            @if($status)
                            <div  class="row p-3">
                                <div class="col-6">
                                    <h4 class="text-success mb-1">Payment Successfull, Redirecting....! </h4>
                                </div>
                            </div>
                            @endif
                            @if(!$status)
                            <div class="row p-3">
                                <div class="col-6">
                                    <h4 class="text-danger mb-1">Payment Failed, Redirecting....!</h4>
                                </div>
                            </div>
                            @endif
                
                    </div>
              
                </div>

                
            </div>
        </div>
     
        
    </section>
@stop

@section('script')
<script>
    $(document).ready(function() {
        var m = '{{$msg}}';
        @if(!$status)
            toastr["error"](m);
            setTimeout(function() {
                    window.location='<?php echo url('/') . "/cart"; ?>'
            }, 2000);
        @endif    
        @if($status)
            toastr["success"](m);
            cart = [];
            updateLocalStorageCart();
            updateCartList();
            setTimeout(function() {
                    window.location='<?php echo url('/') . "/my-profile"; ?>'
            }, 2000);
        @endif    
      
    });

</script>
@stop
