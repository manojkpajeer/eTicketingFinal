        </div>
    </section>

    <!--footer section start-->
    <footer class="dashboard">
        <p>&copy 2022 DXB Tickets. All Rights Reserved.</p>
    </footer>
    
    <!-- move top -->
    <button onclick="topFunction()" id="movetop" class="bg-primary" title="Go to top">
    <span class="fa fa-angle-up"></span>
    </button>

    <script>
    window.onscroll = function () {
        scrollFunction()
    };

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("movetop").style.display = "block";
        } else {
        document.getElementById("movetop").style.display = "none";
        }
    }

    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
    </script>

    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/jquery-1.10.2.min.js"></script>

    <!-- chart js -->
    <script src="assets/js/Chart.min.js"></script>
    <script src="assets/js/utils.js"></script>

    <!-- Different scripts of charts.  Ex.Barchart, Stackedchart, Linechart, Piechart -->
    <script src="assets/js/bar.js"></script>
    <script src="assets/js/stacked.js"></script>
    <script src="assets/js/linechart.js"></script>
    <script src="assets/js/pie.js"></script>

    <!-- data tables js -->
    <script>
    $(document).ready(function () {
        $('#meastroTable').DataTable({
            pageLength: 10
        }
        );
    });
    </script>

    <script src="assets/js/jquery.dataTables.min.js"></script>

    <script src="assets/js/faq.js"></script>

    <script src="assets/js/jquery.nicescroll.js"></script>
    <script src="assets/js/scripts.js"></script>

    <!-- close script -->
    <script>
    var closebtns = document.getElementsByClassName("close-grid");
    var i;

    for (i = 0; i < closebtns.length; i++) {
        closebtns[i].addEventListener("click", function () {
        this.parentElement.style.display = 'none';
        });
    }
    </script>

    <!-- disable body scroll when navbar is in active -->
    <script>
    $(function () {
        $('.sidebar-menu-collapsed').click(function () {
        $('body').toggleClass('noscroll');
        })
    });
    </script>

    <!-- loading-gif Js -->
    <script src="assets/js/modernizr.js"></script>
    <script>
        $(window).load(function () {
            // Animate loader off screen
            $(".se-pre-con").fadeOut("slow");;
        });
    </script>

    <!-- Bootstrap Core JavaScript -->
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Bootstrap Validation -->
    <script>
        (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')

        Array.prototype.slice.call(forms)
            .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
            })
        })()
    </script>

</body>

</html>