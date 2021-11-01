<footer>
    <section class="footer-info iq-pt-60">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="iq-footer-box text-left">
                        <div class="iq-icon">
                            <i aria-hidden="true" class="ion-ios-location-outline"></i>
                        </div>
                        <div class="footer-content">
                            <h4 class="iq-tw-6 iq-pb-10">Address</h4>
                            <p>2nd Floor, 125L, Block II , Khalid Bin Waleed Road, PECHS, Karachi.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 r4-mt-30">
                    <div class="iq-footer-box text-left">
                        <div class="iq-icon">
                            <i aria-hidden="true" class="ion-ios-telephone-outline"></i>
                        </div>
                        <div class="footer-content">
                            <h4 class="iq-tw-6 iq-pb-10">Phone</h4>
                            <p>(+92) 300 5498881
                                <br>Mon-Fri 12:00pm - 10:00pm
                                <br>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 r-mt-30">
                    <div class="iq-footer-box text-left">
                        <div class="iq-icon">
                            <i aria-hidden="true" class="ion-ios-email-outline"></i>
                        </div>
                        <div class="footer-content">
                            <h4 class="iq-tw-6 iq-pb-10">Mail</h4>
                            <p><a href="#" class="__cf_email__">info@itsolution24x7.com</a>
                                <br>24 X 7 online support
                                <br>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 align-self-center">
                    <ul class="info-share">
                        <li><a href="https://twitter.com/itsolution24x7"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="https://www.facebook.com/itsolution24by7"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="https://www.pinterest.com/itsolution24x7"><i class="fa fa-pinterest"></i></a></li>
                        <li><a href="https://www.tumblr.com/blog/itsolution24x7"><i class="fa fa-tumblr"></i></a></li>
                        <li><a href="https://www.linkedin.com/company/itsolution24x7"><i class="fa fa-linkedin"></i></a>
                        </li>
                        <li><a href="https://www.instagram.com/itsolution24x7/"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="https://www.reddit.com/user/itsolution24x7/"><i class="fa fa-reddit"></i></a></li>
                        <li><a href="https://mix.com/itsolution24x7"><i class="fa fa-mixcloud"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="row iq-mt-40">
                <div class="col-sm-12 text-center">
                    <div class="footer-copyright iq-ptb-20">Copyright @<span id="copyright">
 <!-- <script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script> -->
 <script>document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))</script>
 </span> <a href="javascript:void(0)" class="text-green">IT Solution 24x7.</a> All Rights Reserved
                    </div>
                </div>
            </div>
        </div>
    </section>
</footer>

<div id="back-to-top">
    <a class="top" id="top" href="#top"> <i class="ion-ios-upload-outline"></i> </a>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="{{url('public/js/admin/bootstrap3-wysihtml5.all.min.js')}}"></script>

<script src="{{url('public/js/admin/custom.js')}}"></script>

<script src="{{url('public/website/assets/js/popper.min.js')}}"></script>
<script src="{{url('public/website/assets/js/bootstrap.min.js')}}"></script>

<script src="{{url('public/website/assets/js/main.js')}}"></script>

<script src="{{url('public/website/assets/js/custom.js')}}"></script>

<script src="{{url('public/website/assets/js/style-customizer.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
@if(isset($exist))
    @if($exist == null)
        <script>
            $(document).ready(function () {
                console.log('ss');
                $(".nav-link").addClass("isDisabled");
            });
        </script>
    @endif()
@endif()

<script>


    $(document).ready(function () {

        $("#onetime").click(function () {
            $(".onetimecontent").show();
            $("#ongoing").removeClass("detail-active");
            $("#notsure").removeClass("detail-active");
            $(this).addClass("detail-active");
            $(".ongoingcontent").hide();
            val = $("input[name='describe']:checked").val();
            type = 1;
            $("#type").attr("value", type);
            other(val);
        });

        $("#ongoing").click(function () {
            $(".ongoingcontent").show();
            $("#onetime").removeClass("detail-active");
            $("#notsure").removeClass("detail-active");
            $(this).addClass("detail-active");
            $(".onetimecontent").hide();
            type = 2;
            $("#type").attr("value", type);
        });

        $("#notsure").click(function () {
            $("#onetime").removeClass("detail-active");
            $("#ongoing").removeClass("detail-active");
            $(this).addClass("detail-active");
            $(".ongoingcontent").hide();
            $(".onetimecontent").hide();
            type = 0;
            $("#type").attr("value", type);
        });

        $("input[name='describe']").click(function () {
            val = $("input[name='describe']:checked").val();
            other(val);
        });

        $("#specification").click(function () {

            $("#designs").removeClass("detail-active");
            $("#concept").removeClass("detail-active");
            $("#urgent").removeClass("detail-active");
            $(".specification-content").show();
            $(".design-content").hide();
            $(".concept-content").hide();
            $(this).addClass("detail-active");
            var stage = 1;
            $("#stage").attr("value", stage);
        });
        $("#designs").click(function () {
            $("#specification").removeClass("detail-active");
            $("#concept").removeClass("detail-active");
            $("#urgent").removeClass("detail-active");
            $(this).addClass("detail-active");
            $(".specification-content").hide();
            $(".design-content").show();
            $(".concept-content").hide();
            var stage = 2;
            $("#stage").attr("value", stage);
        });
        $("#concept").click(function () {
            $("#designs").removeClass("detail-active");
            $("#specification").removeClass("detail-active");
            $("#urgent").removeClass("detail-active");
            $(this).addClass("detail-active");
            $(".specification-content").hide();
            $(".design-content").hide();
            $(".concept-content").show();
            var stage = 3;
            $("#stage").attr("value", stage);
        });

        $("#urgent").click(function () {
            $("#designs").removeClass("detail-active");
            $("#specification").removeClass("detail-active");
            $("#concept").removeClass("detail-active");
            $(this).addClass("detail-active");
            $(".specification-content").hide();
            $(".design-content").hide();
            var stage = 4;
            $("#stage").attr("value", stage);
        });

        $("#payment").click(function () {
            $(this).toggleClass("detail-active");
            payp = $("#paypal").val();
            var paypal = 1;
            var payp;
            if (payp == null) {
                $("#paypal").attr('value', paypal);
            }
            if (payp == 1) {
                $("#paypal").attr('value', 0);
            }
            if (payp == 0) {
                $("#paypal").attr('value', 1);
            }
        });
        $("#cloud").click(function () {
            $(this).toggleClass("detail-active");
            payp = $("#cloudapi").val();
            var cloud = 1;
            var payp;
            if (payp == null) {
                $("#cloudapi").attr('value', cloud);
            }
            if (payp == 1) {
                $("#cloudapi").attr('value', 0);
            }
            if (payp == 0) {
                $("#cloudapi").attr('value', 1);
            }
        });
        $("#social").click(function () {
            $(this).toggleClass("detail-active");
            payp = $("#socialapi").val();
            var social = 1;
            var payp;
            if (payp == null) {
                $("#socialapi").attr('value', social);
            }
            if (payp == 1) {
                $("#socialapi").attr('value', 0);
            }
            if (payp == 0) {
                $("#socialapi").attr('value', 1);
            }
        });
        $("#otherapi").click(function () {
            $(this).toggleClass("detail-active");
            payp = $("#otherapii").val();
            var otherapi = 1;
            var payp;
            if (payp == null) {
                $("#otherapii").attr('value', otherapi);
            }
            if (payp == 1) {
                $("#otherapii").attr('value', 0);
            }
            if (payp == 0) {
                $("#otherapii").attr('value', 1);
            }
        });

        $("#entry").click(function () {
            $(this).addClass("detail-active");
            $("#intermediate").removeClass("detail-active");
            $("#expert").removeClass("detail-active");
            var amount = 1;
            $("#experience").attr('value', amount);
        });

        $("#intermediate").click(function () {
            $(this).addClass("detail-active");
            $("#entry").removeClass("detail-active");
            $("#expert").removeClass("detail-active");
            var amount = 2;
            $("#experience").attr('value', amount);
        });

        $("#expert").click(function () {
            $(this).addClass("detail-active");
            $("#intermediate").removeClass("detail-active");
            $("#entry").removeClass("detail-active");
            var amount = 3;
            $("#experience").attr('value', amount);
        });

        $("#morethan").click(function () {
            $("#lessthan").removeClass("detail-active");
            $("#dont").removeClass("detail-active");
            $(this).addClass("detail-active");
            var amount = 1;
            $("#time").attr('value', amount);
        });
        $("#lessthan").click(function () {
            $("#morethan").removeClass("detail-active");
            $("#dont").removeClass("detail-active");
            $(this).addClass("detail-active");
            var amount = 2;
            $("#time").attr('value', amount);
        });

        $("#dont").click(function () {
            $("#morethan").removeClass("detail-active");
            $("#lessthan").removeClass("detail-active");
            $(this).addClass("detail-active");
            var amount = 0;
            $("#time").attr('value', amount);

        });
        $(".clone_trigger").click(function () {
            $('.question').first().clone().insertBefore(".placer");
            $('input.cl:last').val('');
            event.preventDefault();
        });
        $("div").on("click", ".remove_trigger", function () {
            if ($(".question").length != 1) {
                $(this).closest('.question').remove();
                event.preventDefault();
            } else {
                event.preventDefault();
            }
        });

    });

    function other(val) {
        if (val == 5) {
            $('.othertext').show();
        } else {
            $('.othertext').hide();
        }
    }

    function goBack() {
        window.history.back();
    }


</script>
</body>

</html>